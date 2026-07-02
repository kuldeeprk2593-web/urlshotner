@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Welcome, {{ $user->name }}</h1>
    <p>Role: <strong>{{ $user->role->label() }}</strong></p>
    @if ($user->company)
        <p>Company: <strong>{{ $user->company->name }}</strong></p>
    @endif

    <ul>
        @if ($user->isSuperAdmin())
            <li><a href="{{ route('companies.index') }}">Manage companies</a></li>
            <li><a href="{{ route('invitations.create') }}">Invite a user into a company</a></li>
        @endif

        @if ($user->isAdmin())
            <li><a href="{{ route('invitations.create') }}">Invite a Another Admin/Member user into your company</a></li> 
        @endif
 

        @if ($user->canCreateShortUrls())
            <li><a href="{{ route('short-urls.create') }}">Create a new short url</a></li>
            <li><a href="{{ route('short-urls.index') }}">View your short urls</a></li>
        @endif
    </ul>
@endsection
