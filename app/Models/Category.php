<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class Category extends Model
{
    CONST TAB_BM = 1;
    const TAB_VIA = 2;
    const TAB_CLONE = 3;

    use HasFactory, Filterable;

    protected $table= 'categories';
    protected $fillable = ['name', 'price', 'description', 'type', 'status'];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
