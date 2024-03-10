@php
    use App\Enums\UserRole;
    use App\Models\Permission\Permission;
@endphp

@extends('layouts.main')

@section('content')
    @if(auth()->check())
        @include('partials.alerts')

        <div class="card">
            <div class="card-body">
                <h4><b>{{ trans("section.manage_permissions") }}</b></h4>
                <hr>
                <form action="{{ route('sections.permissions.store', $section->id) }}" method="POST">
                    @csrf
                    <div class="container container-fluid">
                        <div class="row">
                            <!-- Select User -->
                            <div class="col-md-4">
                                <label for="user_id" class="pb-1">{{ trans('section.select_user') }}</label>
                                <select name="user_id[]" id="user_id" class="selectpicker form-control"
                                        data-live-search="true"
                                        data-none-selected-text="{{ trans('section.select') }}" multiple>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}"
                                                @if(in_array($user->id, old('user_id', []))) selected @endif>{{ $user->email }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Select User Group -->
                            <div class="col-md-4">
                                <label for="user_group_id" class="pb-1">{{ trans('section.select_user_group') }}</label>
                                <select name="user_group_id[]" id="user_group_id"
                                        class="selectpicker form-control"
                                        data-live-search="true"
                                        data-none-selected-text="{{ trans('section.select') }}" multiple>
                                    @foreach($userGroups as $userGroup)
                                        <option value="{{ $userGroup->id }}"
                                                @if(in_array($userGroup->id, old('user_group_id', []))) selected @endif>{{ $userGroup->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_group_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- Select Permission Type -->
                            <div class="col-md-4">
                                <label for="permission_type" class="pb-1">{{ trans('section.permission_type') }}
                                    *</label>
                                <select name="permission_type[]" class="selectpicker form-control"
                                        data-live-search="true"
                                        data-none-selected-text="{{ trans('section.select') }}" multiple>
                                    <option value="{{ Permission::PERMISSION_PREVIEW }}"
                                            @if(in_array(Permission::PERMISSION_PREVIEW, old('permission_type', []))) selected @endif>{{ trans('section.can_preview') }}</option>
                                    <option value="{{ Permission::PERMISSION_VIEW }}"
                                            @if(in_array(Permission::PERMISSION_VIEW, old('permission_type', []))) selected @endif>{{ trans('section.can_view') }}</option>
                                    <option value="{{ Permission::PERMISSION_EDIT }}"
                                            @if(in_array(Permission::PERMISSION_EDIT, old('permission_type', []))) selected @endif>{{ trans('section.can_edit') }}</option>
                                    <option value="{{ Permission::PERMISSION_ADD }}"
                                            @if(in_array(Permission::PERMISSION_ADD, old('permission_type', []))) selected @endif>{{ trans('section.can_add') }}</option>
                                </select>
                                @error('permission_type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row pt-2 mt-2">
                            <!-- Input for Expiry Date -->
                            <div class="col-md-4">
                                <label for="expires_at">{{ trans('section.expires_at') }}</label>
                                <input type="date" id="expires_at" name="expires_at" class="form-control" lang="hy"
                                       placeholder="Ընտրեք ամսաթիվը"
                                       value="{{old('expires_at')}}">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Submit Button -->
                            <div>
                                <button type="submit"
                                        class="btn btn-primary float-end">{{ trans('menu.save') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <h4><b>{{ trans("section.shared_with") }}</b></h4>
                <table class="table">
                    <thead>
                    <tr>
                        <!-- Table Headers -->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($permissions as $key => $permission)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                @if($permission->user)
                                    {{ $permission->user->email }}
                                @elseif($permission->userGroup)
                                    {{ $permission->userGroup->name }}
                                @endif
                            </td>
                            <td>
                                @if($permission->can_preview)
                                    {{ trans('section.can_preview') }},
                                @endif
                                @if($permission->can_view)
                                    {{ trans('section.can_view') }},
                                @endif
                                @if($permission->can_edit)
                                    {{ trans('section.can_edit') }},
                                @endif
                                @if($permission->can_add)
                                    {{ trans('section.can_add') }},
                                @endif
                            </td>
                            <td class="text-center">
                                <form action="{{ route('sections.permissions.destroy', $permission->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn p-0"
                                            onclick="return confirm('{{trans('menu.want_delete')}}')"><i
                                            class="mdi mdi-delete"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif
@endsection
