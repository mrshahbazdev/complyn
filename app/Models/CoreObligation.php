<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreObligation extends Model
{
    protected $table = "core_obligations";
    protected $fillable = ["company_id","title","description","interval_months","next_due_at","status"];

    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    public function deadlines()
    {
        return $this->hasMany(\App\Models\CoreDeadline::class);
    }

    public function responsibilities()
    {
        return $this->hasMany(\App\Models\CoreResponsibility::class);
    }

    public function evidences()
    {
        return $this->hasMany(\App\Models\CoreEvidence::class);
    }
}
