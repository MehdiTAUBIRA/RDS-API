<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Working_days extends Model
{
    use HasFactory;
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'days',
        'open_hours',
        'closing_hours',
        'break_start',
        'break_end',
     ];
    protected $table = 'working_days';

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

   public function shop()
        {
            return $this->belongsTo (currency::class, 'shop_id');
        }
}
