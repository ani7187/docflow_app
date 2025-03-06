@php use App\Enums\UserRole; @endphp
@extends('layouts.main')

@section('content')
    @if(auth()->check())
        {{--            {{dd(auth()->user()->partnerOrganization->company_code)}}--}}
        <style>
            .is-invalid {
                border-color: red;
            }
        </style>
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
{{--                        <h4 class="title">{!! __('user_groups.add_members', ['name' => $groupName]) !!}</h4>--}}
                        <form method="POST" action="{{ route('user_group_user.store', $group) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">{{ trans('user_groups.name') }} *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ old('name') }}">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <select name="user_ids[]" id="user_ids" class="selectpicker form-control @error('user_ids')invalid-feedback is-invalid @enderror"
                                        data-live-search="true" multiple data-none-selected-text="{{ trans('user_groups.select') }}">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" @if(in_array($user->id, old('user_ids', []))) selected @endif>{{ $user->email }}</option>
                                    @endforeach
                                </select>
{{--                                @dump($errors->all())--}}

                                @error('user_ids.*')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary float-end">{{ trans('auth.save') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
