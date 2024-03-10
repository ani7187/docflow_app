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

                <div class="card mb-4">
                    <div class="card-body">
                        actions
                    </div>
                </div>

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
                        <h4 class="mt-5 mb-4 text-success"><i>Կցված ֆայլերի ցանկ</i></h4>
                        <div id="file-mod-view-file-list" class="file-mod-view-file-list" data-curr-index="0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table border="0" class="table table-hover" id="files-table">
                                            <thead class="thead-light">
                                            </thead>
                                            <tbody>
                                            @foreach ($media as $file)
                                                <tr>
                                                    <td>
                                                        <i style="color: #9170e7; font-size: 25px;" class="mdi {{ getFileIcon($file->extension) }}"></i>
                                                    </td>
                                                    <td>{{ $file->name }}</td>
                                                    <td>
                                                        <div class="float-end">
{{--                                                            <a href="" class="btn btn-sm btn-primary" target="_blank" title="Open">--}}
{{--                                                                <i class="mdi mdi-open-in-new"></i>--}}
{{--                                                            </a>--}}
                                                            <a href="{{ route('media.download', ['media' => $file->id]) }}" class="btn btn-sm btn-success" target="_blank" download="{{ $file->name }}" title="Ներբեռնել">
                                                                <i class="mdi mdi-download"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('partials.footer')
        </div>
    @endif
@endsection
