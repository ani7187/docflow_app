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
                        <tr>
                            <td>
                                <i style="color: #9170e7; font-size: 25px;" class="mdi {{ getFileIcon($file->extension) }}"></i>
                            </td>
                            <td>{{ $file->name }}</td>
                            <td>
                                <div class="float-end">
                                    <a href="" class="btn btn-sm btn-primary" target="_blank" title="Open">
                                        <i class="mdi mdi-open-in-new"></i>
                                    </a>
                                    <a href="{{ route('media.download', ['media' => $file->id]) }}" class="btn btn-sm btn-success" target="_blank" download="{{ $file->name }}" title="Ներբեռնել">
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
