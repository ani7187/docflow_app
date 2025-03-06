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

    <div class="row flex-grow">
        <div class="col-lg-12 mx-auto">
            <div class="auth-form-light text-left p-5">
                <div class="brand-logo w-25 h-25">
{{--                    <img src="../../assets/images/logo.svg">--}}
                <h1 style="color: #da8cff"><b>{{ trans('auth.register') }}</b></h1>
                </div>
                <div class="mt-4">
                    <div class="mt-5">
                        <!-- Company Registration Form -->
                        <form method="POST" id="register_form" action="{{ route('register') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="role_id" name="role_id" value="2" required>
                                    @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="organization_name">{{ trans('auth.organization_name') }}
                                            *</label>
                                        <input type="text"
                                               class="form-control @error('organization_name') is-invalid @enderror"
                                               id="organization_name" name="organization_name" required
                                               value="{{ old('organization_name') }}">
                                        @error('organization_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">{{ trans('auth.name') }} *</label>
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="org_name" name="name" value="{{ old('name') }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email_address') }} *</label>
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" required value="{{ old('email') }}">
                                        <span id="emailError" style="color: red;"></span> <!-- Error message container -->
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="password">{{ trans('auth.password') }}</label>
                                        <input type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password" required>
                                        <span id="password-error" style="color: red;"></span>
                                        <span id="password-strength" style="color: red;"></span>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label
                                            for="password_confirmation">{{ trans('auth.confirm_password') }}</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation" required>
                                        <span id="message" style="color: red;"></span><br>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <img style="height: 500px" src="../../assets/images/side.jpeg">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {{ trans('auth.register') }}
                            </button>
                            <a href="{{ route('login') }}"
                               class="btn btn-link">{{ trans('auth.login_reg') }}</a>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <!-- Include your script file here -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/auth/register.js') }}"></script>
@endsection
