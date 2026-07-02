@extends('layouts.app')

@section('title', 'New Company')

@section('content')
    <h1>New Company</h1>

    <form method="POST" action="{{ route('companies.store') }}">
        @csrf

        <div style="margin-bottom: 1rem;">
            <label for="name">Company name</label><br>
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <button type="submit" class="btn btn-success">Create company</button>
    </form>
@endsection
