@php use App\Enums\UserRole; @endphp
@extends('layouts.main')

@section('content')
    @if(auth()->check())
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
                        <div class="d-flex mb-4">
                            <a href="{{ route("user_group_user.add", $groupID) }}" class="btn btn-gradient-primary font-weight-bold">
                                {{ trans("user_groups.add") }}
                            </a>
<!--                            <a href="{{ route("employee.export_pdf") }}" style="margin-left: 5px" class="btn btn-success font-weight-bold">
                                {{ trans("menu.export_pdf") }}
                            </a>-->
                        </div>
                        <h4 class="title"><b>{{ trans("user_groups.users") }}</b></h4>
                        <hr>
                        <table class="table">
                            <thead>
                            <tr>
                                <th><b>{{ trans("user_groups.id") }}</b></th>
                                <th><b>{{ trans("user_groups.user_name") }}</b></th>
                                <th><b>{{ trans("user_groups.email") }}</th>
                                <th><b>{{ trans("user_groups.created_at") }}</th>
                                <th colspan="3"><b>{{ trans("menu.actions") }}</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userGroupUsers as $key => $userGroupUser)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $userGroupUser->name }}</td>
                                    <td>{{ $userGroupUser->email }}</td>
                                    <td>{{ $userGroupUser->created_at }}</td>
                                    <td style="width: 5px;">
                                        <!-- Delete Button -->
                                        <form method="POST" action="{{ route('user_group_user.detach',
                                            ["userGroupId" => $groupID,
                                            "userId" => $userGroupUser->id]) }}"
                                              style="margin: -23px;" title="Հեռացնել խմբից">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn"><i class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>
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
