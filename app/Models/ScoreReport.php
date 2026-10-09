<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreReport extends Model
{
    protected $table = "score_reports";
    protected $fillable = ["company_id","title","score","breakdown"];

    public function metrics()
    {
        return $this->hasMany(\App\Models\ScoreMetric::class, "score_report_id");
    }
}