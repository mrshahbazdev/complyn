<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreMetric extends Model
{
    protected $table = "score_metrics";
    protected $fillable = ["company_id","key","name_de","value","unit"];
}
