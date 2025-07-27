<div class="form-group">
    <label for="name">Nama Lengkap</label>
    <input type="text" name="name" class="form-control"
        value="{{ old('name', $employee->name ?? ($employee->user->name ?? '')) }}" required>
</div>

<div class="form-group">
    <label for="email">Email</label>
    <input type="email" name="email" class="form-control" value="{{ old('email', $employee->user->email ?? '') }}"
        required>
</div>

@if (!isset($employee))
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="form-group mb-3">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control" required>
    </div>
@else
    <div class="form-group">
        <label for="password">Password (opsional)</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="form-group mb-3">
        <label for="password_confirmation">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="form-control">
    </div>
@endif

<div class="form-group">
    <label for="phone_number">Nomor Telepon</label>
    <input type="text" name="phone_number" class="form-control"
        value="{{ old('phone_number', $employee->phone_number ?? '') }}">
</div>

<div class="form-group">
    <label for="place_of_birth">Tempat Lahir</label>
    <input type="text" name="place_of_birth" class="form-control"
        value="{{ old('place_of_birth', $employee->place_of_birth ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="date_of_birth">Tanggal Lahir</label>
    <input type="date" name="date_of_birth" class="form-control"
        value="{{ old('date_of_birth', $employee->date_of_birth ?? '') }}">
</div>

<div class="form-group">
    <label for="department_id">Departemen</label>
    <select name="department_id" class="form-control" required>
        <option value="">Pilih Departemen</option>
        @foreach ($departments as $dept)
            <option value="{{ $dept->id }}"
                {{ old('department_id', $employee->department_id ?? '') == $dept->id ? 'selected' : '' }}>
                {{ $dept->name }}
            </option>
        @endforeach
    </select>
</div>
