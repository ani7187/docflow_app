@extends('layouts.main')

@section('content')
    <style>
        .is-invalid {
            border-color: red;
        }

        .form-group input {
            border-radius: 10px;
            border: 1px solid lightgray;
        }
    </style>
{{--    <div class="container-scroller">--}}
{{--            <div class="content-wrapper ">--}}
                <div class="row flex-grow mt-5">
                    <div class="col-lg-1 col-md-1"></div>
                    <div class="col-lg-4 col-md-4 mt-5" >
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo mb-1">
{{--                                <img src="../../assets/images/logo.svg">--}}
                                <h1 style="color: #da8cff"><b>{{ trans('auth.login') }}</b></h1>
                            </div>
                            @if ($errors->has('verification'))
                                <div class="alert alert-danger" role="alert">
                                    {{ $errors->first('verification') }}
                                </div>
                            @endif
{{--                            <h4>Hello! let's get started</h4>--}}
{{--                            <h6 class="font-weight-light">Sign in to continue.</h6>--}}
                            <form method="POST" action="{{ route('login') }}" class="pt-3">
                                @csrf

                                <div class="form-group">
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">@</span>
                                    </div>{{--                                    <label for="email" class="col-form-label text-md-end">{{ trans('auth.email_address') }}</label>--}}
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           placeholder="{{ trans('auth.email_address') }}" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" value="{{ old('password') }}" placeholder="{{ trans('auth.password') }}"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                                        {{ trans('auth.login') }}
                                    </button>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    @if (Route::has('password.request'))
                                        <a class="auth-link text-black" style="padding: 15px 0 0 0" href="{{ route('password.request') }}">
                                            {{ trans('auth.forgot_your_password') }}
                                        </a>
                                    @endif
                                </div>
{{--                                <div class="mb-2">--}}
{{--                                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">--}}
{{--                                        <i class="mdi mdi-facebook me-2"></i>Connect using facebook </button>--}}
{{--                                </div>--}}
                                <div class="text-center mt-3 font-weight-light"> {{ trans('auth.dont_have_acc') }}
                                    @if (Route::has('register'))
                                        <a class="auth-link" href="{{ route('register') }}">
                                            {{ trans('auth.register') }}
                                        </a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6" style="padding-left: 0px">
                        <img style="height: 525px" src="../../assets/images/side.jpeg">
                    </div>
                </div>
{{--            </div>--}}
            <!-- content-wrapper ends -->
        <!-- page-body-wrapper ends -->
{{--    </div>--}}
@endsection
