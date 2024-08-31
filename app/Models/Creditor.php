<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creditor extends Model
{
    protected $fillable = ['name', 'amount'];

    public function loans()
    {
        return $this->belongsToMany(Loan::class, 'loan_creditor')
            ->withPivot('amount')
            ->withTimestamps();
    }
}
