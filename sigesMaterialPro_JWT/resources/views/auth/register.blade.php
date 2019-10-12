@extends('templates.application.master')

@section('layout-content')

    <section id="wrapper" class="login-register login-sidebar"  style="background-image:url(/vendor/wrappixel/material-pro/4.2.1/assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                @include('common.logo_01')
                <br>
                <form class="floating-labels m-b-40" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group m-b-40">
                        <div class="col-xs-12">
                            <h3>@lang('translate.Register')</h3>
                            <p class="text-muted">@lang('translate.RegisterMsg001')</p>
                        </div>
                    </div>
                   
                    <div class="form-group m-b-40 {{ $errors->has('name') ? ' has-danger' : '' }} focused">
                        <input 
                            type="text" 
                            class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" 
                            name="name" 
                            value="{{ old('name') }}" 
                            autofocus 
                            id="name">
                        <span class="bar"></span>
                        <label for="name">@lang('translate.Name')</label>
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group m-b-40 {{ $errors->has('email') ? ' has-danger' : '' }}">
                        <input 
                            type="text" 
                            class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                            name="email" 
                            value="{{ old('email') }}" 
                            id="email">
                        <span class="bar"></span>
                        <label for="email">@lang('translate.Email')</label>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group m-b-40 {{ $errors->has('password') ? ' has-danger' : '' }}">
                        <input 
                            type="password" 
                            class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            name="password" 
                            id="password">
                        <span class="bar"></span>
                        <label for="password">@lang('translate.Password')</label>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group m-b-40 {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                        <input 
                            type="password" 
                            class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                            name="password_confirmation"
                            id="password_confirmation">
                        <span class="bar"></span>
                        <label for="password_confirmation">@lang('translate.PasswordConfirmation')</label>
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>

                   <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary p-t-0">
                                <input id="checkbox-signup" type="checkbox">
                                <label for="checkbox-signup"> I agree to all <a href="#">Terms</a></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">  @lang('translate.Submit')</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>@lang('translate.RegisterMsg002') <a href="{{ route('login') }}" class="text-info m-l-5"><b>@lang('translate.SignIn')</b></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
