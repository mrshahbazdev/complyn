<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachChecklist extends Model
{
    protected $table = "coach_checklists";
    protected $fillable = ["company_id","title","items"];
}
