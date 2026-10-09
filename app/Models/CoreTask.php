<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoreTask extends Model
{
    protected $table = "core_tasks";
    protected $fillable = ["company_id","assigned_to","title","due_at","status"];
    protected $casts = ["due_at" => "date"];

    public function assignee()
    {
        return $this->belongsTo(\App\Models\User::class, "assigned_to");
    }
}
