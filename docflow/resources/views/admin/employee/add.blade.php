@php use App\Enums\UserRole; @endphp
@extends('layouts.main')

@section('content')
    @if(auth()->check())
        {{--            {{dd(auth()->user()->partnerOrganization->company_code)}}--}}
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="mb-3">
                    <a href="{{ url()->previous() }}" class="btn p-0">
                        <i class="mdi mdi-keyboard-backspace"></i>
                        {{ trans('menu.back') }}
                    </a>
                </div>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="register_form" action="{{ route('employee.store') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ trans('auth.name') }} *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" required value="{{ old('name') }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email_address') }} *</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" required value="{{ old('email') }}">
                                        <span id="emailError" style="color: red;"></span> <!-- Error message container -->
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

{{--                                    <div class="form-group">--}}
{{--                                        <label for="password">{{ trans('auth.password') }}</label>--}}
{{--                                        <input type="password"--}}
{{--                                               class="form-control @error('password') is-invalid @enderror"--}}
{{--                                               id="password" name="password">--}}
{{--                                        <span id="password-error" style="color: red;"></span>--}}
{{--                                        <span id="password-strength" style="color: red;"></span>--}}
{{--                                        @error('password')--}}
{{--                                        <span class="text-danger">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}

{{--                                    <div class="form-group">--}}
{{--                                        <label--}}
{{--                                            for="password_confirmation">{{ trans('auth.confirm_password') }}</label>--}}
{{--                                        <input type="password" class="form-control" id="password_confirmation"--}}
{{--                                               name="password_confirmation">--}}
{{--                                        <span id="message" style="color: red;"></span><br>--}}
{{--                                    </div>--}}

                                    <input type="hidden" id="role_id" name="role_id" value="3" required>
                                    @error('role_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first_name">{{ trans('auth.first_name') }} *</label>
                                        <input type="text"
                                               class="form-control @error('first_name') is-invalid @enderror"
                                               id="first_name" name="first_name"
                                               value="{{ old('first_name') }}" required>
                                        @error('first_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name">{{ trans('auth.last_name') }} *</label>
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                               id="last_name" name="last_name"
                                               value="{{ old('last_name') }}" required>
                                        @error('last_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="patronymic_name">{{ trans('auth.patronymic_name') }}</label>
                                        <input type="text" class="form-control" id="patronymic_name"
                                               name="patronymic_name"
                                               value="{{ old('patronymic_name') }}">
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12">
                                            <label for="position">{{ trans('auth.position') }}</label>
                                            <input type="text" class="form-control" id="position" name="position"
                                                   value="{{ old('position') }}">
                                        </div>
                                        <div class="form-group col-md-6" style="display: none">
                                            <label for="company_code">{{ trans('auth.company_code_short') }} *</label>
                                            <input type="text"
                                                   class="form-control @error('company_code') is-invalid @enderror"
                                                   id="company_code" name="company_code"
                                                   value="{{ auth()->user()->partnerOrganization->company_code }}"
                                                   required readonly>
                                            @error('company_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">
                                {{ trans('auth.save') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection
@section('scripts')
    <script src="{{ asset('js/auth/register.js') }}"></script>
@endsection
