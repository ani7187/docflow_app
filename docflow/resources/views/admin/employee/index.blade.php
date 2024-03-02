@php use App\Enums\UserRole; @endphp
@extends('layouts.main')

@section('content')
    @if(auth()->check())
        <div class="main-panel">
            <div class="content-wrapper">
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
                                <th><b>{{ trans("auth.last_name") }}</b></th>
                                <th><b>{{ trans("auth.first_name") }}</th>
                                <th><b>{{ trans("auth.patronymic_name") }}</b></th>
                                <th><b>{{ trans("auth.position") }}</b></th>
                                <th><b>{{ trans("auth.company_code_short") }}</b></th>
                                <th><b>{{ trans("auth.created_at") }}</b></th>
                                <th colspan="2"><b>{{ trans("menu.actions") }}</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($partnerPersons as $partnerPerson)
                                <tr>
                                    <td>{{ $partnerPerson->user->email }}</td>
                                    <td>{{ $partnerPerson->first_name }}</td>
                                    <td>{{ $partnerPerson->last_name }}</td>
                                    <td>{{ $partnerPerson->patronymic_name }}</td>
                                    <td>{{ $partnerPerson->position }}</td>
                                    <td>{{ $partnerPerson->company_code }}</td>
                                    <td>{{ $partnerPerson->created_at }}</td>
                                    <td>
                                        <!-- Edit Button -->
                                        <a href="{{ route('employee.edit', $partnerPerson->user_id) }}">
                                            <i class="mdi mdi-grease-pencil"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('employee.softDelete', $partnerPerson->user_id) }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn"><i class="mdi mdi-delete"></i></button>
                                        </form>
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
