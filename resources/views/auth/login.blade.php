@extends('layouts.app')

@section('title', 'Log in')

@section('content')
    <h1>Log in</h1>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div style="margin-bottom: 1rem;">
            <label for="email">Email</label><br>
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div style="margin-bottom: 1rem;">
            <label for="password">Password</label><br>
            <input id="password" class="form-control" type="password" name="password" required>
        </div>

        <div style="margin-bottom: 1rem;">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Log in</button>
    </form>

    <table class="table">
        <thead>
            <tr>
                <td>Sr.no</td>
                <td>Role</td>
                <td>Email</td>
                <td>Password</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>Super Admin</td>
                <td>superadmin@sembark.com</td>
                <td>password</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Admin</td>
                <td>admin@sembark.com</td>
                <td>password</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Member</td>
                <td>member@sembark.com</td>
                <td>password</td>
            </tr> 
        </tbody>
    </table>
@endsection
