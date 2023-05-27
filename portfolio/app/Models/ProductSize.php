<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_product_size', 'size_id', 'product_id');
    }
}
