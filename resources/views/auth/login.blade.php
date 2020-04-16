@extends('layouts.login')

@section('content')


@php
    $generalsetting = \App\GeneralSetting::first();
@endphp

<div class="flex-row">
    <div class="flex-col-xl-6 blank-index d-flex align-items-center justify-content-center"
    @if ($generalsetting->admin_login_sidebar != null)
        style="background-image:url('{{ asset($generalsetting->admin_login_sidebar) }}');"
    @else
        style="background-image:url('{{ asset('img/bg-img/login-box.jpg') }}');"
    @endif>

    </div>
    <div class="flex-col-xl-6">
        <div class="pad-all">
        <div class="text-center">
            <br>
			@if($generalsetting->logo != null)
                <img src="{{ asset($generalsetting->logo) }}" class="" height="44">
            @else
                <img src="{{ asset('frontend/images/logo/logo.png') }}" class="" height="44">
            @endif

            <br>
            <br>
            <br>
            @if (Session::has('message'))
                <div class="alert alert-danger" style="border-radius: 0;">
                    <strong>Error!</strong> {!! session('message') !!}
                </div>
            @endif

        </div>
            <form class="pad-hor" method="POST" role="form" action="{{ route('login') }}">
                @csrf
                <div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                    <strong class="text-danger mt-1">{!! $errors->first('email', '<p class="help-block">:message</p>') !!}</strong>
                </div>
                <div class="form-group{{ $errors->has('password') ? 'has-error' : ''}}">
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password">
                    <strong class="text-danger mt-1">{!! $errors->first('email', '<p class="help-block">:message</p>') !!}</strong>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="checkbox pad-btm text-left">
                            <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="demo-form-checkbox">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="checkbox pad-btm text-right">
                            <a href="{{ route('reset.password') }}" class="btn-link">{{__('Forgot password')}} ?</a>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    <i class="fa fa-lock"></i> {{ __('Login as Admin') }}
                </button>
                <a type="button" href="{{ url('/')}}" class="btn btn-info btn-lg btn-block">
                    <i class="fa fa-arrow-left"></i> {{ __('InnovAPS Web') }}
                </a>
                <a type="button" href="{{ url('/users/login')}}" class="btn btn-warning btn-lg btn-block">
                    <i class="fa fa-user"></i> {{ __('Login as User') }}
                </a>
            </form>
        </div>
    </div>
</div>

@endsection