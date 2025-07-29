<?php

namespace App\Models;

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];

    public function divisions()
    {
        return $this->hasMany(Division::class);
    }

    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Division::class);
    }
}
