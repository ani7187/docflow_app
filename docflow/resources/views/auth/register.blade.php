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

    <div class="container mt-5">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link " id="company-tab" data-toggle="tab" href="#company" role="tab"
                   aria-controls="company" aria-selected="true">{{ trans('auth.company_form') }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="employee-tab" data-toggle="tab" href="#employee" role="tab"
                   aria-controls="employee" aria-selected="false">{{ trans('auth.employee_form') }}</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade  " id="company" role="tabpanel" aria-labelledby="company-tab">
                <div class="mt-5">
                    <!-- Company Registration Form -->
                    <form method="POST" id="register_form" action="{{ route('register') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">{{ trans('auth.name') }} *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name"  value="{{ old('name') }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">{{ trans('auth.email_address') }} *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" required value="{{ old('email') }}">
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ trans('auth.password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" value="123456789" required>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">{{ trans('auth.confirm_password') }}</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation" value="123456789" required>
                                </div>

                                <input type="hidden" id="role_id" name="role_id" value="2" required>
                                @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="organization_name">{{ trans('auth.organization_name') }} *</label>
                                    <input type="text"
                                           class="form-control @error('organization_name') is-invalid @enderror"
                                           id="organization_name" name="organization_name" required
                                           value="{{ old('organization_name') }}">
                                    @error('organization_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label
                                        for="organization_legal_type">{{ trans('auth.organization_legal_type') }}</label>
                                    <input type="text" class="form-control" id="organization_legal_type"
                                           name="organization_legal_type"
                                           value="{{ old('organization_legal_type') }}">
                                </div>

                                <div class="form-group">
                                    <label for="registration_number">{{ trans('auth.registration_number') }}</label>
                                    <input type="text" class="form-control" id="registration_number"
                                           name="registration_number"
                                           value="{{ old('registration_number') }}">
                                </div>

                                <div class="form-group">
                                    <label for="organization_address">{{ trans('auth.organization_address') }}</label>
                                    <input type="text" class="form-control" id="organization_address"
                                           name="organization_address"
                                           value="{{ old('organization_address') }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ trans('auth.register') }}
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-link">{{ trans('auth.login_reg') }}</a>

                    </form>
                </div>
            </div>
            <div class="tab-pane fade show active" id="employee" role="tabpanel" aria-labelledby="employee-tab">
                <!-- Employee Registration Form -->
                <div class="mt-5">
                    <form method="POST" id="register_form" action="{{ route('register') }}">
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
                                    @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password">{{ trans('auth.password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" value="123456789" required>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">{{ trans('auth.confirm_password') }}</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation" value="123456789" required>
                                </div>

                                <input type="hidden" id="role_id" name="role_id" value="3" required>
                                @error('role_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="first_name">{{ trans('auth.first_name') }} *</label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                           id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                    @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="last_name">{{ trans('auth.last_name') }} *</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                           id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                    @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="patronymic_name">{{ trans('auth.patronymic_name') }}</label>
                                    <input type="text" class="form-control" id="patronymic_name" name="patronymic_name"
                                           value="{{ old('patronymic_name') }}">
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="position">{{ trans('auth.position') }}</label>
                                        <input type="text" class="form-control" id="position" name="position"
                                               value="{{ old('position') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="company_code">{{ trans('auth.company_code') }} *</label>
                                        <input type="text"
                                               class="form-control @error('company_code') is-invalid @enderror"
                                               id="company_code" name="company_code" value="{{ old('company_code') }}"
                                               required>
                                        @error('company_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {{ trans('auth.register') }}
                        </button>
                        <a href="{{ route('login') }}" class="btn btn-link">{{ trans('auth.login_reg') }}</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <!-- Include your script file here -->
        <script src=" {{ asset('assets/js/register.js') }} "></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @endsection
@endsection
