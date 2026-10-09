<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyCourse extends Model
{
    protected $table = "academy_courses";
    protected $fillable = ["title","description"];

    public function lessons()
    {
        return $this->hasMany(\App\Models\AcademyLesson::class, "academy_course_id");
    }
}