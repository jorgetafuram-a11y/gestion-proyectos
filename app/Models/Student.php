<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name','email','program'];

    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTimestamps()->withPivot('role');
    }
}

