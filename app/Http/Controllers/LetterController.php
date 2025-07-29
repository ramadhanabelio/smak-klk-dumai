<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Letter;
use App\Models\Company;
use App\Models\Division;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    private function toRoman($month)
    {
        $map = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];
        return $map[$month] ?? '';
    }

    public function incomingIndex()
    {
        $letters = Letter::where('status', 'incoming')->latest()->get();
        return view('letters.incoming.index', compact('letters'));
    }

    public function createIncoming()
    {
        $types = Type::all();
        $departments = Department::with('employees')->get();
        return view('letters.incoming.create', compact('types', 'departments'));
    }

    public function storeIncoming(Request $request)
    {
        $request->validate([
            'type_id' => 'required|exists:types,id',
            'sender_name' => 'required|string',
            'regarding' => 'required|string',
            'date_of_letter' => 'required|date',
            'date_of_entry' => 'required|date|after_or_equal:date_of_letter',
            'department_id' => 'required|exists:departments,id',
            'employee_id' => 'required|exists:employees,id',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $department = Department::findOrFail($request->department_id);
        $departmentCode = $department->code ?? 'DPT';

        $count = Letter::where('status', 'incoming')
            ->whereYear('date_of_letter', now()->year)
            ->count() + 1;

        $number = str_pad($count, 3, '0', STR_PAD_LEFT);
        $romanMonth = $this->toRoman(now()->month);
        $year = now()->year;
        $letterNumber = "{$number}/{$departmentCode}/DMI/{$romanMonth}/{$year}";

        $filePath = null;
        if ($request->hasFile('attachment')) {
            $filePath = $request->file('attachment')->store('attachments', 'public');
        }

        Letter::create([
            'letter_number' => $letterNumber,
            'type_id' => $request->type_id,
            'sender_name' => $request->sender_name,
            'regarding' => $request->regarding,
            'date_of_letter' => $request->date_of_letter,
            'date_of_entry' => $request->date_of_entry,
            'department_id' => $request->department_id,
            'employee_id' => $request->employee_id,
            'attachment' => $filePath,
            'status' => 'incoming',
        ]);

        return redirect()->route('letters.incoming.index')->with('success', 'Surat masuk berhasil disimpan.');
    }

    public function destroyIncoming($id)
    {
        $letter = Letter::findOrFail($id);
        if ($letter->attachment && Storage::disk('public')->exists($letter->attachment)) {
            Storage::disk('public')->delete($letter->attachment);
        }
        $letter->delete();

        return redirect()->route('letters.incoming.index')->with('success', 'Surat masuk berhasil dihapus.');
    }

    public function outgoingIndex()
    {
        $letters = Letter::where('status', 'outgoing')->latest()->get();
        return view('letters.outgoing.index', compact('letters'));
    }

    public function createOutgoing()
    {
        $types = Type::all();
        $companies = Company::all();
        $departments = Department::with(['divisions', 'employees'])->get();

        return view('letters.outgoing.create', compact('types', 'departments', 'companies'));
    }

    public function storeOutgoing(Request $request)
    {
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'type_id' => 'required|exists:types,id',
            'department_id' => 'required|exists:departments,id',
            'division_id' => 'required|exists:divisions,id',
            'employee_id' => 'required|exists:employees,id',
            'regarding' => 'required|string',
            'date_of_letter' => 'required|date',
        ]);

        $department = Department::findOrFail($request->department_id);
        $company = Company::findOrFail($request->company_id);

        $departmentCode = $department->code;
        $companyCode = $company->code;

        $count = Letter::where('status', 'outgoing')
            ->whereYear('date_of_letter', now()->year)
            ->count() + 1;

        $number = str_pad($count, 3, '0', STR_PAD_LEFT);
        $romanMonth = $this->toRoman(now()->month);
        $year = now()->year;

        $letterNumber = "{$number}/{$departmentCode}/{$companyCode}/DMI/{$romanMonth}/{$year}";

        Letter::create([
            'letter_number' => $letterNumber,
            'company_id' => $request->company_id,
            'type_id' => $request->type_id,
            'department_id' => $request->department_id,
            'division_id' => $request->division_id,
            'employee_id' => $request->employee_id,
            'regarding' => $request->regarding,
            'date_of_letter' => $request->date_of_letter,
            'status' => 'outgoing',
        ]);

        return redirect()->route('letters.outgoing.index')->with('success', 'Surat keluar berhasil disimpan.');
    }

    public function destroyOutgoing($id)
    {
        $letter = Letter::findOrFail($id);
        $letter->delete();

        return redirect()->route('letters.outgoing.index')->with('success', 'Surat keluar berhasil dihapus.');
    }
}
