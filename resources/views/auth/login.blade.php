@extends('layouts.app')
@section('title', 'Login Petugas')
@section('width', 'narrow')

@section('content')
<div class="panel">
    <h2>Login Petugas BPBD</h2>
    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="@error('email') is-invalid @enderror">
            @error('email') <div class="error">{{ $message }}</div> @enderror
        </div>
        <div class="field">
            <label for="password">Kata sandi</label>
            <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror">
            @error('password') <div class="error">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn">Masuk</button>
    </form>
</div>
@endsection
