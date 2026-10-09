<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectRequest extends Model
{
    protected $table = "connect_requests";
    protected $fillable = ["company_id","user_id","title","description","status","connect_expert_id"];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function messages()
    {
        return $this->hasMany(\App\Models\ConnectMessage::class, "connect_request_id");
    }
    public function expert()
    {
        return $this->belongsTo(\App\Models\ConnectExpert::class, "connect_expert_id");
    }
}
