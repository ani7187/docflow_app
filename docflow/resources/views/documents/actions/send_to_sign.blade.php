@extends('layouts.main')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="mb-3">
                <a href="{{ route('documents.show', ['document' => $document->id, 'section' => $section]) }}" class="btn p-0" style="cursor:pointer;">
                    <i class="mdi mdi-keyboard-backspace"></i>
                    {{ trans('menu.back') }}
                </a>
            </div>
            @include("partials.alerts")
            <div class="card">
                <div class="card-body">
{{--                    <form action="{{ route('documents.send_sign', ['document' => $document->id]) }}" method="POST"  enctype="multipart/form-data">--}}
                    @csrf
                        <div class="form-group">
                            <input name="section_id" type="number" value="{{ $section }}" hidden>
                        </div>
                        <div class="form-group">
                            <label for="notes">{{ trans('section.notes') }}</label>
                            <textarea type="text" class="form-control" id="notes" placeholder="{{ trans('section.notes') }}"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="notes">{{ trans('section.select_employee') }}</label>
                            <select name="receiver_id" id="user_ids" class="selectpicker form-control @error('user_ids')invalid-feedback is-invalid @enderror"
                                    data-live-search="true" multiple data-none-selected-text="{{ trans('user_groups.select') }}">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if($user->id = old('receiver_id')) selected @endif>{{ $user->email }}</option>
                                @endforeach
                            </select>
                            {{--                                @dump($errors->all())--}}

                            @error('user_ids.*')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary float-end">{{ trans('auth.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
