<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'id_fb',
        'category_id',
        'sell',
        'id_user_buy',
        'name_user',
        'data',
        'date',
        'date_sell'
    ];
}
