<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'product_name',
        'description',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function asset()
    {
        return $this->HasMany(Asset::class, 'asset_id');
    }

    public function product_category()
    {
        return $this->belongsTo(product_category::class, 'pcategory_id');
    }
}
