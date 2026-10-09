<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyAttempt extends Model
{
    protected $table = "academy_attempts";
    protected $fillable = ["academy_lesson_id","user_id","score","passed"];
    protected $casts = ["passed" => "boolean"];

    public function lesson()
    {
        return $this->belongsTo(\App\Models\AcademyLesson::class, "academy_lesson_id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
