<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyProgress extends Model
{
    protected $table = "academy_progress";
    protected $fillable = ["user_id","academy_lesson_id","completed_at"];
    protected $casts = ["completed_at" => "datetime"];

    public function lesson()
    {
        return $this->belongsTo(\App\Models\AcademyLesson::class, "academy_lesson_id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}