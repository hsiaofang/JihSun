<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebtorDetail extends Model
{
    protected $fillable = [
        'phone',
        'address',
    ];

    /**
     * Get the loans associated with the debtor detail.
     */
    public function loans()
    {
        return $this->hasMany(Loan::class, 'debtor_detail_id');
    }
}