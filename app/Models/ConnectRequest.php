<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConnectRequest extends Model
{
    protected $table = "connect_requests";
    protected $fillable = ["company_id","user_id","title","description","status"];
}
