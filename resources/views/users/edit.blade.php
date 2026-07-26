@extends('adminlte::page')

@section('title', 'Edit User')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>
        <i class="fas fa-user-edit text-warning"></i>
        Edit User
    </h1>

    <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i>
        Back
    </a>
</div>
@stop

@section('content')

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Validation Error!</strong>
    <ul class="mb-0 mt-2">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card card-warning card-outline">
    <div class="card-header">
        <h3 class="card-title">
            Edit User Information
        </h3>
    </div>

    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card-body">

            <div class="form-group">
                <label>Name</label>
                <input
                    type="text"
                    name="name"
                    class="form-control"
                    value="{{ old('name', $user->name) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                    value="{{ old('email', $user->email) }}"
                    required>
            </div>

            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="User" {{ old('role', $user->role) == 'User' ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="form-group">
                <label>New Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-control">
                <small class="text-muted">
                    Leave blank if you don't want to change the password.
                </small>
            </div>

            <div class="form-group">
                <label>Confirm New Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="form-control">
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save"></i>
                Update User
            </button>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </form>
</div>

@stop