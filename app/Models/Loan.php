<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'debtor_detail_id',
        'loan_date',
        'debtor_name',
        'loan_amount',
        'installments',
        'interest_rate',
        'repayment_method',
        'monthly_payment_amount',
        'notes',
    ];

    protected $attributes = [
        'installments' => null,
    ];

    /**
     * Get the creditors associated with the loan.
     */
    public function creditors()
    {
        return $this->belongsToMany(Creditor::class, 'loan_creditor')
            ->withPivot('amount')
            ->withTimestamps();
    }

    /**
     * Get the repayments associated with the loan.
     */
    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }

    /**
     * Get the debtor detail associated with the loan.
     */
    public function debtorDetail()
    {
        return $this->belongsTo(DebtorDetail::class, 'debtor_detail_id');
    }
}