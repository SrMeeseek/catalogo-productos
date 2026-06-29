<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'unit', 'observations', 'brand_id', 'stock', 'price', 'image'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
