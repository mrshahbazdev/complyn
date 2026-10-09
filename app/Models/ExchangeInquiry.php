<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeInquiry extends Model
{
    protected $table = "exchange_inquiries";
    protected $fillable = ["exchange_listing_id","user_id","message"];

    public function listing()
    {
        return $this->belongsTo(\App\Models\ExchangeListing::class, "exchange_listing_id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}