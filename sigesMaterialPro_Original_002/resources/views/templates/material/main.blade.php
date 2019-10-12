@extends('templates.application.master')

{{-- ### Attributes for Layout are added here ### --}}
{{--Possibilities:  'fix-header'  'fix-sidebar' 'boxed' 'logo-center' 'single-column' --}}
{{--You can make combinations with them--}}
@section('body-classes', 'fix-header fix-sidebar logo-center')

@section('template-css')
    <link href="{{ mix('/css/material/style.css') }}" rel="stylesheet">
    <link href="{{ mix('/css/colors/blue.css') }}" id="theme" rel="stylesheet">
@endsection

@section('template-custom-js')
    <script src="/vendor/wrappixel/material-pro/4.2.1/material/js/custom.min.js"></script>
@endsection

@section('layout-content')

    @include('templates.application.includes.topbar')

    @tenant
        @include('templates.material.tenant.left-sidebar')
    @else
        @include('templates.material.left-sidebar')
    @endtenant
    
    <div class="page-wrapper">

        <div class="container-fluid">

            @if(true)
                @include('templates.application.includes.breadcrumb')
            @else
                <div class="row mb-4"></div>
            @endif

            @yield('content')

            @include('templates.application.includes.right-sidebar')

        </div>

    </div>

@endsection
