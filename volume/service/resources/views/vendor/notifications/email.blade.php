@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ __('mail.'.$greeting) }}
@else
@if ($level === 'error')
# @lang('mail.error')
@else
# @lang('mail.hello')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ __('mail.'.$line) }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ __('mail.'.$actionText) }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ __('mail.'.$line) }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ __('mail.'.$salutation) }}
@else
<br>
<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "mail.If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below into your web browser:",
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset
@endcomponent
