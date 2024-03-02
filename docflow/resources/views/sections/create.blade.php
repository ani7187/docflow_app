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
                            <div class="container">
                                <h2 class="mb-3"><b> {{ trans("menu.create_new_section") }} </b></h2>
                                <form action="{{ route('sections.store') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label for="name">{{ trans("menu.section_name") }} *</label>
                                        <input type="text" name="name" id="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">{{ trans("menu.section_description") }}</label>
                                        <textarea name="description" id="description" class="form-control"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end">{{ trans("menu.save") }}</button>
                                </form>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
