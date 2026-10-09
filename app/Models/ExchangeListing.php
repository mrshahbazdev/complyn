<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeListing extends Model
{
    protected $table = "exchange_listings";
    protected $fillable = ["company_id","title","description","type","status"];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function inquiries()
    {
        return $this->hasMany(\App\Models\ExchangeInquiry::class, "exchange_listing_id");
    }
}