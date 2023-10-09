<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'comment',
        'author',
        'created_at',
    ];

    protected $hidden = [
        'updated_at'
    ];

    //public function user(){
    //    return $this->belongsto(user::class, 'user_id');
    //}

    public function post()
    {
        return $this->belongsto(Post::class, 'post_id');
    }

    
}
