@extends('layouts.app')

@section('title', 'New Short URL')

@section('content')
    <h1>New Short URL</h1>

    <form method="POST" action="{{ route('short-urls.store') }}">
        @csrf

        <div style="margin-bottom: 1rem;">
            <label for="original_url">Original URL</label><br>
            <input id="original_url" type="url" name="original_url" value="{{ old('original_url') }}" placeholder="https://example.com/some/long/path" required autofocus style="width: 100%;">
        </div>

        <button type="submit" class="btn btn-success">Create short url</button>
    </form>
@endsection
