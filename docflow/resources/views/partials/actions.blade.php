@php
@endphp
<div class="card mb-4">
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <a href="{{ route('documents.edit', ['document' => $documentID, 'section' => $sectionID]) }}" type="button" class="btn btn-outline-danger btn-icon-text"title="Խմբագրել">
                        <i class="mdi mdi-file-document-edit btn-icon-prepend"></i> {{ trans('actions.edit') }}
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('documents.send_to_confirmation', ['document' => $documentID, 'section' => $sectionID]) }}" type="button" class="btn btn-outline-success btn-icon-text" title="Ուղարկել հաստատման">
                        <i class="mdi mdi-check-circle btn-icon-prepend"></i> {{ trans('actions.send_to_confirmation') }}
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('documents.confirm_show', ['document' => $documentID, 'section' => $sectionID]) }}" type="button" class="btn btn-outline-warning btn-icon-text" title="Հաստատել">
                        <i class="mdi mdi-thumbs-up-down"></i> {{ trans('actions.confirm') }}
                    </a>
                </div>
{{--                <div class="col-md-3">--}}
{{--                    <button type="button" class="btn btn-outline-warning btn-icon-text" title="Ուղարկել ճանաչման">--}}
{{--                        <i class="mdi mdi mdi-eye btn-icon-prepend"></i> Ուղարկել ճանաչման--}}
{{--                    </button>--}}
{{--                </div>--}}
                <div class="col-md-3">
                    <a href="{{ route('documents.send_to_sign', ['document' => $documentID, 'section' => $sectionID]) }}" type="button" class="btn btn-outline-info btn-icon-text" title="Ուղարկել ստորագրման">
                        <i class="mdi mdi-file-send btn-icon-prepend"></i> {{ trans('actions.send_to_sign') }}
                    </a>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('documents.sign_show', ['document' => $documentID, 'section' => $sectionID]) }}" type="button" class="btn btn-outline-pinterest btn-icon-text" title="Ուղարկել Ստորագրել">
                        <i class="mdi mdi-grease-pencil btn-icon-prepend"></i> {{ trans('actions.sign') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
