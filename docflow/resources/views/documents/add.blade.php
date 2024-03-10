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
                                                    <label for="{{ $columnName }}">{{ trans("section.$columnName") }}</label>
                                                    @if($columnName == 'creation_date')
                                                        <input type="date" class="form-control" id="{{ $columnName }}" name="{{ $columnName }}">
                                                    @else
                                                        <input type="text" class="form-control" id="{{ $columnName }}" name="{{ $columnName }}">
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="file">{{ trans('section.select_files') }}</label>
                                <input type="file" name="file" id="file" class="form-control-file" placeholder="{{ trans('section.select_files') }}" multiple>
                                <small class="form-text text-muted">{{ trans('section.allowed_file_types') }}</small>
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
        <script>
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

            FilePond.create(document.querySelector('input[type="file"]'), {
                onaddfile: (error, file) => {
                    if (!error) {
                        // Check if the uploaded file type is accepted
                        if (FilePond.options.acceptedFileTypes.includes(file.fileType)) {
                            // Perform actions for accepted file types
                            alert('Uploaded file type is accepted: ' + file.fileType);
                        } else {
                            // Perform actions for rejected file types
                            alert('Uploaded file type is not accepted: ' + file.fileType);
                            // Remove the file from FilePond
                            FilePond.removeFile(file.id);
                        }
                    }
                }
            });
        </script>

{{--        <script type="text/javascript">--}}
{{--            // new Dropzone("#my-dropzone-form", {--}}
{{--            //     thumbnailWidth:200,--}}
{{--            //     maxFiles: 5,--}}
{{--            //             acceptedFiles: "image/*,application/pdf,.doc,.docx,.txt", // Allowed file types--}}
{{--            //--}}
{{--            // })--}}

{{--            --}}{{--Dropzone.autoDiscover = false;--}}
{{--            --}}{{--var myDropzone = new Dropzone("#dropzone", {--}}
{{--            --}}{{--    url: "{{ route('documents.store') }}",--}}
{{--            --}}{{--    headers: {--}}
{{--            --}}{{--        'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
{{--            --}}{{--    },--}}
{{--            --}}{{--    paramName: "file", // Set the name for file uploads--}}
{{--            --}}{{--    autoProcessQueue: false,--}}
{{--            --}}{{--    acceptedFiles: "image/!*,application/pdf,.doc,.docx,.txt",--}}
{{--            --}}{{--    maxFiles: 5,--}}
{{--            --}}{{--    init: function() {--}}
{{--            --}}{{--        var submitButton = document.getElementById('submit-button');--}}
{{--            --}}{{--        var dropzone = this; // Store reference to Dropzone object--}}

{{--            --}}{{--        // Listen for click event on submit button--}}
{{--            --}}{{--        submitButton.addEventListener('click', function() {--}}
{{--            --}}{{--            // Process queue manually--}}
{{--            --}}{{--            debugger--}}
{{--            --}}{{--            dropzone.processQueue();--}}
{{--            --}}{{--        });--}}

{{--            --}}{{--        // Listen for success event--}}
{{--            --}}{{--        this.on("success", function(file, response) {--}}
{{--            --}}{{--            // Handle success response--}}
{{--            --}}{{--            console.log("File uploaded successfully:", file);--}}
{{--            --}}{{--            console.log("Server response:", response);--}}
{{--            --}}{{--        });--}}

{{--            --}}{{--        // Listen for error event--}}
{{--            --}}{{--        this.on("error", function(file, errorMessage, xhr) {--}}
{{--            --}}{{--            debugger--}}
{{--            --}}{{--            // Handle error response--}}
{{--            --}}{{--            console.error("File upload failed:", file);--}}
{{--            --}}{{--            console.error("Error message:", errorMessage);--}}
{{--            --}}{{--        });--}}
{{--            --}}{{--    }--}}
{{--            --}}{{--});--}}


{{--        </script>--}}
    @endsection
@endsection
