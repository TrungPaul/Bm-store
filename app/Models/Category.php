<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use EloquentFilter\Filterable;

class Category extends Model
{
    use HasFactory, Filterable;

    protected $table= 'categories';
    protected $fillable = ['name', 'price', 'description', 'type', 'status'];
}
