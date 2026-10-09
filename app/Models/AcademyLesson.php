<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyLesson extends Model
{
    protected $table = "academy_lessons";
    protected $fillable = ["academy_course_id","title","content","sort"];

    public function course()
    {
        return $this->belongsTo(\App\Models\AcademyCourse::class, "academy_course_id");
    }

    public function progress()
    {
        return $this->hasMany(\App\Models\AcademyProgress::class, "academy_lesson_id");
    }
}