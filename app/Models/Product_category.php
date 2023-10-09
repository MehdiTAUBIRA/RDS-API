<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_category extends Model
{
    use HasFactory;
    protected $table = 'Product_category';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'lib_cat',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo (Product::class, 'product_id');
    }
}
