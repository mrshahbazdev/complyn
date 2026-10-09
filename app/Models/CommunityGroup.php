<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityGroup extends Model
{
    protected $table = "community_groups";
    protected $fillable = ["company_id","name","description"];

    public function posts()
    {
        return $this->hasMany(\App\Models\CommunityPost::class, "community_group_id");
    }
}