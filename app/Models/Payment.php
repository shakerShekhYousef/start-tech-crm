<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
    use HasFactory;
    protected $table = "payments";
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'buyer_id',
        'property',
        'payment_amount',
        'payment_status',
        'date_of_payment',
        'total_amount'
    ];
    protected $guarded = [];
}
