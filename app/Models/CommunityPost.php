<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $table = "community_posts";
    protected $fillable = ["company_id","user_id","title","body"];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\CommunityComment::class, "community_post_id");
    }

    public function group()
    {
        return $this->belongsTo(\App\Models\CommunityGroup::class, "community_group_id");
    }
}