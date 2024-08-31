<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanCreditor extends Model
{
    protected $table = 'loan_creditor';

    protected $fillable = [
        'loan_id',
        'creditor_id',
        'amount',
    ];

    public $timestamps = true;

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }

    public function creditor()
    {
        return $this->belongsTo(Creditor::class, 'creditor_id');
    }
}
