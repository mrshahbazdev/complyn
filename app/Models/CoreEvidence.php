<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreEvidence extends Model
{
    protected $table = "core_evidences";
    protected $fillable = ["company_id","core_obligation_id","file_id","title","note"];

    public function obligation()
    {
        return $this->belongsTo(\App\Models\CoreObligation::class, "core_obligation_id");
    }

    public function file()
    {
        return $this->belongsTo(\App\Models\File::class);
    }
}
