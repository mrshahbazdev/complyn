<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachSession extends Model
{
    protected $table = "coach_sessions";
    protected $fillable = ["company_id","user_id","topic"];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\CoachMessage::class, "coach_session_id");
    }
}