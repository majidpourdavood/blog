@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => url('/')])
            <img src="{{asset('images/yaremohajer.png')}}"
                 style="width: 10rem;" alt="">
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')

            <p style="    font-family: 'IRANSans','Iranian Sans',Tahoma,Arial,sans-serif!important;
            font-size: 1.2rem;color: #000; padding: 0;">
                &copy; {{ convert(jdate(Carbon\Carbon::now())->format('Y'))}}  {{translate('All rights belong to the blog.')}}</p>

        @endcomponent
    @endslot
@endcomponent
