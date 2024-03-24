@php use App\Enums\UserRole; use App\Models\permission\Permission; @endphp

@extends('layouts.main')

@section('content')
    @if(auth()->check())
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="mb-3">
                    <a href="{{ route('documents.index', ['section' => $document->section_id]) }}" class="btn p-0" style="cursor:pointer;">
                        <i class="mdi mdi-keyboard-backspace"></i>
                        {{ trans('menu.back') }}
                    </a>
                </div>
                @include("partials.alerts")
                @include("partials.actions", ["documentID" => $document->id, "sectionID" => $document->section_id])
                <div class="card">
                    <div class="card-body">
                        <h4 class="mb-4"><strong>{{ $document->number }}</strong></h4>
                        <hr>
                        <div class="row">
                            @foreach( $document->toArray() as $columnName => $value)
                                @if($value && in_array($columnName, config('application.additional_column_list')))
                                    <div class="col-md-6">
                                        @if($columnName == "uploaded_by")
                                        <p class="mb-0">
                                            <span class="font-weight-bold text-muted">{{ trans("section.$columnName") }}: </span>
                                            <span> {{ $document->uploader->email }} ({{ $document->uploader->name }})</span>
                                        </p>
                                        @else
                                            <p class="mb-0">
                                                <span class="font-weight-bold text-muted">{{ trans("section.$columnName") }}:</span>
                                                <span>{{ $value }}</span>
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <hr>
                        <div class="mt-5">
                            @include("partials.files", ["media" => $media])
                        </div>
                    </div>
                </div>
            </div>
            @include('partials.footer')
        </div>
    @endif
@endsection
