<div class="modal-body">
    <div class="row align-items-center">
        <div class="col">
            <div class="card">
                <div class="card-body px-4">
                    <h2>Login</h2>
                    <form role="form" action="{{ route('cart.login.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="{{__('Email')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a href="#" class="link link-xs link--style-3">{{__('Forgot password?')}}</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="submit" class="btn btn-styled btn-base-1 px-4">{{__('Sign in')}}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>