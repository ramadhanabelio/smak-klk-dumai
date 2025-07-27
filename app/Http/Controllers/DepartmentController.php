<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return view('departments.index', compact('departments'));
    }

    public function create()
    {
        return view('departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:departments,code',
            'name' => 'required|string|max:255',
        ]);

        Department::create($request->only('code', 'name'));

        return redirect()->route('departments.index')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'code' => 'required|unique:departments,code,' . $department->id,
            'name' => 'required|string|max:255',
        ]);

        $department->update($request->only('code', 'name'));

        return redirect()->route('departments.index')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Departemen berhasil dihapus.');
    }
}
