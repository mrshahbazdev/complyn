<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityPost extends Model
{
    protected $table = "community_posts";
    protected $fillable = ["company_id","user_id","title","body"];
}
