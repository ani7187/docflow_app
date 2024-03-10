@php
    use App\Enums\UserRole;
    use App\Models\permission\Permission;
@endphp
@extends('layouts.main')

@section('content')
    {{--            @dd($sectionAdditionalColumns)--}}
    @if(auth()->check())
        <div class="main-panel">
            <div class="content-wrapper pt-4">
                @if(!empty($userPermissions) && !empty($sectionAdditionalColumns))
                    <h3>{{$section->name}}</h3>
                    @include("partials.alerts")
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex mb-4">
                                @if($userPermissions["can_add"])
                                    <a href="{{ route("documents.add", ['section' => $section->id]) }}"
                                       class="btn btn-gradient-primary font-weight-bold">
                                        {{ trans("menu.add") }}
                                    </a>
                                @endif
                            </div>
                            <hr>
                            <div>
                                <table class="table">
                                    <thead>
                                    <tr style="background: #eae9e9">
                                        <th><b>{{ trans("menu.id") }}</b></th>
                                        @foreach(config('application.additional_column_list') as $additionalColumn)
                                            @if($additionalColumn == "uploaded_by")
                                                <th><b>{{ trans("section.$additionalColumn") }}</b></th>
                                            @elseif($sectionAdditionalColumns[$additionalColumn])
                                                <th><b>{{ trans("section.$additionalColumn") }}</b></th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($documents as $key => $document)
                                        <tr onclick="window.location='{{ route('documents.show', ['document' => $document->id, 'section' => $section->id]) }}';"
                                            style="cursor:pointer;background: #fdfcfc">
                                            <td>{{ $key + 1 }}</td>
                                            @foreach(config('application.additional_column_list') as $additionalColumn)
                                                @if($additionalColumn == "uploaded_by")
                                                    <td>{{ $document->uploader->email }}</td>
                                                @elseif($sectionAdditionalColumns[$additionalColumn])
                                                    <td>{{ $document->$additionalColumn }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div style="height: 50px">
                                {{ $documents->appends(['section' => request()->section])->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                You have no permissions
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @include('partials.footer')
        </div>
    @endif
@endsection
