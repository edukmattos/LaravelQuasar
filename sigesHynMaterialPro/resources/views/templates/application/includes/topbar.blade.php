<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <!-- Logo icon -->
                <b>
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="/vendor/wrappixel/material-pro/4.2.1/assets/images/logo-icon.png"
                         alt="homepage"
                         class="dark-logo"/>
                    <!-- Light Logo icon -->
                    <img src="/vendor/wrappixel/material-pro/4.2.1/assets/images/logo-light-icon.png"
                         alt="homepage" class="light-logo"/>
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span>
                    <!-- dark Logo text -->
                    <img src="/vendor/wrappixel/material-pro/4.2.1/assets/images/logo-text.png"
                         alt="homepage"
                         class="dark-logo"/>
                    <!-- Light Logo text -->
                    <img src="/vendor/wrappixel/material-pro/4.2.1/assets/images/logo-light-text.png"
                         class="light-logo"
                         alt="homepage"/>
                </span>
            </a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav mr-auto mt-md-0">
                <!-- This is  -->
                @if(true)
                <li class="nav-item">
                    <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark"
                       href="javascript:void(0)"
                    >
                        <i class="mdi mdi-menu"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark"
                       href="javascript:void(0)"
                    >
                        <i class="ti-menu"></i>
                    </a>
                </li>
                @endif
                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                @includeWhen(true, 'templates.application.components.navbar-search')
                <!-- ============================================================== -->
                <!-- End Search -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Megamenu -->
                <!-- ============================================================== -->
                @includeWhen(true, 'templates.application.components.navbar-megamenu')
                <!-- ============================================================== -->
                <!-- End Megamenu -->
                <!-- ============================================================== -->
            </ul>
            <!-- ============================================================== -->
            <!-- User profile and search -->
            <!-- ============================================================== -->
            <ul class="navbar-nav my-lg-0">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                @includeWhen(true, 'templates.application.components.navbar-comments')
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Messages -->
                <!-- ============================================================== -->
                @includeWhen(true, 'templates.application.components.navbar-messages')
                <!-- ============================================================== -->
                <!-- End Messages -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                @includeWhen(true, 'templates.application.components.navbar-profile')
                <!-- ============================================================== -->
                <!-- End Profile -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Language -->
                <!-- ============================================================== -->
                @includeWhen(true, 'templates.application.components.navbar-lang')
                <!-- ============================================================== -->
                <!-- End Language -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
