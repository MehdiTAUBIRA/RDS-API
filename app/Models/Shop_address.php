<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop_address extends Model
{
    use HasFactory;

    protected $table = 'shop_address';
    protected $dateFormat = 'd-m-Y H:i:s.v';
    protected $fillable = [
        'shop_id',
        'label',
        'address',
        'city',
        'postalcode',
        'country',
        'gps_x',
        'gps_y',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
      
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

}
