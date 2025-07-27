@extends('layouts.app')

@section('title', 'Daftar Perusahaan')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Perusahaan</h1>
            <div class="d-none d-sm-block">
                <a href="{{ route('companies.create') }}" class="btn btn-success mb-3">Tambah Perusahaan</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Tabel Perusahaan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Kode</th>
                                <th>Nama Perusahaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($companies as $index => $company)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $company->code }}</td>
                                    <td>{{ $company->name }}</td>
                                    <td>
                                        <a href="{{ route('companies.edit', $company) }}"
                                            class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('companies.destroy', $company) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Hapus</button>
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
