<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachSession extends Model
{
    protected $table = "coach_sessions";
    protected $fillable = ["company_id","user_id","topic"];
}
