<div class="user-profile"
     style="background: url(/vendor/wrappixel/material-pro/4.2.1/assets/images/background/user-info.jpg) no-repeat;"
>
    <!-- User profile image -->
    <div class="profile-img">
        {{--Replace with User image here--}}
        <img src="/vendor/wrappixel/material-pro/4.2.1/assets/images/users/1.jpg" alt="user"/>
    </div>
    <!-- User profile text-->
    <div class="profile-text">

        <a href="#"
           class="dropdown-toggle u-dropdown"
           data-toggle="dropdown"
           role="button"
           aria-haspopup="true"
           aria-expanded="true"
        >
            Empresas
        </a>

        @include('layouts.partials.dashboard._companies-select')
    </div>
</div>
