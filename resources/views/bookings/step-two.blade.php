@extends('layouts.base')

@section('title', 'Booking Surat - Langkah 2')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-dark text-white font-weight-bold">
            Langkah 2: Detail Booking Surat
        </div>
        <div class="card-body">
            <div class="mb-3">
                <strong>Nama:</strong> {{ $employee->name }}<br>
                <strong>Nomor Karyawan:</strong> {{ $employee->employee_number }}<br>
                <strong>No HP:</strong> {{ $employee->phone_number }}<br>
                <strong>Departemen:</strong> {{ $employee->department->name ?? '-' }}<br>
                <strong>Divisi:</strong> {{ $employee->division->name ?? '-' }}
            </div>

            <form action="{{ route('bookings.complete') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="company_id">Perusahaan</label>
                    <select name="company_id" id="company_id" class="form-control" required>
                        <option value="">Pilih Perusahaan</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-2">
                    <label for="date_of_entry">Tanggal Booking</label>
                    <input type="date" name="date_of_entry" id="date_of_entry" class="form-control"
                        min="{{ now()->toDateString() }}" required>
                </div>

                <button type="submit" class="btn btn-success">Booking Sekarang</button>
            </form>
        </div>
    </div>
@endsection
