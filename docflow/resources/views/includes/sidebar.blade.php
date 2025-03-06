@php use App\Enums\UserRole; @endphp
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#">--}}{{--pages/icons/mdi.html--}}
{{--                <span class="menu-title">{{ trans('menu.input_writing')  }}</span>--}}
{{--                <i class="mdi mdi-arrow-down-bold menu-icon"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#"> --}}{{--pages/forms/basic_elements.html--}}
{{--                <span class="menu-title">{{ trans('menu.output_writing')  }}</span>--}}
{{--                <i class="mdi mdi-arrow-up-bold menu-icon"></i>--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"--}}
{{--               aria-controls="ui-basic">--}}
{{--                <span class="menu-title">{{ trans('menu.inner_writing')  }}</span>--}}
{{--                <i class="menu-arrow"></i>--}}
{{--            </a>--}}
{{--            <div class="collapse" id="ui-basic">--}}
{{--                <ul class="nav flex-column sub-menu">--}}
{{--                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_inner') }}</a>--}}
{{--                    </li> --}}{{--pages/ui-features/buttons.html--}}
{{--                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_circular') }}</a>--}}
{{--                    </li> --}}{{--pages/ui-features/buttons.html--}}
{{--                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_report') }}</a>--}}
{{--                    </li> --}}{{--pages/ui-features/buttons.html--}}
{{--                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_order') }}</a>--}}
{{--                    </li> --}}{{--pages/ui-features/typography.html--}}
{{--                </ul>--}}
{{--            </div>--}}
{{--        </li>--}}

{{--        <li class="nav-item sidebar-actions">--}}
{{--              <span class="nav-link">--}}
{{--                <div class="border-bottom">--}}
{{--                  <h6 class="font-weight-normal mb-3">{{ trans('menu.sections') }}</h6>--}}
{{--                </div>--}}
{{--              </span>--}}
{{--        </li>--}}
{{--        @if(auth()->user()->role_id == UserRole::EMPLOYEE)--}}
{{--        @endif--}}

        @if(!auth()->user()->password_change_required)
        <li class="nav-item">
            <a class="nav-link {{ request()->is('*inbox*') ? 'active' : '' }}"  href="{{ route("inbox") }}"> <!--section_manager-->
                <span class="menu-title">{{ trans('menu.inbox') }}</span>
                <i class="mdi mdi-inbox menu-icon"></i>
            </a>
        </li>
            @include('includes.dyn_sidebar')
        @endif
        @if(auth()->user()->role_id == UserRole::COMPANY)
{{--            @if(auth()->user()->sections()->get())--}}
{{--                @foreach(auth()->user()->sections()->get() as $section)--}}
{{--                    {{dd(request()->is('*document*') && request()->section == $section->id)}}--}}
{{--                    <li class="nav-item {{ request()->is('*document*') && request()->section == $section->id ? 'active' : '' }}">--}}
{{--                        <a class="nav-link {{ request()->is('*document*') && request()->section == $section->id ? 'active' : '' }}"  href="{{ route("documents.index", ['section' => $section->id]) }}"> <!--section_manager-->--}}
{{--                            <span class="menu-title">{{ $section->name }}</span>--}}
{{--                            <i class="mdi mdi-file-document menu-icon"></i>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            @endif--}}
{{--            <li class="nav-item sidebar-actions">--}}
{{--              <span class="nav-link">--}}
{{--                <div class="border-bottom">--}}
{{--                  <h6 class="font-weight-normal mb-3">{{ trans('menu.admin_tools') }}</h6>--}}
{{--                </div>--}}
{{--              </span>--}}
{{--            </li>--}}

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#general-pages" aria-expanded="true" aria-controls="general-pages">
                    <span class="menu-title">Կարգավորումներ</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse show" id="general-pages" style="">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('*section*') ? 'active' : '' }}"  href="{{ route("sections.index") }}"> <!--section_manager-->
                                <span class="menu-title">{{ trans('menu.section_manager') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('*user_groups*') ? 'active' : '' }}" href="{{ route("user_groups") }}">
                                <span class="menu-title">{{ trans('menu.user_groups') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('*employee*') ? 'active' : '' }}" href="{{ route("employee") }}">
                                <span class="menu-title">{{ trans('menu.employees') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

<!--            <li class="nav-item">
                <a class="nav-link {{ request()->is('*section*') ? 'active' : '' }}"  href="{{ route("sections.index") }}"> &lt;!&ndash;section_manager&ndash;&gt;
                    <span class="menu-title">{{ trans('menu.section_manager') }}</span>
                    <i class="mdi mdi-plus-circle-outline menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*user_groups*') ? 'active' : '' }}" href="{{ route("user_groups") }}">
                    <span class="menu-title">{{ trans('menu.user_groups') }}</span>
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('*employee*') ? 'active' : '' }}" href="{{ route("employee") }}">
                    <span class="menu-title">{{ trans('menu.employees') }}</span>
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
            </li>-->
        @endif
        <li class="nav-item">
            <a class="nav-link border-top" href="{{ route("profile") }}"> {{--pages/charts/chartjs.html--}}
                <span class="menu-title">{{ trans('menu.profile') }}</span>
                <i class="mdi mdi-account-circle menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
