<h4 class=" text-success"><i>Կցված ֆայլերի ցանկ</i></h4>
<div id="file-mod-view-file-list" class="file-mod-view-file-list" data-curr-index="0">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table border="0" class="table table-hover" id="files-table">
                    <thead class="thead-light">
                    </thead>
                    <tbody>
{{--                    <a href="{{ $url }}" download>Download File</a>--}}

                    @foreach ($media as $file)
{{--                        @dd($file)--}}
                        <tr>
                            <td>
                                <i style="color: #9170e7; font-size: 25px;"
                                   class="mdi {{ getFileIcon($file['extension']) }}"></i>
                            </td>
                            <td>{{ $file['name'] }}</td>
                            <td>
                                <div class="float-end">
                                    <a href="" class="btn btn-sm btn-primary" target="_blank" title="Open">
                                        <i class="mdi mdi-open-in-new"></i>
                                    </a>
                                    <a href="{{ $file['url'] }}"
                                       class="btn btn-sm btn-success" target="_blank" download="{{ $file['name'] }}"
                                       title="Ներբեռնել">
                                        <i class="mdi mdi-download"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{--@extends('layouts.main')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <div class="row">--}}
{{--            <div class="col-md-12">--}}
{{--                <!-- Display document details -->--}}
{{--                <h1>{{ $document->name }}</h1>--}}
{{--                <!-- Display action history -->--}}
{{--                <h2>Action History</h2>--}}
{{--                <ul>--}}
{{--                    @foreach ($history as $action)--}}
{{--                        <li>{{ $action->action_name }} - {{ $action->created_at }}</li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--                <!-- Display media files -->--}}
{{--                <h2>Media Files</h2>--}}
{{--                <ul>--}}
{{--                    @foreach ($mediaUrls as $url)--}}
{{--                        <li><a href="{{ $url }}" target="_blank">{{ $url }}</a></li>--}}
{{--                    @endforeach--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--@endsection--}}
