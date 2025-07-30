@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Pegawai</h1>
            <a href="{{ route('employees.create') }}" class="btn btn-success">Tambah Pegawai</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Tabel Pegawai</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Nomor Pegawai</th>
                                <th>Nama</th>
                                <th>Departemen</th>
                                <th>Telepon</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $index => $employee)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $employee->employee_number }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->department->name ?? '-' }}</td>
                                    <td>{{ $employee->phone_number ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('employees.edit', $employee) }}"
                                            class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
