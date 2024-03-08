@php
    use App\Enums\UserRole;
    use App\Models\permission\Permission;
@endphp
@extends('layouts.main')

@section('content')
    @if(auth()->check())
        <div class="main-panel">
            <div class="content-wrapper">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4">
                            <a href="{{ route("sections.create") }}"  class="btn btn-gradient-primary font-weight-bold">
                                {{ trans("menu.add") }}
                            </a>
                            {{--                            <a href="{{ route("employee.export_pdf") }}" style="margin-left: 5px" class="btn btn-success font-weight-bold">--}}
                            {{--                                {{ trans("menu.export_pdf") }}--}}
                            {{--                            </a>--}}
                        </div>
                        <h4><b>{{ trans("menu.section_manager") }}</b></h4>
                        <hr>
                        <table class="table">
                            <thead>
                            <tr>
                                <th><b>{{ trans("menu.id") }}</b></th>
                                <th><b>{{ trans("menu.section_name") }}</b></th>
                                <th><b>{{ trans("menu.section_description") }}</b></th>
                                <th colspan="3"><b>{{ trans("menu.actions") }}</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($sections as $key => $section)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $section->name }}</td>
                                    <td>{{ $section->description }}</td>
                                    <td class="p-0">
                                        <!-- Edit Button -->
                                        <a class="p-0" href="{{ route('sections.edit', $section->id) }}">
                                            <i class="mdi mdi-grease-pencil"></i>
                                        </a>
                                    </td>
                                    <td class="p-0">
                                        <!-- Delete Button -->
                                        <form action="{{ route('sections.destroy', $section) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn p-0"
                                                    onclick="return confirm('{{trans('menu.want_delete')}}')"><i
                                                    class="mdi mdi-delete"></i></button>

                                        </form>
                                    </td>
                                    <td class="p-0 pl-1">
                                        <a href="{{ route('sections.permissions', $section->id) }}" data-section="{{ $section->id }}" class="btn p-0">
                                            <b>{{ trans('section.manage_permissions') }}</b>
                                        </a> {{--{{ route('sections.permissions', $section) }}--}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @section('scripts')
        <script>
        </script>
    @endsection
@endsection
