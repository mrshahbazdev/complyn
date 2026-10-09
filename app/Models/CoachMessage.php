<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachMessage extends Model
{
    protected $table = "coach_messages";
    protected $fillable = ["coach_session_id","role","content"];

    public function session()
    {
        return $this->belongsTo(\App\Models\CoachSession::class, "coach_session_id");
    }
}