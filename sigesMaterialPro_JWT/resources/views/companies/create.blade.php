@extends('templates.material.main')

@section('content')

    @push('after-scripts')
        <script src="/vendor/wrappixel/material-pro/4.2.1/assets/plugins/bootstrap-autocomplete/bootstrap-autocomplete.min.js"></script>

        <script>
            $(document).ready(function(){
                const businessTypeIdOldValue = '{{ old('business_type_id') }}';

                if(businessTypeIdOldValue !== '') {
                    $('#business_types_options').val(businessTypeIdOldValue);
                }

                $('#business_types_options').autoComplete({
                    minLength: 2
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