@extends('layouts.main')

@section('content')
    {{-- @dd($sectionAdditionalColumns) --}}
    @if(auth()->check())
        <div class="main-panel">
            <div class="content-wrapper pt-4">
                <h3>{{ trans('menu.inbox') }}</h3>
{{--                <div class="card">--}}
{{--                    <div class="card-body">--}}
{{--                        <h3 class="card-title text-info text-uppercase"><b>{{ trans('actions.need_my_sign') }}</b></h3>--}}
{{--                        --}}{{-- <form action="{{ route('inbox') }}" method="GET"> --}}
{{--                        --}}{{--     <input type="text" name="search" placeholder="Search..."> --}}
{{--                        --}}{{--     <button type="submit">Search</button> --}}
{{--                        --}}{{-- </form> --}}
{{--                        <div class="table-responsive" style="border-radius: 7px"> <!-- Add this class to make the table responsive -->--}}
{{--                            <table class="table" > <!-- Add table-striped class for striped rows -->--}}
{{--                                <thead class="" style="background: #eae9e9"><!--thead-dark-->--}}
{{--                                <tr>--}}
{{--                                    <th><b>{{ trans("menu.id") }}</b></th>--}}
{{--                                    <th><b>{{ trans("section.number") }}</b></th>--}}
{{--                                    <th><b>{{ trans('actions.action_name') }}</b></th>--}}
{{--                                    <th><b>{{ trans('actions.sender') }}</b></th>--}}
{{--                                    <th><b>{{ trans('actions.notes') }}</b></th>--}}
{{--                                    <th><b>{{ trans('actions.date') }}</b></th>--}}
{{--                                </tr>--}}
{{--                                </thead>--}}
{{--                                <tbody>--}}
{{--                                @if(empty($signHistory[0]))--}}
{{--                                    <tr class="table-row ">--}}
{{--                                        <td colspan="5" class="text-center">Համապատասխան տվյալներ չեն գտնվել</td>--}}
{{--                                    </tr>--}}
{{--                                @endif--}}
{{--                                @foreach ($signHistory as $key => $action)<!--table-info-->--}}
{{--                                    <tr class="table-row table-info" style="cursor: pointer;" onclick="window.location='{{ route('documents.show', ['document' => $action->document_id, 'section' => $action->section_id]) }}';">--}}
{{--                                        <td>{{ $key + 1 }}</td>--}}
{{--                                        <td>{{ $action->document->number }}</td>--}}
{{--                                        <td>{{ trans('actions.'.$action->action_name) }}</td>--}}
{{--                                        <td>{{ $action->executor->name }}</td>--}}
{{--                                        <td title="{{$action->notes}}">{{ substr($action->notes, 0, 50) }}</td>--}}
{{--                                        <td>{{ $action->created_at->format('Y-m-d H:i:s') }}</td>--}}
{{--                                    </tr>--}}
{{--                                @endforeach--}}
{{--                                </tbody>--}}
{{--                            </table>--}}
{{--                        </div>--}}
{{--                        <div class="mt-5 float-end" style="height: 50px">--}}
{{--                            {{ $signHistory->links('pagination::bootstrap-4') }}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="card-title text-warning text-uppercase"><b>{{ trans('actions.need_my_confirm') }}</b></h3>
                        {{-- <form action="{{ route('inbox') }}" method="GET"> --}}
                        {{--     <input type="text" name="search" placeholder="Search..."> --}}
                        {{--     <button type="submit">Search</button> --}}
                        {{-- </form> --}}
                        <div class="table-responsive" style="border-radius: 7px"> <!-- Add this class to make the table responsive -->
                            <table class="table" > <!-- Add table-striped class for striped rows -->
                                <thead class="" style="background: #eae9e9"><!--thead-dark-->
                                <tr class="">
                                    <th><b>{{ trans("menu.id") }}</b></th>
                                    <th><b>{{ trans("section.number") }}</b></th>
                                    {{--                                    <th><b>{{ trans('actions.action_name') }}</b></th>--}}
                                    <th><b>{{ trans('actions.sender') }}</b></th>
                                    <th><b>{{ trans('actions.notes') }}</b></th>
                                    <th><b>{{ trans('actions.date') }}</b></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(empty($confirmationHistory[0]))
                                    <tr class="table-row ">
                                        <td colspan="5" class="text-center">Համապատասխան տվյալներ չեն գտնվել</td>
                                    </tr>
                                @endif
                                @foreach ($confirmationHistory as $key => $action)<!--table-info-->
                                <tr class="table-row table-warning" style="cursor: pointer;" onclick="window.location='{{ route('documents.show', ['document' => $action->document_id, 'section' => $action->section_id]) }}';">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $action->document->number }}</td>
                                    {{--                                        <td>{{ trans('actions.'.$action->action_name) }}</td>--}}
                                    <td>{{ $action->executor->name }}</td>
                                    <td title="{{$action->notes}}">{{ substr($action->notes, 0, 50) }}</td>
                                    <td>{{ $action->created_at->format('Y-m-d H:i:s') }}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-5 float-end" style="height: 50px">
                            {{ $confirmationHistory->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
