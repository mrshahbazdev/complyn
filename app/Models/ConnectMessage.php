<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectMessage extends Model
{
    protected $table = "connect_messages";
    protected $fillable = ["connect_request_id","user_id","body"];
}
