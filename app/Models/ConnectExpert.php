<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectExpert extends Model
{
    protected $table = "connect_experts";
    protected $fillable = ["company_id","user_id","name","specialty","industry_id","location","experience_years","hourly_rate","availability","rating","bio"];

    public function industry()
    {
        return $this->belongsTo(\App\Models\Industry::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
