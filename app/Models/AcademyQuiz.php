<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyQuiz extends Model
{
    protected $table = "academy_quizzes";
    protected $fillable = ["academy_lesson_id","question","options","correct"];
    protected $casts = ["options" => "array"];

    public function lesson()
    {
        return $this->belongsTo(\App\Models\AcademyLesson::class, "academy_lesson_id");
    }
}
