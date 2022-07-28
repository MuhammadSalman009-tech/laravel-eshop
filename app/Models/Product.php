<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="products";
    protected $fillable=[
        'name',
        'shortDescription',
        'longDescription',
        'regularPrice',
        'salePrice',
        'sku',
        'stockStatus',
        'featured',
        'quantity',
        'category',
        "image"
    ];
    public function category(){
        return $this->belongsTo(Category::class,"category_id");
    }
}
