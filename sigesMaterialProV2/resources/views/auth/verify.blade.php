@extends('templates.material.main')

@section('content')
   <div class="card">
        <div class="card-body">
            <div class="card-header">@lang('translate.VerifyYourEmailAddress')</div>
                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('translate.VerifyYourEmailAddressMsg004')
                        </div>
                    @endif

                    @lang('translate.VerifyYourEmailAddressMsg001')
                    <br>
                    @lang('translate.VerifyYourEmailAddressMsg002') <a href="{{ route('verification.resend') }}">@lang('translate.VerifyYourEmailAddressMsg003')</a>.
                </div>
            </div>
        </div>
    </div>
@endsection
