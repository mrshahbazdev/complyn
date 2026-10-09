<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeTopicComment extends Model
{
    protected $table = "exchange_topic_comments";
    protected $fillable = ["exchange_topic_id","user_id","body"];

    public function topic()
    {
        return $this->belongsTo(\App\Models\ExchangeTopic::class, "exchange_topic_id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
