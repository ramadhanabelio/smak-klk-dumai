@extends('layouts.app')

@section('title', 'Edit Surat Keluar')

@section('content')
    {{-- @dd($letter->company_id) --}}

    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">Edit Surat Keluar</h1>
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
                        <form action="{{ route('letters.outgoing.update', $letter->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="company_id">Perusahaan</label>
                                <select name="company_id" id="company_id" class="form-control select2" required>
                                    <option value="">Pilih Perusahaan</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ $company->id == $letter->company_id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="type_id">Jenis Surat</label>
                                <select name="type_id" id="type_id" class="form-control select2" required>
                                    <option value="">Pilih Jenis</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $letter->type_id == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="date_of_letter">Tanggal Surat</label>
                                <input type="date" name="date_of_letter" id="date_of_letter" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($letter->date_of_letter)->format('Y-m-d') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="department_id">Departemen</label>
                                <select name="department_id" id="department_id" class="form-control select2" required>
                                    <option value="">Pilih Departemen</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" data-divisions='@json($department->divisions)'
                                            data-employees='@json($department->employees)'
                                            {{ $letter->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="division_id">Divisi</label>
                                <select name="division_id" id="division_id" class="form-control select2" required>
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ $letter->division_id == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="employee_id">Pegawai</label>
                                <select name="employee_id" id="employee_id" class="form-control select2" required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}"
                                            {{ $letter->employee_id == $employee->id ? 'selected' : '' }}>
                                            {{ $employee->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="regarding">Perihal</label>
                                <input type="text" name="regarding" id="regarding" class="form-control"
                                    value="{{ $letter->regarding }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('letters.outgoing.index') }}" class="btn btn-secondary">Batal</a>
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
                const divisions = $('option:selected', this).data('divisions');
                const employees = $('option:selected', this).data('employees');

                $('#division_id').empty().append('<option value="">Pilih Divisi</option>');
                $('#employee_id').empty().append('<option value="">Pilih Pegawai</option>');

                if (divisions && Array.isArray(divisions)) {
                    divisions.forEach(d => {
                        $('#division_id').append(`<option value="${d.id}">${d.name}</option>`);
                    });
                }

                if (employees && Array.isArray(employees)) {
                    employees.forEach(e => {
                        $('#employee_id').append(`<option value="${e.id}">${e.name}</option>`);
                    });
                }
            });
        });
    </script>
@endsection
