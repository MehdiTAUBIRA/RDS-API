<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
Use Carbon\Carbon;

class User_address extends Model
{
    use HasFactory;

    protected $table = 'user_address';
    protected $dateFormat = 'd-m-Y H:i:s.v';
    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
