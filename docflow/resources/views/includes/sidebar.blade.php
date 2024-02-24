@php use App\Enums\UserRole; @endphp
<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">{{--pages/icons/mdi.html--}}
                <span class="menu-title">{{ trans('menu.input_writing')  }}</span>
                <i class="mdi mdi-arrow-down-bold menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"> {{--pages/forms/basic_elements.html--}}
                <span class="menu-title">{{ trans('menu.output_writing')  }}</span>
                <i class="mdi mdi-arrow-up-bold menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
               aria-controls="ui-basic">
                <span class="menu-title">{{ trans('menu.inner_writing')  }}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_inner') }}</a>
                    </li> {{--pages/ui-features/buttons.html--}}
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_circular') }}</a>
                    </li> {{--pages/ui-features/buttons.html--}}
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_report') }}</a>
                    </li> {{--pages/ui-features/buttons.html--}}
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('menu.inner_type_order') }}</a>
                    </li> {{--pages/ui-features/typography.html--}}
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route("profile") }}"> {{--pages/charts/chartjs.html--}}
                <span class="menu-title">{{ trans('menu.profile') }}</span>
                <i class="mdi mdi-account-circle menu-icon"></i>
            </a>
        </li>

        <li class="nav-item sidebar-actions">
              <span class="nav-link">
                <div class="border-bottom">
                  <h6 class="font-weight-normal mb-3">{{ trans('menu.admin_tools') }}</h6>
                </div>
              </span>
        </li>

        @if(auth()->user()->role_id == UserRole::COMPANY)
            <li class="nav-item">
                <a class="nav-link" href="{{ route("employee") }}">
                    <span class="menu-title">{{ trans('menu.employees') }}</span>
                    <i class="mdi mdi-account-multiple menu-icon"></i>
                </a>
            </li>
        @endif
    </ul>
</nav>
