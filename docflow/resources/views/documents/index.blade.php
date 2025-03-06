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
                            <div>
                                <form action="{{ route('documents.index') }}" method="GET">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="hidden" name="section" value="{{ $section->id }}">
                                            <input type="text" name="q" class="form-control" placeholder="Որոնել..." value="{{ request('q') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-gradient-success" type="submit">Որոնել</button>
                                        </div>
                                    </div>
                                </form>
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
                                        <th><b>{{ trans("section.statuses") }}</b></th>
                                        @if($userPermissions["can_edit"])
                                            <td></td>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($documents as $key => $document)
{{--                                        @dd($documents)--}}

                                        <tr style="background: #fdfcfc" class="@if($document->document_execution_status == 2) table-success @else table-warning @endif">
                                            <td>{{ $key + 1 }}</td>
                                            @foreach(config('application.additional_column_list') as $additionalColumn)
                                                @if($additionalColumn == "uploaded_by")
                                                    <td @if($userPermissions["can_view"]) style="cursor:pointer" onclick="window.location='{{ route('documents.show', ['document' => $document->id, 'section' => $section->id]) }}';" @endif>{{ $document->uploader->email }}</td>
                                                @elseif($sectionAdditionalColumns[$additionalColumn])
                                                    <td @if($userPermissions["can_view"]) style="cursor:pointer" onclick="window.location='{{ route('documents.show', ['document' => $document->id, 'section' => $section->id]) }}';" @endif>{{ $document->$additionalColumn }}</td>
                                                @endif
                                            @endforeach
                                            <td>
                                                @if($document->confirmation_status == 1)
                                                    <label class="badge badge-success" title="Հաստատվել է"><i class="mdi mdi-thumbs-up-down"></i></label>
                                                @elseif($document->confirmation_status == 2)
                                                    <label class="badge badge-danger" title="Մերժվել է"><i class="mdi mdi-thumbs-up-down"></i></label>
                                                @endif
                                                @if($document->document_signature_status)
                                                    <label class="badge badge-info" title="Ստորագրվել է"><i class="mdi mdi-grease-pencil btn-icon-prepend"></i></label>
                                                @endif
                                            </td>
                                            @if($userPermissions["can_edit"])
                                                <td class="text-center">
                                                    <form action="{{ route('documents.destroy', $document->id) }}"
                                                          id="delete-form" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn p-0">
                                                            <i class="mdi mdi-delete delete-button"></i></button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2">
                                <label class="badge badge-warning">.</label> Ընթացիկ &nbsp;&nbsp;
                                <label class="badge badge-success">.</label> Ավարտված
                            </div>
                            <div class="mt-5 float-end" style="height: 50px">
                                {{ $documents->appends(['section' => request()->section])->links('pagination::bootstrap-4') }}
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
@section('scripts')
    <script>
        debugger
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: '{{ trans('menu.want_delete') }}',
                    icon: 'warning',
                    confirmButtonText: '{{ trans('menu.confirm') }}',
                    cancelButtonText: '{{ trans('menu.cancel') }}',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#delete-form').submit();
                    }
                });
            })
        })
    </script>
@endsection
