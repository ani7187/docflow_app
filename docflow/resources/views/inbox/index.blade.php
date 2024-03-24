@extends('layouts.main')

@section('content')
    {{--            @dd($sectionAdditionalColumns)--}}
    @if(auth()->check())
        <div class="main-panel">
            <div class="content-wrapper pt-4">
                <h3>{{ trans('menu.inbox') }}</h3>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th><b>{{ trans("menu.id") }}</b></th>
                                <th><b>{{ trans('actions.action_name') }}</b></th>
                                <th><b>{{ trans('actions.sender') }}</b></th>
                                <th><b>{{ trans('actions.notes') }}</b></th>
                                <th><b>{{ trans('actions.date') }}</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($history as $key => $action)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ trans('actions.'.$action->action_name) }}</td>
                                    <td>{{ $action->executor->name }}</td>
                                    <td title="{{$action->notes}}">{{ substr($action->notes, 0, 50) }}</td>
                                    <td>{{ $action->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5 float-end" style="height: 50px">
                            {{ $history->links('pagination::bootstrap-4') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
