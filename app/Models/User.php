<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable /*implements MustVerifyEmail*/
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'name'=> 'required|Regex:/^[\D]+$/i|unique:users, name|max:100',
        'last_name'=> 'required|Regex:/^[\D]+$/i|max:100',
        'first_name'=> 'required|Regex:/^[\D]+$/i|max:100',
        'gender',
        'email'=> 'required|email:rfc|max:255|unique:users,email',
        'password',
        'birthdate',
        'telecopy',
        'phone',
        'siren' => 'nullable|unique:users, siren',
        'statut',
        'state',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'state'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function provider()
    {
        return $this->hasMany(Provider::class,'user_id','id');
    }

    public function user_address()
    {
        return $this->hasMany(User_address::class, 'user_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function shop()
    {
        return $this->hasMany(Shop::class );
    }

    public function shop_address()
    {
        return $this->hasManyThrough(Shop_address::class, Shop::class, 'user_id' );
    }

}
