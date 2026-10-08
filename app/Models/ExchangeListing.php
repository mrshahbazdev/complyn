<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeListing extends Model
{
    protected $table = "exchange_listings";
    protected $fillable = ["company_id","title","description","type","status"];
}
