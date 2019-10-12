@extends('templates.application.master')

@section('template-custom-js')

    <script src="/vendor/wrappixel/material-pro/4.2.1/material/js/custom.min.js"></script>

    <script>
        $(function () {
            $("#back-to-login").click(function () {
                $("#loginform").slideDown()
                $("#recoverform").fadeOut()
            })
        })
    </script>

@endsection

@section('layout-content')

<section id="wrapper" class="login-register login-sidebar" style="background-image:url(/vendor/wrappixel/material-pro/4.2.1/assets/images/background/login-register.jpg);">
    <div class="login-box card">
        <div class="card-body">
            @include('common.logo_01')
            <form class="form m-t-40" id="loginform" method="POST" action="#">
                @csrf
                <div class="box-title m-t-40 m-b-0 text-center">
                    <i class="mdi mdi-48px mdi-fingerprint"></i>
                </div>

                <div class="form-group m-b-40 {{ $errors->has('email') ? ' has-danger' : '' }}">
                    <label for="email">@lang('translate.Email')</label>
                    <input 
                        type="text" 
                        class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" 
                        name="email" 
                        value="{{ old('email') }}" 
                        id="email">
                    <span class="bar"></span>
                    @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                         </span>
                    @endif
                </div>

                <div class="form-group m-b-40 {{ $errors->has('password') ? ' has-danger' : '' }}">
                    <label for="password">@lang('translate.Password')</label>
                    <input 
                        type="password" 
                        class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" 
                        name="password" 
                        value="" 
                        id="password">
                    <span class="bar"></span>
                    @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                         </span>
                    @endif
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <div class="checkbox checkbox-primary pull-left p-t-0">
                            <input id="checkbox-signup" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <label for="checkbox-signup"> @lang('translate.RememberMe') </label>
                        </div>
                        <a href="{{ route('password.request') }}" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i>@lang('translate.ForgotYourPassword')</a> </div>
                </div>
                <div class="form-group text-center m-t-20">
                    <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">@lang('translate.Submit')</button>
                    </div>
                </div>
                <div class="form-group m-b-0">
                    <div class="col-sm-12 text-center">
                        <p>@lang('translate.DontHaveAnCount') <a href="{{ route('register') }}" class="text-primary m-l-5"><b>@lang('translate.SignUp')</b></a></p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
