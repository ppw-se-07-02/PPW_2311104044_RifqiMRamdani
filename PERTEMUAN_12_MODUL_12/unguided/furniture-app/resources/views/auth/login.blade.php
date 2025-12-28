@extends('layouts.app')

@section('title', 'Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-4">
        <div class="product-card">
            <h4 class="text-center mb-4">Login</h4>
            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-furniture w-100">Login</button>
            </form>
            <div class="text-center mt-3">
                <a href="/register">Belum punya akun? Daftar</a>
            </div>
        </div>
    </div>
</div>
@endsection