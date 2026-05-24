<div class="col-md-6">
    <label for="full_name" class="form-label">Full Name</label>
    <input id="full_name" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $user?->full_name) }}" required>
    @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
    <label for="email" class="form-label">Email</label>
    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user?->email) }}" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
    <label for="role" class="form-label">Role</label>
    <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
        @foreach (['admin' => 'Admin', 'council' => 'Council', 'citizen' => 'Citizen'] as $value => $label)
            <option value="{{ $value }}" @selected(old('role', $user?->role ?? 'citizen') === $value)>{{ $label }}</option>
        @endforeach
    </select>
    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
    <label for="password" class="form-label">Password {{ $user ? '(leave blank to keep current)' : '' }}</label>
    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $user ? '' : 'required' }}>
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
    <label for="password_confirmation" class="form-label">Confirm Password</label>
    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" {{ $user ? '' : 'required' }}>
</div>
