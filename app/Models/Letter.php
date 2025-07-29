<?php

namespace App\Models;

use App\Models\Type;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    protected $fillable = [
        'letter_number',
        'regarding',
        'attachment',
        'type_id',
        'department_id',
        'division_id',
        'employee_id',
        'sender_name',
        'date_of_letter',
        'date_of_entry',
        'note',
        'status',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
