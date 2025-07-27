<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:companies,code',
            'name' => 'required|string|max:255',
        ]);

        Company::create($request->only('code', 'name'));

        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        $request->validate([
            'code' => 'required|unique:companies,code,' . $company->id,
            'name' => 'required|string|max:255',
        ]);

        $company->update($request->only('code', 'name'));

        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil diperbarui.');
    }

    public function destroy(Company $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Perusahaan berhasil dihapus.');
    }
}
