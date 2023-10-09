<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class holidays extends Model
{
    use HasFactory;
    protected $table = 'holidays';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'start_date',
        'end_date',
        'shop_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
