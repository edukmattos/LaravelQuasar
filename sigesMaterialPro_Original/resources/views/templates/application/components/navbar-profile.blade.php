<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark"
       href="" data-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        <img src="/vendor/wrappixel/material-pro/4.2.1/assets/images/users/1.jpg" alt="user" class="profile-pic"/>
    </a>
    @auth
        <div class="dropdown-menu dropdown-menu-right scale-up">
            <ul class="dropdown-user">
                <li>
                    <div class="dw-user-box">
                        <div class="u-img">
                            {{--Replace with User image here--}}
                            <img src="/vendor/wrappixel/material-pro/4.2.1/assets/images/users/1.jpg" alt="user" class="profile-pic"/>
                        </div>
                        <div class="u-text">
                            <h4>{{ Auth::user()->name }}</h4>
                            <p class="text-muted">{{ Auth::user()->name }}'s Role</p>
                            <a href="" class="btn btn-rounded btn-danger btn-sm">
                                View Profile
                            </a>
                        </div>
                    </div>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="#"><i class="ti-user"></i> @lang('translate.MyProfile')</a></li>
                <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="/logout"><i class="fa fa-power-off"></i> @lang('translate.LogOut')</a></li>
            </ul>
        </div>
    @endauth
</li>
