<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeTopic extends Model
{
    protected $table = "exchange_topics";
    protected $fillable = ["exchange_group_id","user_id","title","body"];

    public function group()
    {
        return $this->belongsTo(\App\Models\ExchangeGroup::class, "exchange_group_id");
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Models\ExchangeTopicComment::class);
    }
}
