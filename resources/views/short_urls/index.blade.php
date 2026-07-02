@extends('layouts.app')

@section('title', 'Short URLs')

@section('content')
    <h1>Short URLs</h1>

    @if (auth()->user()->canCreateShortUrls())
        <p><a href="{{ route('short-urls.create') }}">+ New short url</a></p>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Code</th>
                <th>Original URL</th>
                <th>Created by</th>
                <th>Company</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($shortUrls as $shortUrl)
                <tr>
                    <td><a href="{{ route('short-urls.redirect', $shortUrl->code) }}" target="_blank">{{ $shortUrl->code }}</a></td>
                    <td>{{ $shortUrl->original_url }}</td>
                    <td>{{ $shortUrl->user->name }}</td>
                    <td>{{ $shortUrl->company->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No short urls to show.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 1rem;">
        {{ $shortUrls->links() }}
    </div>
@endsection
