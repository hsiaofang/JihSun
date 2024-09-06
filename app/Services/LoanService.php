<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\DebtorDetail;
use Carbon\Carbon;

class LoanService
{
    public function calculateMonthlyPayment($loanAmount, $interestRate, $installments, $repaymentMethod)
    {
        if ($repaymentMethod == 'principal_and_interest') {
            return $this->calculateAmortizingTotal($loanAmount, $interestRate, $installments);
        } elseif ($repaymentMethod == 'interest_only') {
            return ($loanAmount * $interestRate) / 100 / 12;
        }
        return 0;
    }

    private function calculateAmortizingTotal($principal, $annualInterestRate, $numberOfPayments)
    {
        $monthlyInterestRate = $annualInterestRate / 12 / 100;
        $monthlyPayment = $principal * $monthlyInterestRate / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
        return $monthlyPayment;
    }

    public function calculateLoanBalance(Loan $loan)
    {
        $currentDate = Carbon::now();
        $loanStartDate = Carbon::parse($loan->loan_date);
        $monthsElapsed = min($loanStartDate->diffInMonths($currentDate), $loan->installments);

        $remainingPrincipal = $loan->loan_amount;

        for ($i = 0; $i < $monthsElapsed; $i++) {
            $monthlyInterest = $remainingPrincipal * ($loan->interest_rate / 12 / 100);
            $monthlyPrincipal = $this->calculateAmortizingTotal($loan->loan_amount, $loan->interest_rate, $loan->installments) - $monthlyInterest;
            $remainingPrincipal -= $monthlyPrincipal;
        }

        return max($remainingPrincipal, 0);
    }

    public function createDebtorDetail($loanId, $phone = null, $address = null)
    {
        if ($phone || $address) {
            DebtorDetail::create([
                'loan_id' => $loanId,
                'phone' => $phone,
                'address' => $address,
            ]);
        }
    }
}
