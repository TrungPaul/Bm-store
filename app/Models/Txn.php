<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Txn extends Model
{
    use HasFactory;

    const STAT_COMPLETED = 2;

    protected $table = 'txns';
    protected $fillable = [
        'user_id',
        'order_id',
        'ipn_id',
        'payment_id',
        'amount',
        'open_balance',
        'close_balance',
        'type',
        'status',
    ];
}
