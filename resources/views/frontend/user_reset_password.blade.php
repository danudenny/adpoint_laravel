@extends('layouts.blank')

@section('content')

<div class="cls-content-sm panel">
    <div class="panel-body">
        <h1 class="h3">{{ __('Reset Password') }}</h1>
        @if (Session::has('success'))
            <div class="alert alert-success" style="border-radius: 0;">
                <strong>Berhasil!</strong> {!! session('success') !!}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger" style="border-radius: 0;">
                <strong>Error!</strong> {!! session('error') !!}
            </div>
        @endif
        <p class="pad-btm">{{__('Enter your email address to recover your password.')}} </p>
        <form method="POST" action="{{ route('send.email.reset') }}">
            @csrf
            <div class="form-group">
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">

                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-right">
                <button class="btn btn-danger btn-lg btn-block" type="submit">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
        <div class="pad-top">
            <a href="{{route('user.login')}}" class="btn-link text-bold text-main">{{__('Back to Login')}}</a>
        </div>
    </div>
</div>
@endsection