@extends('layouts.app')

@section('content')
<h2 class="mb-3">Edit Profile</h2>
<form action="{{ route('profile.update') }}" method="POST">
    @csrf @method('PATCH')
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
    <a href="{{ route('profile.edit') }}" class="btn btn-link">Cancel</a>
</form>

<hr>
<h3>Delete Account</h3>
<form action="{{ route('profile.destroy') }}" method="POST">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('Delete account?');">Delete My Account</button>
</form>
@endsection