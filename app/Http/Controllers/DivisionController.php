<?php

namespace App\Http\Controllers;

use App\Models\Division;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DivisionController extends Controller
{
    public function index()
    {
        $divisions = Division::with('department')->get();
        return view('divisions.index', compact('divisions'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('divisions.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:divisions',
            'name' => 'required',
            'department_id' => 'required|exists:departments,id',
        ]);

        Division::create($request->all());

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil ditambahkan.');
    }

    public function edit(Division $division)
    {
        $departments = Department::all();
        return view('divisions.edit', compact('division', 'departments'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'code' => 'required|unique:divisions,code,' . $division->id,
            'name' => 'required',
            'department_id' => 'required|exists:departments,id',
        ]);

        $division->update($request->all());

        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil diperbarui.');
    }

    public function destroy(Division $division)
    {
        $division->delete();
        return redirect()->route('divisions.index')->with('success', 'Divisi berhasil dihapus.');
    }
}
