<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademyLesson extends Model
{
    protected $table = "academy_lessons";
    protected $fillable = ["academy_course_id","title","content","sort"];
}
