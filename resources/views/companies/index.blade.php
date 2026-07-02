@extends('layouts.app')

@section('title', 'Companies')

@section('content')
    <h1>Companies</h1>

    <p><a href="{{ route('companies.create') }}">+ New company</a></p>

    <table border="1" cellpadding="6" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th align="left">Name</th>
                <th align="left">Users</th>
                <th align="left">Short URLs</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($companies as $company)
                <tr>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->users_count }}</td>
                    <td>{{ $company->short_urls_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">No companies yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
