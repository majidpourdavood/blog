@component('mail::message')
{{-- Greeting --}}
<div style="color:#333; font-weight: bold; margin-bottom: 1rem; font-size:19px; font-family: 'IRANSans','Iranian Sans',Tahoma,Arial,sans-serif!important; text-align: center;">
@if (! empty($greeting))
{{ $greeting }}
@else
@if ($level === 'error')
@lang('خطا!')
@else
@lang('سلام!')
@endif
@endif
</div>
{{-- Intro Lines --}}
@foreach ($introLines as $line)
<p style="color:#333; font-size:17px; font-family: 'IRANSans','Iranian Sans',Tahoma,Arial,sans-serif!important; text-align: center;">
        {{ $line }}
</p>


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
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
<p style="color:#333; font-size:17px; font-family: 'IRANSans','Iranian Sans',Tahoma,Arial,sans-serif!important; text-align: center;">
        {{ $line }}
</p>

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{--@lang('Regards'),<br>--}}
{{--{{ config('app.name') }}--}}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "اگر در کلیک کردن مشکل دارید آدرس زیر را در مرورگر کپی کنید . <br> ".
    '[:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endslot
@endisset
@endcomponent
