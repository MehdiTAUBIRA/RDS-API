<?php

namespace App;

trait Likable
{

    public function scopeWithLikes(Builder $query)
    {
        $query->leftJoinSub(
            'select post_id, sum(liked) like, sum(!liked) dislikes from like group by post_id',
            'likes',
            'likes.post_id',
            'post.id'
        );
    }

    public function like($user = null, $liked =  '1')
    {
        $this->likes()->updateOrCreate([
            'user_id' => $user ? $user->id : auth()->id(),
        ], [
            'liked' => $liked,
        ]);
    }

    public function dislike($user = null)
    {
        return $this->like($user , '0');
    }

    public function isLikeBy(User $user)
    {
        return $user->likes->where('post_id', $this->id)->where('liked', '1')->count();
    }

    public function isDiLikeBy(User $user)
    {
        return $user->likes->where('post_id', $this->id)->where('liked', '0')->count();
    }

    public function likes()
    {
        return $this->HasMany(Like::class);
    }
}