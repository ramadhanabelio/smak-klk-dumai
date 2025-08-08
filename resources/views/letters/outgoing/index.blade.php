@extends('layouts.app')

@section('title', 'Daftar Surat Keluar')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Surat Keluar</h1>
            <a href="{{ route('letters.outgoing.create') }}" class="btn btn-success">Tambah Surat Keluar</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Tabel Surat Keluar</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Nomor Surat</th>
                                <th>Tanggal Surat</th>
                                <th>Perihal</th>
                                <th>Jenis Surat</th>
                                <th>Departemen</th>
                                <th>Divisi</th>
                                <th>Karyawan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($letters as $index => $letter)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}.</td>
                                    <td>{{ $letter->letter_number }}</td>
                                    <td>{{ \Carbon\Carbon::parse($letter->date_of_letter)->format('d M Y') }}</td>
                                    <td>{{ $letter->regarding }}</td>
                                    <td>{{ $letter->type->name ?? '-' }}</td>
                                    <td>{{ $letter->department->name ?? '-' }}</td>
                                    <td>{{ $letter->division->name ?? '-' }}</td>
                                    <td>{{ $letter->employee->name ?? '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                            data-target="#detailModal{{ $letter->id }}">
                                            Detail
                                        </button>

                                        <div class="modal fade" id="detailModal{{ $letter->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="detailModalLabel{{ $letter->id }}"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title font-weight-bold"
                                                            id="detailModalLabel{{ $letter->id }}">Detail Surat Keluar
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Tutup">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table table-bordered">
                                                            <tr>
                                                                <th>Nomor Surat</th>
                                                                <td>{{ $letter->letter_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Jenis Surat</th>
                                                                <td>{{ $letter->type->name ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Tanggal Surat</th>
                                                                <td>{{ \Carbon\Carbon::parse($letter->date_of_letter)->format('d M Y') }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Departemen</th>
                                                                <td>{{ $letter->department->name ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Divisi</th>
                                                                <td>{{ $letter->division->name ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Pegawai</th>
                                                                <td>{{ $letter->employee->name ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Perusahaan Tujuan</th>
                                                                <td>{{ $letter->purpose }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Perihal</th>
                                                                <td>{{ $letter->regarding }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Lampiran</th>
                                                                <td>
                                                                    @if ($letter->file)
                                                                        <a href="{{ asset('storage/' . $letter->file) }}"
                                                                            target="_blank">Lihat Lampiran</a>
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Tutup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form action="{{ route('letters.outgoing.destroy', $letter->id) }}" method="POST"
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
