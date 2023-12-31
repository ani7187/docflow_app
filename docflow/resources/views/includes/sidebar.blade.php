<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="#">{{--pages/icons/mdi.html--}}
                <span class="menu-title">{{ trans('writing.input_writing')  }}</span>
                <i class="mdi mdi-arrow-down-bold menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"> {{--pages/forms/basic_elements.html--}}
                <span class="menu-title">{{ trans('writing.output_writing')  }}</span>
                <i class="mdi mdi-arrow-up-bold menu-icon"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false"
               aria-controls="ui-basic">
                <span class="menu-title">{{ trans('writing.inner_writing')  }}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('writing.inner_type_inner') }}</a>
                    </li> {{--pages/ui-features/buttons.html--}}
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('writing.inner_type_circular') }}</a>
                    </li> {{--pages/ui-features/buttons.html--}}
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('writing.inner_type_report') }}</a>
                    </li> {{--pages/ui-features/buttons.html--}}
                    <li class="nav-item"><a class="nav-link" href="#">{{ trans('writing.inner_type_order') }}</a>
                    </li> {{--pages/ui-features/typography.html--}}
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#"> {{--pages/charts/chartjs.html--}}
                <span class="menu-title">{{ trans('writing.profile') }}</span>
                <i class="mdi mdi-account-circle menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
