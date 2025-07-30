@extends('layouts.app')

@section('title', 'Laporan Surat')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Laporan Surat</h1>

            <form action="{{ route('reports.index') }}" method="GET" class="form-inline">
                <select name="year" class="form-control mr-2">
                    @foreach ($years as $y)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Tampilkan</button>
                <a href="{{ route('reports.download', ['year' => $year]) }}" class="btn btn-danger ml-2" target="_blank">
                    Unduh PDF
                </a>
            </form>
        </div>

        <!-- Surat Masuk -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Laporan Surat Masuk - Tahun {{ $year }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Asal Surat / Pengirim</th>
                                <th>Perihal</th>
                                <th>Tanggal Surat</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($incoming as $i => $letter)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $letter->letter_number }}</td>
                                    <td>{{ $letter->sender_name }}</td>
                                    <td>{{ $letter->regarding }}</td>
                                    <td>{{ \Carbon\Carbon::parse($letter->date_of_letter)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($letter->date_of_entry)->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Surat Keluar -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Laporan Surat Keluar - Tahun {{ $year }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nomor Surat</th>
                                <th>Perihal</th>
                                <th>Tujuan</th>
                                <th>Tanggal Surat</th>
                                <th>Tanggal Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($outgoing as $i => $letter)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $letter->letter_number }}</td>
                                    <td>{{ $letter->regarding }}</td>
                                    <td>{{ $letter->employee->name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($letter->date_of_letter)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($letter->created_at)->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Data tidak ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
