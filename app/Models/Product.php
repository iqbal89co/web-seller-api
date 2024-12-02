<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'unit',
        'barcode',
        'category_id',
        'brand_id',
        'writer_id',
        'selling_price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function writer()
    {
        return $this->belongsTo(User::class, 'writer_id', 'id');
    }
}