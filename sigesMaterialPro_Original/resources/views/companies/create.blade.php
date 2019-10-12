@extends('templates.material.main')

@section('content')

    @push('before-styles')
        <!-- chartist CSS -->
        <link href="/vendor/wrappixel/material-pro/4.2.1/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    @endpush

    @push('after-scripts')
        <script src="/vendor/wrappixel/material-pro/4.2.1/assets/plugins/select2/dist/js/select2.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function() {

                $.validator.setDefaults({
                    errorElement: "span",
                    errorClass: "help-block",
                    //	validClass: 'stay',
                    highlight: function (element, errorClass, validClass) {
                        $(element).addClass(errorClass); //.removeClass(errorClass);
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $(element).removeClass(errorClass); //.addClass(validClass);
                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                    },
                    errorPlacement: function (error, element) {
                        if (element.parent('.input-group').length) {
                            error.insertAfter(element.parent());
                        } else if (element.hasClass('select2')) {
                            error.insertAfter(element.next('span'));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });
                
                $('.select2').select2({
                    language: "pt-BR"
                });
            }); 
        </script>
    @endpush

    <div class="card">
        <div class="card-body">
            <h3 class="card-title text-themecolor">
                @lang('translate.CompanyNew')
            </h3>
            <div class="card-subtitle">
                Inclusão de novas empresas
            </div>
                
            {!! Form::open(['route'=>'companies.store', 'method'=>'post', 'class'=>'m-b-40']) !!}

                @include('companies._form')
                    
                <div class="text-xs-right">
                    <button type="submit" class="btn btn-success" >@lang('translate.Submit')</button>
                    <button type="reset" class="btn btn-danger">@lang('translate.Cancel')</button>
                </div>

            {!! Form::close() !!}
        </div>
    </div>

@endsection