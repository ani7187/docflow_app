@extends('layouts.main')


@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            @include("partials.alerts")
            @if($document->document_execution_status == 1 && !empty($receiveAction) || !empty($executeActions))
                @include("partials.actions",
                            ["documentID" => $document->id,
                            "sectionID" => $document->section_id,
                            'receiveAction' => $receiveAction,
                            'executeActions' => $executeActions])
            @endif
                {{--            <div class="card">--}}
            {{--                <div class="card-body">--}}
            <div>
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="document-info-tab" data-toggle="tab" href="#document-info"
                           role="tab" aria-controls="document-info" aria-selected="true"> {{ trans('section.main_info') }} </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="action-history-tab" data-toggle="tab" href="#action-history" role="tab"
                           aria-controls="action-history" aria-selected="false">{{ trans('section.action_history') }}</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="document-info" role="tabpanel"
                         aria-labelledby="document-info-tab">
                        <div class="card">
                            <div class="card-body" style="min-height: 350px;">
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
                    <div class="tab-pane fade" id="action-history" role="tabpanel" aria-labelledby="action-history-tab">
                        <div class="card">
                            <div class="card-body" style="min-height: 350px;">
                                <div id="action-history-content">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th><b>{{ trans('actions.action_name') }}</b></th>
                                            <th><b>{{ trans('actions.executor') }}</b></th>
                                            <th><b>{{ trans('actions.receiver') }}</b></th>
                                            <th><b>{{ trans('actions.notes') }}</b></th>
                                            <th><b>{{ trans('actions.date') }}</b></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($history as $action)
                                            <tr>
                                                <td>{{ trans('actions.'.$action->action_name) }}</td>
                                                <td>{{ $action->executor->name }}</td>
                                                <td>{{ $action->receiver->name ?? "" }}</td>
                                                <td title="{{$action->notes}}">{{ substr($action->notes, 0, 50) }}</td>
                                                <td>{{ $action->created_at->format('Y-m-d H:i:s') }}</td>
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
@endsection
@section('scripts')
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            debugger--}}
{{--            $('#action-history-tab').on('click', function(e) {--}}
{{--                debugger--}}
{{--                // e.preventDefault();--}}
{{--                var url = "";--}}
{{--                $.ajax({--}}
{{--                    url: url,--}}
{{--                    type: 'GET',--}}
{{--                    success: function(response) {--}}
{{--                        debugger--}}
{{--                        // Render the action history content--}}
{{--                        $('#action-history-content').html("aa");--}}
{{--                    },--}}
{{--                    error: function(xhr, status, error) {--}}
{{--                        // Handle errors--}}
{{--                        console.error(error);--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection
