<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="#" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('section.manage_permissions') }}</h5>
                    <button type="button" class="close btn p-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="user_id" class="pb-1">{{ trans('section.select_user') }}</label>
                                <select name="user_id" id="user_id" class="selectpicker form-control"
                                        data-live-search="true"
                                        data-none-selected-text="{{ trans('section.select') }}" multiple>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->email }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="user_group_id" class="pb-1">{{ trans('section.select_user_group') }}</label>
                                <select name="user_group_id" id="user_group_id" class="selectpicker form-control"
                                        data-live-search="true"
                                        data-none-selected-text="{{ trans('section.select') }}" multiple>
                                    @foreach($userGroups as $userGroup)
                                        <option value="{{ $userGroup->id }}">{{ $userGroup->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_group_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label for="permission_type" class="pb-1">{{ trans('section.permission_type') }}</label>
                                <select name="permission_type" class="selectpicker form-control"
                                        data-live-search="true"
                                        data-none-selected-text="{{ trans('section.select') }}" multiple>
                                    <option value="{{ Permission::PERMISSION_PREVIEW }}">Read</option>
                                    <option value="{{ Permission::PERMISSION_VIEW }}">Write</option>
                                    <option value="{{ Permission::PERMISSION_EDIT }}">Delete</option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-2">
                            <div class="col-md-4">
                                <input type="date" name="expires_at" class="form-control" value="{{ now()->toDateString() }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary float-end">{{ trans('menu.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
