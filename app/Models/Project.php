<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['title','description','status','start_date','end_date'];

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps()->withPivot('role');
    }
}

