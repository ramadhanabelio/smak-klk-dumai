<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Letter;
use App\Models\Company;
use App\Models\Employee;
use App\Services\Telegram;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class BookingController extends Controller
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

    public function stepOne()
    {
        return view('bookings.step-one');
    }

    public function handleStepOne(Request $request)
    {
        $request->validate([
            'employee_number' => 'required',
            'phone_number' => 'required'
        ]);

        $employee = Employee::where('employee_number', $request->employee_number)
            ->where('phone_number', $request->phone_number)
            ->first();

        if (!$employee) {
            return back()->withErrors(['error' => 'Data tidak ditemukan.']);
        }

        Session::put('booking_employee', $employee->id);
        return redirect()->route('bookings.step.two');
    }

    public function stepTwo()
    {
        $companies = Company::all();
        $employeeId = Session::get('booking_employee');
        $employee = Employee::with(['department', 'division'])->findOrFail($employeeId);

        return view('bookings.step-two', compact('employee', 'companies'));
    }

    public function completeBooking(Request $request)
    {
        $request->validate([
            'date_of_entry' => 'required|date',
            'company_id'    => 'required|exists:companies,id'
        ]);

        $employeeId = Session::get('booking_employee');
        $employee = Employee::with(['department'])->findOrFail($employeeId);
        $company = Company::findOrFail($request->company_id);

        $entryDate = Carbon::parse($request->date_of_entry);
        $departmentCode = $employee->department->code ?? 'DPT';
        $companyCode = $company->code ?? 'CMP';

        $letterNumber = $this->generateGlobalLetterNumber($departmentCode, $companyCode, $request->date_of_entry);

        $letter = Letter::create([
            'letter_number'   => $letterNumber,
            'employee_id'     => $employee->id,
            'department_id'   => $employee->department_id,
            'division_id'     => $employee->division_id,
            'company_id'      => $company->id,
            'date_of_letter'  => now(),
            'date_of_entry'   => $entryDate,
            'status'          => 'booking',
        ]);

        $message = "<b>Booking Surat Baru</b>\n"
            . "<b>Nama:</b> {$employee->name}\n"
            . "<b>Nomor Karyawan:</b> " . ($employee->employee_number ?: '-') . "\n"
            . "<b>Departemen:</b> " . ($employee->department->name ?? '-') . "\n"
            . "<b>Perusahaan:</b> " . ($company->name ?? '-') . "\n"
            . "<b>Tanggal Booking:</b> " . $entryDate->format('d-m-Y') . "\n"
            . "<b>Nomor Surat:</b> {$letter->letter_number}";

        Telegram::sendMessage($message);

        Session::forget('booking_employee');

        return redirect()->route('bookings.success');
    }

    public function success()
    {
        return view('bookings.success');
    }
}
