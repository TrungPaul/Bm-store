@extends('layouts.auth')
@section('styles_page')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
@section('content')
    <div class="kt-login__signin">
        <div class="kt-login__head">
            <h3 class="kt-login__title" style="text-transform: capitalize">Register</h3>
        </div>
        <form action="{{ route('register.store') }}" method="POST" class="kt-form">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Enter username" name="name" id="name" value="{{ old('name') }}" required
                       autocomplete="name" autofocus>
                @error('name')
                <span class="help-block has-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input class="form-control" type="email" placeholder="Enter email" name="email" id="email" value="{{ old('email') }}" required
                       autocomplete="email" autofocus>
                @error('email')
                <span class="help-block has-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Enter phone number" name="phone" id="phone" value="{{ old('phone') }}" required
                       autocomplete="phone" autofocus>
                @error('phone')
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
            <div class="form-group">
                <input class="form-control" type="password" placeholder="Enter confirm password" name="password_confirmation" id="password_confirmation"
                       required autocomplete="current-password">
                @error('password_confirmation')
                <span class="help-block has-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
            @error('g-recaptcha-response')
            <span class="help-block has-error">{{ $message }}</span>
            @enderror
            <div class="row kt-login__extra">
                <div class="col kt-align-right">
                    <span>Đã có tài khoản?</span> <a href="{{ route('login') }}" class="kt-login__link text-primary">Login</a>
                </div>
            </div>
            <div class="kt-login__actions">
                <button type="submit" class="btn btn-brand btn-elevate kt-login__btn-primary">Register</button>
            </div>
        </form>
    </div>
@endsection
