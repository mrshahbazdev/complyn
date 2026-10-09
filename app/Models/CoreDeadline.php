<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreDeadline extends Model
{
    protected $table = "core_deadlines";
    protected $fillable = ["company_id","core_obligation_id","responsible_id","title","due_at","status"];
    protected $casts = ["due_at" => "date"];

    public function obligation()
    {
        return $this->belongsTo(\App\Models\CoreObligation::class, "core_obligation_id");
    }

    public function responsible()
    {
        return $this->belongsTo(\App\Models\User::class, "responsible_id");
    }
}
