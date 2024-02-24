@extends('layouts.main')

@section('content')
{{--    <div class="container-scroller">--}}
{{--            <div class="content-wrapper ">--}}
                <div class="row flex-grow mt-5">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left p-5">
                            <div class="brand-logo mb-1">
                                <img src="../../assets/images/logo.svg">
{{--                                <h1 style="color: #943494">{{ trans('auth.login') }}</h1>--}}
                            </div>
{{--                            <h4>Hello! let's get started</h4>--}}
{{--                            <h6 class="font-weight-light">Sign in to continue.</h6>--}}
                            <form method="POST" action="{{ route('login') }}" class="pt-3">
                                @csrf

                                <div class="form-group">
{{--                                    <label for="email" class="col-form-label text-md-end">{{ trans('auth.email_address') }}</label>--}}
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email"
                                           placeholder="{{ trans('auth.email_address') }}" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
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
                </div>
{{--            </div>--}}
            <!-- content-wrapper ends -->
        <!-- page-body-wrapper ends -->
{{--    </div>--}}
@endsection
