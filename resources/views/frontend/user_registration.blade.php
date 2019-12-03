@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-4">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mx-auto">
                        <div class="card">
                            <div class="text-center px-35 pt-5">
                                <h3 class="heading heading-4 strong-500">
                                    {{__('Create an account.')}}
                                </h3>
                            </div>
                            {{-- @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif --}}
                            <div class="px-5 py-3 py-lg-5">
                                <div class="row align-items-center">
                                    <div class="col-12 col-lg">
                                        <form class="form-default" role="form" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group{{ $errors->has('name') ? 'has-error' : ''}}">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="text" class="form-control" value="{{ old('name') }}" placeholder="{{ __('Name') }}" name="name">
                                                            <span class="input-group-addon">
                                                                <i class="text-sm la la-user"></i>
                                                            </span>
                                                        </div>
                                                        <strong class="text-danger">{!! $errors->first('name', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group{{ $errors->has('email') ? 'has-error' : ''}}">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="text" class="form-control" value="{{ old('email') }}" placeholder="{{ __('Email') }}" name="email">
                                                            <span class="input-group-addon">
                                                                <i class="text-sm la la-envelope"></i>
                                                            </span>
                                                        </div>
                                                        <strong class="text-danger">{!! $errors->first('email', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group{{ $errors->has('password') ? 'has-error' : ''}}">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password">
                                                            <span class="input-group-addon">
                                                                <i class="text-sm la la-lock"></i>
                                                            </span>
                                                        </div>
                                                        <strong class="text-danger">{!! $errors->first('password', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="input-group input-group--style-1">
                                                            <input type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" name="password_confirmation">
                                                            <span class="input-group-addon">
                                                                <i class="text-sm la la-lock"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group{{ $errors->has('ktp') ? 'has-error' : ''}}">
                                                        <input type="file" name="ktp" id="ktp" class="custom-input-file custom-input-file--4"  />
                                                        <label for="ktp" class="mw-100 mb-3">
                                                            <span style="color: #a8a8a8">Upload KTP</span>
                                                            <strong>
                                                                <i class="fa fa-upload"></i>
                                                            </strong>
                                                        </label>
                                                        <strong class="text-danger mt-1">{!! $errors->first('ktp', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group{{ $errors->has('npwp') ? 'has-error' : ''}}">
                                                        <input type="file" name="npwp" id="npwp" class="custom-input-file custom-input-file--4"  />
                                                        <label for="npwp" class="mw-100 mb-3">
                                                            <span style="color: #a8a8a8">Upload NPWP</span>
                                                            <strong>
                                                                <i class="fa fa-upload"></i>
                                                            </strong>
                                                        </label>
                                                        <strong class="text-danger mt-1">{!! $errors->first('npwp', '<p class="help-block">:message</p>') !!}</strong>
                                                    </div>
                                                </div>
                                            </div>
            
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="checkbox pad-btm text-left">
                                                        <input class="magic-checkbox" type="checkbox" name="agree" id="agree" onchange="agreeMent(this)">
                                                        <label for="agree" class="text-sm">{{__('By signing up you agree to our terms and conditions.')}}</label>
                                                    </div>
                                                </div>
                                            </div>
                
                                            <div class="row align-items-center">
                                                <div class="col-12 text-right  mt-3">
                                                    <button type="submit" id="btn-submit" disabled class="btn btn-styled btn-base-1 w-100 btn-md">{{ __('Create Account') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center px-35 pb-3">
                                <p class="text-md">
                                    {{__('Already have an account?')}}<a href="{{ route('user.login') }}" class="strong-600">{{__('Log In')}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        function agreeMent(e){
            if ($(e).is(':checked')) {
                $('#btn-submit').prop('disabled', false);
            }else{
                $('#btn-submit').prop('disabled', true);
            }
        }

        function autoFillSeller(){
            $('#email').val('seller@example.com');
            $('#password').val('123456');
        }
        function autoFillCustomer(){
            $('#email').val('customer@example.com');
            $('#password').val('123456');
        }
    </script>
@endsection
