<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Department;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();
        $totalCompanies = Company::count();
        $totalDepartments = Department::count();
        $totalDivisions = Division::count();

        return view('dashboard', compact(
            'totalEmployees',
            'totalCompanies',
            'totalDepartments',
            'totalDivisions'
        ));
    }
}
