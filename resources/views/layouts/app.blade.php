<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sembark URL Shortener')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="font-family: sans-serif; max-width: 800px; margin: 2rem auto; padding: 0 1rem;">

    @auth
        <nav style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #ccc;">
            <a href="{{ route('dashboard') }}">Dashboard</a>
            @unless(auth()->user()->isSuperAdmin())
                | <a href="{{ route('short-urls.index') }}">Short URLs</a>
            @endunless
            @if(auth()->user()->isSuperAdmin())
                | <a href="{{ route('companies.index') }}">Companies</a>
            @endif
            @if(in_array(auth()->user()->role->value, ['super_admin', 'admin']))
                | <a href="{{ route('invitations.create') }}">Invite User</a>
            @endif
            |
            <span>{{ auth()->user()->name }} ({{ auth()->user()->role->label() }}@if(auth()->user()->company)&nbsp;&middot; {{ auth()->user()->company->name }}@endif)</span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-danger" >Log out</button>
            </form>
        </nav>
    @endauth

    @if (session('status'))
        <div style="padding: 0.75rem; background: #e6ffed; border: 1px solid #34a853; margin-bottom: 1rem;">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="padding: 0.75rem; background: #ffe6e6; border: 1px solid #d93025; margin-bottom: 1rem;">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')

</body>
</html>
