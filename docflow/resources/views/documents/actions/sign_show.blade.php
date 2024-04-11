@extends('layouts.main')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="mb-3">
                <a href="{{ route('documents.show', ['document' => $document->id, 'section' => $section]) }}" class="btn p-0" style="cursor:pointer;">
                    <i class="mdi mdi-keyboard-backspace"></i>
                    {{ trans('menu.back') }}
                </a>
            </div>
            @include("partials.alerts")
            <div class="card mt-2">
                <div class="card-body">
                    <form action="{{ route('documents.sign', ['document' => $document->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4 class="text-success"><i>Կցված ֆայլերի ցանկ</i></h4>
                        <div id="file-mod-view-file-list" class="file-mod-view-file-list" data-curr-index="0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table border="0" class="table table-hover" id="files-table">
                                            <thead class="thead-light">
                                            <tr>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($media as $file)
                                                <tr>
                                                    <td style="width: 10px;height: 5px" class="pt-4 m-0">
                                                        <div class="form-group p-0 m-0">
                                                            <div class="form-check">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" name="file_id[]" class="form-check-input" value="{{ $file->id }}"> <i class="input-helper"></i></label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <i style="color: #9170e7; font-size: 25px;" class="mdi {{ getFileIcon($file->extension) }}"></i>
                                                    </td>
                                                    <td>{{ $file->name }}</td>
                                                    <td>
                                                        <div class="float-end">
                                                            <a href="#" class="btn btn-sm btn-primary open-file" data-file-url="{{ $file->url }}" title="Open">
                                                                <i class="mdi mdi-open-in-new"></i>
                                                            </a>
                                                            <a href="{{ route('media.download', ['media' => $file->id]) }}" class="btn btn-sm btn-success" download="{{ $file->name }}" title="Ներբեռնել">
                                                                <i class="mdi mdi-download"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            @error('file_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success float-end mt-5">{{ trans('actions.sign') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
