@extends('layouts.app')

@section('title', 'Tambah Surat Masuk')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Tambah Surat Keluar</h1>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <form action="{{ route('letters.incoming.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="company_id">Perusahaan</label>
                                <select name="company_id" id="company_id" class="form-control select2" required>
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type_id">Jenis Surat</label>
                                <select name="type_id" id="type_id" class="form-control select2" required>
                                    <option value="">Pilih Jenis Surat</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="sender_name">Nama Pengirim</label>
                                <input type="text" name="sender_name" id="sender_name" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="regarding">Perihal</label>
                                <input type="text" name="regarding" id="regarding" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="date_of_letter">Tanggal Surat</label>
                                <input type="date" name="date_of_letter" id="date_of_letter" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="date_of_entry">Tanggal Masuk</label>
                                <input type="date" name="date_of_entry" id="date_of_entry" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="department_id">Tujuan (Departemen)</label>
                                <select name="department_id" id="department_id" class="form-control select2" required>
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" data-employees='@json($department->employees)'>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="employee_id">Pegawai CC</label>
                                <select name="employee_id" id="employee_id" class="form-control select2" required>
                                    <option value="">Pilih Pegawai</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="file">Lampiran</label>
                                <input type="file" name="file" id="file" class="form-control-file"
                                    accept="image/*">
                            </div>

                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('letters.incoming.index') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%'
            });

            $('#department_id').on('change', function() {
                const employees = $('option:selected', this).data('employees') || [];
                const $employeeSelect = $('#employee_id');

                $employeeSelect.empty().append('<option value="">Pilih Pegawai</option>');
                employees.forEach(function(e) {
                    $employeeSelect.append(`<option value="${e.id}">${e.name}</option>`);
                });
            });
        });
    </script>
@endsection
