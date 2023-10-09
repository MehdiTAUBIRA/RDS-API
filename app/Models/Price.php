<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'Price',
        'start_date',
        'end_date',
        'id_cur',
        'user_id',
     ];
    protected $table = 'price';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

   public function currency()
        {
            return $this->belongsTo (currency::class, 'id_cur');
        }
}
