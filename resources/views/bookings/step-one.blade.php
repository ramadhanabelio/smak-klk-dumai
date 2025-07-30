@extends('layouts.base')

@section('title', 'Booking Surat - Langkah 1')

@section('content')
    <div class="card shadow">
        <div class="card-header bg-dark text-white font-weight-bold">
            Langkah 1: Verifikasi Pegawai
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif

            <form action="{{ route('bookings.handle.step.one') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Nomor Karyawan</label>
                    <input type="text" name="employee_number" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nomor HP</label>
                    <input type="text" name="phone_number" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-success">Lanjut</button>
            </form>
        </div>
    </div>
@endsection
