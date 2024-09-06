<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LoanService;
use App\Models\Loan;
use App\Models\Creditor;
use App\Models\DebtorDetail;
use App\Models\Repayment;
use Carbon\Carbon;
use App\Events\RepaymentNotification;

class LoanController extends Controller
{

    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $loansQuery = Loan::with(['debtorDetail', 'creditors']);
        if ($search) {
            $loansQuery->where(function ($query) use ($search) {
                $query->where('debtor_name', 'like', "%{$search}%")
                    ->orWhere('loan_amount', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // 分頁
        $loans = $loansQuery->paginate(10);

        // 計算貸款餘額跟已償還的本金
        foreach ($loans as $loan) {
            $loanBalance = $this->loanService->calculateLoanBalance($loan);
            $loan->loan_balance = $loanBalance;
            $loan->repaid_principal = $loan->loan_amount - $loanBalance;
        }

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $creditors = Creditor::all();
        return view('loans.create', compact('creditors'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'loan_date' => 'required|date',
            'debtor_name' => 'required|string|max:255',
            'loan_amount' => 'required|numeric|min:0',
            'installments' => 'nullable|integer|min:1',
            'interest_rate' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'repayment_method' => 'required|in:principal_and_interest,interest_only',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'creditors' => 'nullable|array',
            'creditors.*.creditor_id' => 'nullable|exists:creditors,id',
            'creditors.*.amount' => 'nullable|numeric|min:0',
        ]);

        $debtorDetail = DebtorDetail::create([
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
        ]);

        $loan = Loan::create([
            'loan_date' => $validatedData['loan_date'],
            'debtor_name' => $validatedData['debtor_name'],
            'loan_amount' => $validatedData['loan_amount'],
            'installments' => $validatedData['installments'],
            'interest_rate' => $validatedData['interest_rate'],
            'monthly_payment_amount' => $this->loanService->calculateMonthlyPayment(
                $validatedData['loan_amount'],
                $validatedData['interest_rate'],
                $validatedData['installments'],
                $validatedData['repayment_method']
            ),
            'notes' => $validatedData['notes'],
            'repayment_method' => $validatedData['repayment_method'],
            'debtor_detail_id' => $debtorDetail->id,
        ]);

        if (!empty($validatedData['creditors'])) {
            foreach ($validatedData['creditors'] as $creditor) {
                $loan->creditors()->attach($creditor['creditor_id'], ['amount' => floatval($creditor['amount'])]);
            }
        }

        return redirect()->route('loans.create')->with('success', '新增成功');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'field' => 'required|string|in:loan_date,debtor_name,loan_amount,installments,interest_rate,notes,repayment_method',
            'value' => 'required|string',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->{$validatedData['field']} = $validatedData['value'];
        $loan->save();

        return response()->json(['success' => true, 'message' => '更新成功']);
    }

    public function currentMonth()
    {
        $currentDate = Carbon::now();
        $threeMonthsAgo = $currentDate->copy()->subMonths(3);

        $loans = Loan::where('loan_date', '<=', $threeMonthsAgo)
            ->where('installments', '>', 0)
            ->get(['loan_date', 'debtor_name', 'monthly_payment_amount', 'action']);

        $totalInterest = $loans->where('action', '!=', '已還款')->sum('monthly_payment_amount');

        foreach ($loans as $loan) {
            event(new RepaymentNotification('Hello, this is a test message!'));
        }

        return view('loans.current-month', compact('loans', 'currentDate', 'totalInterest'));
    }
    private function calculateAmountDue($loan, $currentDate)
    {
        $installments = $loan->installments;
        $monthlyAmount = $loan->loan_amount / $installments;

        $loanStartDate = Carbon::parse($loan->loan_date);
        $periodsElapsed = $loanStartDate->diffInMonths($currentDate);

        return max(0, $monthlyAmount * ($installments - $periodsElapsed));
    }
}
