<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Type;
use App\Models\Letter;
use App\Models\Company;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    private function toRoman($month)
    {
        $roman = [
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
        return $roman[$month] ?? '';
    }

    private function generateGlobalLetterNumber($departmentCode, $companyCode = 'CMP', $date = null)
    {
        $date = $date ? Carbon::parse($date) : now();
        $year = $date->year;
        $romanMonth = $this->toRoman($date->month);

        $lastLetter = Letter::orderByDesc('created_at')
            ->whereNotNull('letter_number')
            ->pluck('letter_number')
            ->first();

        if ($lastLetter && preg_match('/^(\d{3})\//', $lastLetter, $matches)) {
            $nextNumber = str_pad(((int)$matches[1]) + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        return "{$nextNumber}/{$departmentCode}/{$companyCode}/DMI/{$romanMonth}/{$year}";
    }

    public function incomingIndex()
    {
        $letters = Letter::where('status', 'incoming')->latest()->get();

        return view('letters.incoming.index', compact('letters'));
    }

    public function createIncoming()
    {
        $types = Type::all();
        $companies = Company::all();
        $departments = Department::all();
        $employees = Employee::all(); // Load all employees for manual selection

        return view('letters.incoming.create', compact('types', 'departments', 'companies', 'employees'));
    }

    public function storeIncoming(Request $request)
    {
        $request->validate([
            'letter_number'  => 'required|string|max:255|unique:letters,letter_number',
            'company_id'     => 'required|exists:companies,id',
            'type_id'        => 'required|exists:types,id',
            'sender_name'    => 'required|string|max:255',
            'regarding'      => 'required|string|max:255',
            'date_of_letter' => 'required|date',
            'date_of_entry'  => 'required|date',
            'department_id'  => 'required|exists:departments,id',
            'employee_id'    => 'nullable|exists:employees,id',
            'file'           => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('attachments', 'public');
        }

        Letter::create([
            'letter_number'   => $request->letter_number,
            'type_id'         => $request->type_id,
            'sender_name'     => $request->sender_name,
            'regarding'       => $request->regarding,
            'date_of_letter'  => $request->date_of_letter,
            'date_of_entry'   => $request->date_of_entry,
            'department_id'   => $request->department_id,
            'employee_id'     => $request->employee_id,
            'company_id'      => $request->company_id,
            'attachment'      => $path,
            'status'          => 'incoming',
        ]);

        return redirect()->route('letters.incoming.index')->with('success', 'Surat masuk berhasil ditambahkan.');
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
            'company_id'     => 'required|exists:companies,id',
            'type_id'        => 'required|exists:types,id',
            'department_id'  => 'required|exists:departments,id',
            'division_id'    => 'required|exists:divisions,id',
            'employee_id'    => 'required|exists:employees,id',
            'regarding'      => 'required|string',
            'purpose'        => 'nullable|string|max:255',
            'date_of_letter' => 'required|date',
        ]);

        $department = Department::findOrFail($request->department_id);
        $company    = Company::findOrFail($request->company_id);

        $departmentCode = $department->code ?? 'DPT';
        $companyCode    = $company->code ?? 'CMP';

        $letterNumber = $this->generateGlobalLetterNumber($departmentCode, $companyCode, $request->date_of_letter);

        Letter::create([
            'letter_number'   => $letterNumber,
            'company_id'      => $request->company_id,
            'type_id'         => $request->type_id,
            'department_id'   => $request->department_id,
            'division_id'     => $request->division_id,
            'employee_id'     => $request->employee_id,
            'regarding'       => $request->regarding,
            'purpose'         => $request->purpose,
            'date_of_letter'  => $request->date_of_letter,
            'status'          => 'outgoing',
        ]);

        return redirect()->route('letters.outgoing.index')->with('success', 'Surat keluar berhasil disimpan.');
    }

    public function destroyOutgoing($id)
    {
        $letter = Letter::findOrFail($id);
        $letter->delete();

        return redirect()->route('letters.outgoing.index')->with('success', 'Surat keluar berhasil dihapus.');
    }

    public function bookingIndex()
    {
        $letters = Letter::where('status', 'booking')->with('employee')->latest()->get();
        return view('letters.booking.index', compact('letters'));
    }
}
