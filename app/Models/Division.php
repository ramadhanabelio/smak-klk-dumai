<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'code',
        'name',
        'department_id',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
