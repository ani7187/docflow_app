@php use App\Enums\UserRole; @endphp
@extends('layouts.main')

@section('content')
    @if(auth()->check())
        <div class="main-panel">
            <div class="content-wrapper">
                @include("partials.alerts")
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <a href="{{ route("employee.add") }}" class="btn btn-gradient-primary font-weight-bold">
                                {{ trans("menu.add") }}
                            </a>
                            <a href="{{ route("employee.export_pdf") }}" style="margin-left: 5px" class="btn btn-success font-weight-bold">
                                {{ trans("menu.export_pdf") }}
                            </a>
                        </div>
                        <h4 class="card-title"><b>{{ trans("menu.employees") }}</b></h4>
                        <hr>
                        <table class="table">
                            <thead>
                            <tr>
                                <th><b>{{ trans("auth.email_address") }}</b></th>
                                <th><b>{{ trans("auth.user_name") }}</b></th>
{{--                                <th><b>{{ trans("auth.last_name") }}</b></th>--}}
{{--                                <th><b>{{ trans("auth.first_name") }}</th>--}}
{{--                                <th><b>{{ trans("auth.patronymic_name") }}</b></th>--}}
                                <th><b>{{ trans("auth.position") }}</b></th>
{{--                                <th><b>{{ trans("auth.company_code_short") }}</b></th>--}}
                                <th><b>{{ trans("auth.created_at") }}</b></th>
                                <th><b>{{ trans("auth.status") }}</b></th>
                                <th colspan="3"><b></b></th> {{--{{ trans("menu.actions") }}--}}
                                <th><b>Մոդերատոր</b></th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partnerPersons as $partnerPerson)
                                <tr>
                                    <td>{{ $partnerPerson->user->email }}</td>
                                    <td>{{ $partnerPerson->first_name . " " . $partnerPerson->last_name . " " . $partnerPerson->patronymic_name}}</td>
{{--                                    <td>{{ $partnerPerson->last_name }}</td>--}}
{{--                                    <td>{{ $partnerPerson->patronymic_name }}</td>--}}
                                    <td>{{ $partnerPerson->position }}</td>
{{--                                    <td>{{ $partnerPerson->company_code }}</td>--}}
                                    <td>{{ $partnerPerson->created_at }}</td>
                                    <td>
                                        @if(!$partnerPerson->user->is_active)
                                        <label class="badge badge-danger">{{ trans('auth.disabled') }}</label>
                                    <td class="p-0 m-0">
                                        <!-- Delete Button -->
                                        <form method="POST" action="#">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn p-0 m-0"><i class="mdi mdi-account"></i></button>
                                        </form>
                                    </td>
                                        @elseif($partnerPerson->user->password_change_required)
                                            <label class="badge badge-warning">{{ trans('auth.invited') }}</label>
                                        <td class="p-0 m-0">
                                            <!-- Delete Button -->
                                            <form method="POST" action="{{ route('employee.softDelete', $partnerPerson->user_id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn p-0 m-0"><i class="mdi mdi-account-off"></i></button>
                                            </form>
                                        </td>
                                        @elseif(!$partnerPerson->user->password_change_required && $partnerPerson->user->is_active)
                                            <label class="badge badge-success">{{ trans('auth.active') }}</label>
                                            <td class="p-0 m-0">
                                                <!-- Delete Button -->
                                                <form method="POST" action="{{ route('employee.softDelete', $partnerPerson->user_id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn p-0 m-0"><i class="mdi mdi-account-off"></i></button>
                                                </form>
                                            </td>
                                        @endif
                                    </td>
                                    <td class="p-0 m-0">
                                        <!-- Edit Button -->
                                        <a href="{{ route('employee.edit', $partnerPerson->user_id) }}">
                                            <i class="mdi mdi-grease-pencil"></i>
                                        </a>
                                    </td>
                                    <td class="p-0 m-0">
                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('employee.softDelete', $partnerPerson->user_id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn p-0 m-0"><i class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>
                                    <td class="p-0 m-0">
                                        <div class="form-check" style="margin-left: 55px">
                                            <label class="form-check-label">
                                                <input type="checkbox" name="file_id[]" class="form-check-input" value=""> <i class="input-helper"></i></label>
                                        </div>
                                    </td>
                                    {{--                                    <td><label class="badge badge-danger">Pending</label></td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
