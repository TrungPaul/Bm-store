<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_CREATED = 1;
    const STATUS_VERIFIED = 2;
    const STATUS_WEBHOOK = 3;
    const STATUS_CANCEL = 4;

    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'payment_id',
        'amount',
        'amount_fee',
        'paypal_id',
        'token',
        'payer_id',
        'state',
        'created_at',
        'expired_at',
        'updated_at',
    ];
}
