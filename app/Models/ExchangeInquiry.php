<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeInquiry extends Model
{
    protected $table = "exchange_inquiries";
    protected $fillable = ["exchange_listing_id","user_id","message"];
}
