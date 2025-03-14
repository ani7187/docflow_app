@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row mt-5 justify-content-center">
            <div class="col-md-5">
                <div class="card">
{{--                    <div class="card-header">{{ trans('auth.login') }}</div>--}}

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ trans('auth.email_address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ trans('auth.password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                           name="password" value="{{ old('password') }}" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ trans('auth.remember_me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-3 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ trans('auth.login') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-md-3"></label>
                                <div class="col-md-3">
                                    @if (Route::has('register'))
                                        <a class="btn btn-link" style="padding: 15px 0 0 65px" href="{{ route('register') }}">
                                            {{ trans('auth.register') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link" style="padding: 15px 0 0 0" href="{{ route('password.request') }}">
                                            {{ trans('auth.forgot_your_password') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <img style="height: 525px" src="../../assets/images/side.jpeg">
            </div>
        </div>
    </div>
@endsection
