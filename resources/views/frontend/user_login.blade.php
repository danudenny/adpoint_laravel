@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-5">
        <div class="profile">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div>
                            @if(session('status_expired'))
                            <div class="alert alert-danger">
                                <i class="fa fa-lock"></i> {!! session('status_expired') !!}
                            </div>
                            @endif
                            @if (Session::has('message'))
                                <div class="alert alert-danger">
                                    {!! session('message') !!}
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success" style="border-radius: 0;">
                                    <strong>Berhasil!</strong> {!! session('success') !!}
                                </div>
                            @endif
                        </div>
                        <div class="card">
                            <div class="text-center px-35 pt-5">
                                <h3 class="heading heading-4 strong-500">
                                    {{__('Login to your account.')}}
                                </h3>
                            </div>
                            <div class="p-5">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <form class="form-default" role="form" action="{{ route('login.user') }}" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="email" class="form-control form-control-sm" value="{{ old('email') }}" placeholder="{{__('Email')}}" name="email" id="email">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-user"></i>
                                                            </span>
                                                        </div>
                                                        <strong class="text-danger mt-1">{!! $errors->first('email', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group{{ $errors->has('password') ? 'has-error' : ''}}">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" class="form-control" placeholder="{{__('Password')}}" name="password" id="password">
                                                            <span class="input-group-addon">
                                                                <i class="text-md la la-lock"></i>
                                                            </span>
                                                        </div>
                                                        <strong class="text-danger mt-1">{!! $errors->first('password', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <div class="checkbox pad-btm text-left">
                                                            <input id="demo-form-checkbox" class="magic-checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                            <label for="demo-form-checkbox" class="text-sm">
                                                                {{ __('Remember Me') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <a href="{{ route('reset.password') }}" class="link link-xs link--style-3">{{__('Forgot password?')}}</a>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col text-center">
                                                    <button type="submit" class="btn btn-styled btn-base-1 btn-md w-100">{{ __('Login') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center px-35 pb-3">
                                <p class="text-md">
                                    {{__("Don't have an account?")}} <a href="{{ route('user.registration') }}" class="strong-600">{{__('Register Now')}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </section>
@endsection