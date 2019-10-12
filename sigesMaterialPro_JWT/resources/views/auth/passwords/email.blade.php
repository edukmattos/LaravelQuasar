@extends('templates.material.main')

@section('layout-content')
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(/vendor/wrappixel/material-pro/4.2.1/assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                @include('common.logo_01')
                <br>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="form m-b-40" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group m-b-40">
                        <div class="col-xs-12">
                            <h3 class="text-center">@lang('translate.PasswordResetMsg001')</h3>
                            <p class="text-muted">@lang('translate.PasswordResetMsg002')</p>
                        </div>
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
                    
                    <div class="form-group text-center m-b-40">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">@lang('translate.Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
