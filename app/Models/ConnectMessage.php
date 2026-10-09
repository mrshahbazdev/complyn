<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectMessage extends Model
{
    protected $table = "connect_messages";
    protected $fillable = ["connect_request_id","user_id","body"];

    public function request()
    {
        return $this->belongsTo(\App\Models\ConnectRequest::class, "connect_request_id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}