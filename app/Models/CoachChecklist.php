<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachChecklist extends Model
{
    protected $table = "coach_checklists";
    protected $fillable = ["company_id","title","items"];

    public function session()
    {
        return $this->belongsTo(\App\Models\CoachSession::class, "coach_session_id");
    }
}