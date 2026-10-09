<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExchangeGroup extends Model
{
    protected $table = "exchange_groups";
    protected $fillable = ["name","topic"];

    public function topics()
    {
        return $this->hasMany(\App\Models\ExchangeTopic::class);
    }
}
