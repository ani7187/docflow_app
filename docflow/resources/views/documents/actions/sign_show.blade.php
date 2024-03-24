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
            <div class="card">
                <div class="card-body">
                    @include("partials.files", ["media" => $media])
                </div>
            </div>
            <div class="card mt-2">
                <div class="card-body">
                    <form action="" method="POST"  enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <input name="section_id" type="number" value="{{ $section }}" hidden>
                        </div>
                        <div class="form-group">
                            <label for="notes">{{ trans('section.notes') }}</label>
                            <textarea type="text" class="form-control" id="notes" placeholder="{{ trans('section.notes') }}"></textarea>
                        </div>
                        <div class="submit-buttons float-end">
                            <button name="action" value="approve" class="btn btn-success" onclick="submitForm('confirm')">{{ trans('section.confirm') }}</button>
                            <button name="action" value="reject" class="btn btn-danger" onclick="submitForm('reject')">{{ trans('section.reject') }}</button>
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
        function submitForm(action) {
            // Get form data
            var formData = new FormData(document.getElementById('resolutionForm'));
            // Add additional data if needed based on the action
            if (action === 'approve') {
                formData.append('confirm_status', 'approve');
            } else if (action === 'reject') {
                formData.append('confirm_status', 'reject');
            }

            // Submit the form
            fetch('/your-endpoint', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                    // Handle success response
                })
                .catch(error => {
                    console.error('There was a problem with the fetch operation:', error);
                    // Handle error
                });
        }
    </script>
@endsection
