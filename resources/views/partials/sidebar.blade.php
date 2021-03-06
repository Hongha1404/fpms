<button class="m-aside-left-close m-aside-left-close--skin-dark" id="m_aside_left_close_btn">
    <i class="la la-close"></i>
</button>
<div id="m_aside_left" class="m-grid__item  m-aside-left  m-aside-left--skin-dark ">
    <!-- BEGIN: Aside Menu -->
    <div id="m_ver_menu" class="m-aside-menu  m-aside-menu--skin-dark m-aside-menu--submenu-skin-dark " data-menu-vertical="true" data-menu-scrollable="false" data-menu-dropdown-timeout="500">
        <ul class="m-menu__nav  m-menu__nav--dropdown-submenu-arrow ">
            <li class="m-menu__item  m-menu__item--active" aria-haspopup="true">
                <a href="{{ route('user.dashboard') }}" class="m-menu__link ">
                    <i class="m-menu__link-icon flaticon-line-graph"></i>
                    <span class="m-menu__link-title">
                        <span class="m-menu__link-wrap">
                            <span class="m-menu__link-text">
                                Dashboard
                            </span>
                            <span class="m-menu__link-badge">
                                <span class="m-badge m-badge--danger">
                                    2
                                </span>
                            </span>
                        </span>
                    </span>
                </a>
            </li>
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                        Components
                    </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
            <li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true" data-menu-submenu-toggle="hover">
                <a href="{{ route('user.project.index') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">
                        Projects
                    </span>
                </a>
                <a href="{{ route('user.release.index') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">
                        Release Plan
                    </span>
                </a>
                <a href="{{ route('user.sprint.index') }}" class="m-menu__link">
                    <i class="m-menu__link-icon flaticon-layers"></i>
                    <span class="m-menu__link-text">
                        Sprint
                    </span>
                </a>
            </li>
            <li class="m-menu__section">
                <h4 class="m-menu__section-text">
                    Snippets
                </h4>
                <i class="m-menu__section-icon flaticon-more-v3"></i>
            </li>
        </ul>
    </div>
    <!-- END: Aside Menu -->
</div>
