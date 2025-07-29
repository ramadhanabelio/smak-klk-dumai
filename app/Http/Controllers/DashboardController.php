<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\Company;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Department;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees     = Employee::count();
        $totalCompanies     = Company::count();
        $totalDepartments   = Department::count();
        $totalDivisions     = Division::count();
        $totalLetters       = Letter::count();

        $totalIncomingLetters = Letter::where('status', 'incoming')->count();
        $totalOutgoingLetters = Letter::where('status', 'outgoing')->count();
        $totalBookingLetters  = Letter::where('status', 'booking')->count();

        return view('dashboard', compact(
            'totalEmployees',
            'totalCompanies',
            'totalDepartments',
            'totalDivisions',
            'totalLetters',
            'totalIncomingLetters',
            'totalOutgoingLetters',
            'totalBookingLetters'
        ));
    }
}
