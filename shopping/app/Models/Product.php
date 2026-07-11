<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'brand', 'price', 'notes'];

    protected $casts = [
        'price' => 'decimal:2',
    ];
}
