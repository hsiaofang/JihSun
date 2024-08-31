<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    protected $table = 'repayments';

    protected $fillable = [
        'loan_id',
        'payment_date',
        'payment_amount',
        'notes',
    ];

    protected $hidden = [];

    public $timestamps = true;

    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id');
    }
}
