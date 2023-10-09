<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'cart_id',
        'user_id',
        'shop_id',
        'product_id',
        'quantity',
        'date_com',
        'product_name',
        'id_price',
        'price',
        'vat_id',
        'vat',
        'discount',
        'prix_ttc',
        'name',
        'status',
        'validation_date',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function cart()
    {
        return $this->belongsTo (cart::class, 'cart_id');
    }

    public function shop()
    {
        return $this->belongsTo (shop::class, 'user_id');
        return $this->belongsTo (shop::class, 'shop_id');
    }

    public function product()
    {
        return $this->belongsTo (product::class, 'product_id');
    }

    public function price()
    {
        return $this->belongsTo (price::class, 'id_price');
    }

    public function code_vat()
    {
        return $this->belongsTo (code_vat::class, 'vat_id');
    }

    
}
