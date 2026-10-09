<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreMetric extends Model
{
    protected $table = "score_metrics";
    protected $fillable = ["company_id","key","name_de","value","unit"];

    public function report()
    {
        return $this->belongsTo(\App\Models\ScoreReport::class, "score_report_id");
    }
}