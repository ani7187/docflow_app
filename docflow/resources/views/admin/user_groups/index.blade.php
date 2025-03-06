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
                            <a href="{{ route("user_groups.add") }}" class="btn btn-gradient-primary font-weight-bold">
                                {{ trans("menu.add") }}
                            </a>
<!--                            <a href="{{ route("employee.export_pdf") }}" style="margin-left: 5px" class="btn btn-success font-weight-bold">
                                {{ trans("menu.export_pdf") }}
                            </a>-->
                        </div>
                        <h4 class="card-title"><b>{{ trans("user_groups.groups") }}</b></h4>
                        <hr>
                        <table class="table">
                            <thead>
                            <tr>
                                <th><b>{{ trans("user_groups.id") }}</b></th>
                                <th><b>{{ trans("user_groups.name") }}</b></th>
                                <th><b>{{ trans("user_groups.created_at") }}</th>
                                <th colspan="3"><b>{{ trans("menu.actions") }}</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userGroups as $key => $userGroup)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $userGroup->name }}</td>
                                    <td>{{ $userGroup->created_at }}</td>
                                    <td style="width: 5px;">
                                        <!-- Edit Button -->
                                        <a href="{{ route('user_group_user', $userGroup->id) }}" title="Ավելացնել աշխատակից">
                                            <i class="mdi mdi-account-plus"></i>
                                        </a>
                                    </td>
                                    <td style="width: 5px;">
                                        <!-- Edit Button -->
                                        <a href="{{ route('user_groups.edit', $userGroup->id) }}" title="Խմբագրել խումբը">
                                            <i class="mdi mdi-grease-pencil"></i>
                                        </a>
                                    </td>
                                    <td style="width: 5px;">
                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('user_groups.destroy', $userGroup->id) }}" style="margin: -23px;" title="Ջնջել խումբը">
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
