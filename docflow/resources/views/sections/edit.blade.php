@php use App\Enums\UserRole; @endphp
@extends('layouts.main')

@section('content')
    @if(auth()->check())

        {{--        {{dd($partnerPerson)}}--}}
        <div class="main-panel">
            <div class="content-wrapper">
{{--                <div class="mb-3">--}}
{{--                    <a href="{{ url()->previous() }}" class="btn p-0">--}}
{{--                        <i class="mdi mdi-keyboard-backspace"></i>--}}
{{--                        {{ trans('menu.back') }}--}}
{{--                    </a>--}}
{{--                </div>--}}
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
                        <h3 class="mb-3"><b> {{ trans("menu.edit_new_section") }} </b></h3>
                        <form action="{{ route('sections.update', $section) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- Use PUT method for updating the resource -->
                            <div class="form-group">
                                <label for="name">{{ trans("menu.section_name") }} *</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $section->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ trans("menu.section_description") }}</label>
                                <textarea name="description" id="description" class="form-control">{{ $section->description }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary float-end">{{ trans("menu.save") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
