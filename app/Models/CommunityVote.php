<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityVote extends Model
{
    protected $table = "community_votes";
    protected $fillable = ["community_comment_id","user_id"];

    public function comment()
    {
        return $this->belongsTo(CommunityComment::class, "community_comment_id");
    }
}
