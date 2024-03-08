@php
    use App\Enums\UserRole;
    use App\Models\section\Section;
    use App\Models\permission\Permission;use Illuminate\Database\Eloquent\Builder;
@endphp
{{--@if(Auth::check() && auth()->user()->role_id == UserRole::EMPLOYEE)--}}
<?php
$userId = auth()->user()->id;

$userGroups = \App\Models\User::find(auth()->user()->id)->userGroups;

$accessibleSections = Section::whereHas('permissions', function (Builder $query) use ($userGroups) {
    $query->where(function ($query) use ($userGroups) {
        $query->where('user_id', auth()->user()->id)
            ->orWhereIn('user_group_id', $userGroups->pluck('id')->toArray());
    });
})->get();
?>
@foreach ($accessibleSections as $section)
    <li class="nav-item {{ request()->is('*document*') && request()->section == $section->id ? 'active' : '' }}">
        <a class="nav-link {{ request()->is('*document*') && request()->section == $section->id ? 'active' : '' }}"
           href="{{ route("documents.index", ['section' => $section->id]) }}"> <!--section_manager-->
            <span class="menu-title">{{ $section->name }}</span>
            <i class="mdi mdi-file-document menu-icon"></i>
        </a>
    </li>
@endforeach


{{--            <li class="nav-item {{ request()->is('*section*') ? 'active' : '' }}">--}}
{{--                <a class="nav-link {{ request()->is('*section*') ? 'active' : '' }}"  href="{{ route("sections.index") }}"> <!--section_manager-->--}}
{{--                    <span class="menu-title">{{ trans('menu.section_manager') }}</span>--}}
{{--                    <i class="mdi mdi-plus-circle-outline menu-icon"></i>--}}
{{--                </a>--}}
{{--            </li>--}}
{{--@endif--}}
