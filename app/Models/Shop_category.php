<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop_category extends Model
{
    protected $table = 'shop_category';
    protected $dateFormat = 'd-m-Y H:i:s.v';
    protected $fillable = [
        'category',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
      
    ];


}
