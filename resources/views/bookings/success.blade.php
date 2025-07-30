@extends('layouts.base')

@section('title', 'Booking Berhasil')

@section('content')
    <div class="container text-center">
        <h3 class="text-success">Booking Berhasil!</h3>
        <p>Surat Anda telah dibooking. Silakan tunggu proses selanjutnya.</p>
        <a href="{{ route('bookings.step.one') }}" class="btn btn-success">Booking Lagi</a>
    </div>
@endsection
