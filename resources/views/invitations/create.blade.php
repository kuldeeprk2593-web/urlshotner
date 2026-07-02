@extends('layouts.app')

@section('title', 'Invite User')

@section('content')
    <h1>Invite a User</h1>

    <form method="POST" action="{{ route('invitations.store') }}">
        @csrf

        <div style="margin-bottom: 1rem;">
            <label for="name">Name</label><br>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="email">Email</label><br>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        @if ($isSuperAdmin)
            <div style="margin-bottom: 1rem;">
                <label for="company_id">Existing company</label><br>
                <select id="company_id" name="company_id" class="form-select">
                    <option value="">-- Select --</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @selected(old('company_id') == $company->id)>{{ $company->name }}</option>
                    @endforeach
                </select>
            </div> 

            <div style="margin-bottom: 1rem;">
                <label for="role">Role</label><br>
                <select id="role" name="role" required class="form-select">
                    <option value="admin" @selected(old('role') === 'admin')>Admin</option> 
                </select>
            </div>
        @else
            <p>This user will be invited into your company: <strong>{{ auth()->user()->company->name }}</strong></p>

            <div style="margin-bottom: 1rem;">
                <label for="role">Role</label><br>
                <select id="role" name="role" required class="form-select" aria-label="Default select example">
                    <option value="member" @selected(old('role') === 'admin')>Admin</option> 
                    <option value="member" @selected(old('role') === 'member')>Member</option> 
                </select>
                <p style="font-size: 0.85rem; color: #555;">As an Admin, you can only invite  another Admin or a Member.</p>
            </div>
        @endif

        <button type="submit" class="btn btn-success">Send invite</button>
    </form>
@endsection
