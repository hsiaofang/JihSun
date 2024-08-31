<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repayment;
use App\Models\Loan;
use Carbon\Carbon;

class RepaymentController extends Controller
{

    public function index()
    {
        $repayments = Repayment::all();

        return view('repayments.index', compact('repayments'));
    }

    public function create()
    {
        $loans = Loan::all();
        return view('repayments.create', compact('loans'));
    }

    public function show(Repayment $repayment)
    {
        return view('repayments.show', compact('repayment'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'loan_id' => 'required|integer',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric',
        ]);

        $loanId = $request->input('loan_id');
        $paymentDate = $request->input('payment_date');
        $paymentAmount = $request->input('payment_amount');

        $currentDate = Carbon::now();
        $threeMonthsAgoEnd = $currentDate->copy()->subMonths(3)->endOfMonth();

        $loan = Loan::where('id', $loanId)
            ->where('loan_date', '<=', $threeMonthsAgoEnd)
            ->first();

        if (!$loan) {
            return redirect()->back()->with('error', '此月沒有此筆借款');
        }

        if ($loan->action === '已還款') {
            return redirect()->back()->with('error', '此借款已經還款');
        }

        if ($paymentAmount < $loan->monthly_payment_amount) {
            return redirect()->back()->with('error', '還款金額不足');
        }

        Repayment::create([
            'loan_id' => $loanId,
            'payment_date' => $paymentDate,
            'payment_amount' => $paymentAmount,
        ]);

        $loan->action = '已還款';
        $loan->save();

        return redirect()->route('repayments.create')->with('success', '還款成功');
    }

    // 本利攤
    private function calculateAmortizingTotal($principal, $annualInterestRate, $numberOfPayments)
    {
        $monthlyInterestRate = $annualInterestRate / 12 / 100;
        if ($monthlyInterestRate == 0) {
            return $principal / $numberOfPayments;
        }

        return $principal * $monthlyInterestRate / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
    }

    // 當前還款期數
    private function getCurrentRepaymentPeriod($loan)
    {
        return Repayment::where('loan_id', $loan->id)->count();
    }
}
