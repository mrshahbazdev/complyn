<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreResponsibility extends Model
{
    protected $table = "core_responsibilities";
    protected $fillable = ["company_id","core_obligation_id","user_id","role"];

    public function obligation()
    {
        return $this->belongsTo(\App\Models\CoreObligation::class, "core_obligation_id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
