@component('mail::message')
{{-- Greeting --}}
@if (! empty($details['greeting']))
{{ $details['greeting'] }}, ** {{ $user->name }} ** !
@else
@if ($details['level'] == 'error')
# Whoops!
@else
# Olá, {{ $user->name }} !
@endif
@endif

{{-- Initial Lines --}}
@foreach ($details['initial_lines'] as $line)
{!! nl2br($line) !!}
@endforeach

{{-- Middle Lines --}}
@foreach ($details['middle_lines'] as $line)
{!! nl2br($line) !!}
@endforeach

{{-- Action Button --}}
@isset($details['button_text'])
@component('mail::button', ['url' => $details['button_url'], $details['expires_at'], 'color' => $details['button_color']])
{{ $details['button_text'] }}
@endcomponent
@endisset

{{-- End Lines --}}
@foreach ($details['end_lines'] as $line)
{!! nl2br($line) !!}
@endforeach

{{-- Salutation --}}
@if (! empty($details['salutation']))
{!! nl2br($details['salutation']) !!}
@else
Atenciosamente, <br/> 
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($details['button_text'])
@component('mail::subcopy')
Se você estiver tendo problemas clicando no botão "{{ $details['button_text'] }}", copie e cole o link abaixo no seu navegador: : [{{ $details['button_url'] }}]({{ $details['button_url'] }})
@endcomponent
@endisset
@endcomponent