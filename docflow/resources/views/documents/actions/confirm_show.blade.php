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
            <div class="card p-3">
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
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <form action="{{ route('documents.confirm', ['document' => $document->id]) }}" id="myForm" method="POST"  enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <input name="section_id" type="number" value="{{ $section }}" hidden>
                        </div>
                        <div class="form-group">
                            <label for="notes">{{ trans('section.notes') }}</label>
                            <textarea type="text" class="form-control" id="notes" placeholder="{{ trans('section.notes') }}"></textarea>
                        </div>
                        <div class="submit-buttons float-end">
                            <button name="action" value="approve" class="btn btn-success" onclick="setFormAction('{{ route('documents.confirm', ['document' => $document->id]) }}')">{{ trans('section.confirm') }}</button>
                            <button name="action" value="reject" class="btn btn-danger" onclick="setFormAction('{{ route('documents.reject', ['document' => $document->id]) }}')">{{ trans('section.reject') }}</button>
                        </div>
{{--                        <button type="submit" class="btn btn-primary float-end">{{ trans('auth.save') }}</button>--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function setFormAction(action) {
            document.getElementById('myForm').action = action;
            document.getElementById('myForm').submit();
        }
    </script>
@endsection
