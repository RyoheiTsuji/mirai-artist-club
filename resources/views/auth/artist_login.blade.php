@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Artist Login</h2>
        <form method="POST" action="{{ route('artist.login') }}">
            @csrf
            <div>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>
                @error('password')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
@endsection
