{{--@extends('layouts.main')--}}

{{--@section('content')--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Online docflow</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href=" {{ asset('assets/vendors/css/vendor.bundle.base.css') }} ">
    <link rel="stylesheet" href=" {{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }} ">
    <link rel="stylesheet" href="https://cdn.misdeliver.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    {{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">--}}

    <!-- Bootstrap Select CSS -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">

    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href=" {{ asset('assets/css/style.css') }} ">
    <!-- End layout styles -->
    <link rel="shortcut icon" href=" {{ asset('assets/images/favicon.ico') }} "/>
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-8">
            <div class="card">

                <div class="card-body">
                    <div class="brand-logo mb-1">
{{--                        <img style="height: 75px;" src="../../assets/images/logo.svg">--}}
                            <h1 style="color: #da8cff">{{ trans('auth.verify') }}</h1>
                    </div>
{{--                    <div class="card-header bg-primary text-white">{{ trans('auth.verify_your_email_address') }}</div>--}}
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ trans('auth.fresh_verification_link_sent_your_email_address') }}
                        </div>
                    @endif

                    <p>{{ trans('auth.email_not_received') }}</p>
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ trans('auth.request_another') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

{{--@endsection--}}
