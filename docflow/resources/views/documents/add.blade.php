@php use App\Enums\UserRole; @endphp
@extends('layouts.main')

@section('content')
    <style>
    #dropzone {
        border: 2px dashed #aaa;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        margin-top: 20px;
        cursor: pointer;
    }
</style>

    @if(auth()->check())
{{--            {{dd(auth()->user()->partnerOrganization->company_code)}}--}}

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="mb-3">
                    <a href="{{ route('documents.index', ['section' => $section->id]) }}" class="btn p-0" style="cursor:pointer;">
                        <i class="mdi mdi-keyboard-backspace"></i>
                        {{ trans('menu.back') }}
                    </a>
                </div>
                @include("partials.alerts")

                <div class="card">
                    <div class="card-body">
                        <form id="uploadForm" method="POST" action="{{ route('documents.store') }}"  enctype="multipart/form-data">
                            @csrf <!-- Include CSRF token here -->
                            <div class="form-group">
                                <input name="section_id" type="number" value="{{ $section->id }}" hidden>
                            </div>
                            <!-- Additional form fields for section additional columns -->
                            @if($sectionAdditionalColumns)
                                <div class="row">
                                    @foreach($sectionAdditionalColumns->getAttributes() as $columnName => $value)
                                        @if($value && in_array($columnName, config('application.additional_column_list')))
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    @if($columnName == 'creation_date')
                                                        <label for="{{ $columnName }}">{{ trans("section.$columnName") }}</label>
                                                        <input type="date" class="form-control" id="{{ $columnName }}" name="{{ $columnName }}">
{{--                                                    @elseif($columnName == 'notes')--}}
{{--                                                        <textarea name="content" id="myTextarea"></textarea>--}}
                                                    @else
                                                        <label for="{{ $columnName }}">{{ trans("section.$columnName") }}</label>
                                                        <input type="text" class="form-control" id="{{ $columnName }}" name="{{ $columnName }}">
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
{{--                                <div class="row mb-5">--}}
{{--                                    <div class="col-md-12">--}}
{{--                                        <div class="form-group">--}}
{{--                                            @if(in_array('notes', config('application.additional_column_list')))--}}
{{--                                                <textarea class="form-control" id="summernote" name="notes"></textarea>--}}
{{--                                            @endif--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            @endif

                            <div class="form-group">
                                <label for="file">{{ trans('section.select_files') }}</label>
                                <input type="file" name="file[]" id="file" class="form-control-file" placeholder="{{ trans('section.select_files') }}" multiple>
                                <small class="form-text text-muted">{{ trans('section.allowed_file_types') }}</small>

                                @error('file')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
{{--                            <div id="dropzone" class="dropzone"></div>--}}

                            <button type="submit" id="submit-button" class="btn btn-primary float-end mt-5">
                                {{ trans('auth.save') }}
                            </button>
                        </form>
{{--                        <form id="my-dropzone-form" class="dropzone" method="POST" action="{{ route('documents.store') }}"  enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        </form>--}}

                    </div>
                </div>
            </div>
        </div>
    @endif
    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

        <script>

            // tinymce.init({
            //     selector: 'textarea', // Change this to your textarea selector
            //     plugins: 'advlist autolink lists link image charmap print preview anchor',
            //     toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            //     menubar: 'file edit view insert format tools table help',
            //     toolbar_mode: 'floating',
            //     height: 400
            // });

            // Get a reference to the file input element
            const inputElement = document.querySelector('input[id="file"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);

            FilePond.setOptions({
                server: {
                    url: '/upload',
                    headers : {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                },
                acceptedFileTypes: ['image/jpeg', 'image/png', 'application/pdf', 'application/zip', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']
            });
    </script>
        <script>
            $(document).ready(function() {
                debugger
                $('#summernote').summernote();
            });
        </script>
    @endsection
@endsection
