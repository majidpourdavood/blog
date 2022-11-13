@component('mail::message')

@if(isset($title))
<h1 style="text-align: center; font-size: 20px; white-space: break-spaces;font-weight: bold;
    font-family: 'IRANSans','Iranian Sans',Tahoma,Arial,sans-serif!important; margin-bottom: 2rem;">{{$title}}</h1>
@endif
@if(isset($description))
<h4 style="text-align: justify;
    font-size: 17px;
    direction: rtl;
    margin: 20px 5px;
    white-space: break-spaces;
    color: #333;
        font-family: 'IRANSans','Iranian Sans',Tahoma,Arial,sans-serif!important;">{!! $description !!}</h4>
@endif

@if(isset($url))
  @component('mail::button', ['url' => $url, 'color' => $colorBtn])
{{$textBtn}}
  @endcomponent
@endif
@if(isset($body))
<p style="direction: rtl;
    text-align: justify;
    margin: 0;
    color: #333;
    font-size: 16px;
    white-space: break-spaces;
    font-weight: bold;
        font-family: 'IRANSans','Iranian Sans',Tahoma,Arial,sans-serif!important;
    line-height: 1.9em;">{{$body}}</p>
@endif
{{--{{$body}}--}}

@endcomponent
