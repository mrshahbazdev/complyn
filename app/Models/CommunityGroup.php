<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommunityGroup extends Model
{
    protected $table = "community_groups";
    protected $fillable = ["company_id","name","description"];
}
