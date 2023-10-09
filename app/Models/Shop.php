<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $table = 'shop';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'siret' => 'required|unique:shop,siret',
        'shop_name',
        'contactname',
        'phone',
        'shop_name',
        'telecopy',
        'email',
	    'banner',
	    'profil_pic',
        'user_id',
	    'category',
        
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
      
    ];

    public function user()
    {
        return $this->belongsTo(User::class, user_id);
    }

    public function shop_address()
    {
        return $this->hasMany(Shop_address::class, 'shop_id');
    }

    public function post()
    {
        return $this->hasMany(Post::class, 'shop_id');
    }
    
    public function holidays()
    {
        return $this->hasMany(holidays::class, 'shop_id');
    }
    
}
