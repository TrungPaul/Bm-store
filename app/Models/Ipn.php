<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ipn extends Model
{
    use HasFactory;

    protected $table = 'ipns';
    protected $fillable = [
        'order_id',
        'user_id',
        'event_id',
        'paypal_id',
        'amount',
        'amount_fee',
        'event_type',
        'summary',
        'log',
        'status'
    ];
}
