<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityComment extends Model
{
    protected $table = "community_comments";
    protected $fillable = ["community_post_id","user_id","body"];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function post()
    {
        return $this->belongsTo(\App\Models\CommunityPost::class, "community_post_id");
    }
}