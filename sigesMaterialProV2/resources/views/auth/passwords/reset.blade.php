@extends('templates.material.main')

@section('layout-content')

    <section id="wrapper" class="login-register login-sidebar"
             style="background-image:url(/vendor/wrappixel/material-pro/4.2.1/assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                @include('common.logo_01')
                <br>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="floating-labels m-b-40" method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="form-group m-b-40">
                        <div class="col-xs-12">
                            <h3>@lang('translate.PasswordResetMsg001')</h3>
                            <p class="text-muted">@lang('translate.PasswordResetMsg003')</p>
                        </div>
                    </div>

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group m-t-40 {{ $errors->has('email') ? ' has-danger' : '' }}">
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
                            id="password">
                        <span class="bar"></span>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group m-b-40 {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                        <label for="password_confirmation">@lang('translate.PasswordConfirmation')</label>
                        <input 
                            type="password" 
                            class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}"
                            name="password_confirmation"
                            id="password_confirmation">
                        <span class="bar"></span>
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group text-center m-b-40">
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light">
                            @lang('translate.Submit')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
