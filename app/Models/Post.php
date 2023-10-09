<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\trait\Likable;

class Post extends Model
{
    //use App\trait\Likable;

    use HasFactory;
    protected $table = 'posts';
    protected $dateFormat = 'd-m-Y H:i:s';
    protected $fillable = [
        'title',
        'category',
        'content',
        'created_at',
        'shop_id',

    ];

    protected $hidden = [
        'updated_at'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

        public function comment()
    {
        return $this->HasMany(Comment::class, 'post_id');
    }

}
