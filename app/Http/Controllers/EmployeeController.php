<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['user', 'department'])->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        $divisions = Division::with('department')->get();
        return view('employees.create', compact('divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'division_id'       => 'required|exists:divisions,id',
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|confirmed|min:6',
            'phone_number'      => 'nullable|string|max:20',
            'place_of_birth'    => 'nullable|string|max:100',
            'date_of_birth'     => 'nullable|date',
        ]);

        $lastEmployee = Employee::orderBy('id', 'desc')->first();
        $lastNumber = $lastEmployee ? intval(substr($lastEmployee->employee_number, 3)) : 0;
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        $employeeNumber = 'EMP' . $newNumber;

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Employee::create([
            'user_id'          => $user->id,
            'division_id' => $request->division_id,
            'employee_number'  => $employeeNumber,
            'name'             => $request->name,
            'phone_number'     => $request->phone_number,
            'place_of_birth'   => $request->place_of_birth,
            'date_of_birth'    => $request->date_of_birth,
        ]);

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil ditambahkan.');
    }

    public function edit(Employee $employee)
    {
        $divisions = Division::with('department')->get();
        return view('employees.edit', compact('employee', 'divisions'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'division_id'       => 'required|exists:divisions,id',
            'name'              => 'required|string|max:255',
            'email'             => 'required|email|unique:users,email,' . $employee->user_id,
            'password'          => 'nullable|confirmed|min:6',
            'phone_number'      => 'nullable|string|max:20',
            'place_of_birth'    => 'nullable|string|max:100',
            'date_of_birth'     => 'nullable|date',
        ]);

        $employee->user->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password
                ? Hash::make($request->password)
                : $employee->user->password,
        ]);

        $employee->update([
            'division_id' => $request->division_id,
            'name'            => $request->name,
            'phone_number'    => $request->phone_number,
            'place_of_birth'  => $request->place_of_birth,
            'date_of_birth'   => $request->date_of_birth,
        ]);

        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil diperbarui.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        $employee->user->delete();
        return redirect()->route('employees.index')->with('success', 'Pegawai berhasil dihapus.');
    }
}
