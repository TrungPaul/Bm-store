@extends('layouts.auth')
@section('content')
<div class="kt-login__signin">
    <div class="kt-login__head">
        <h3 class="kt-login__title" style="text-transform: capitalize">Login Admin</h3>
    </div>
    <form action="{{ route('login.store') }}" method="POST" class="kt-form">
        @csrf
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Enter email or username" name="email" id="email" value="" required
                autocomplete="email" autofocus>
            @error('email')
            <span class="help-block has-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <input class="form-control" type="password" placeholder="Enter password" name="password" id="password"
                required autocomplete="current-password">
            @error('password')
            <span class="help-block has-error">{{ $message }}</span>
            @enderror
        </div>
        <div class="row kt-login__extra">
            <div class="col">
                <label class="kt-checkbox">
                    <input type="checkbox" name="remember"  id="remember">Save password
                    <span></span>
                </label>
            </div>
            <div class="col kt-align-right">
                <a href="{{ route('forgot.password.create') }}" class="kt-login__link">Forgot password</a>
            </div>
        </div>
        <div class="kt-login__actions">
            <button type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Login</button>
        </div>
    </form>
</div>
@endsection
