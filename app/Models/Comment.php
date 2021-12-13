<?php

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function Comments_reply()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
