@component('mail::message')
<?php
$title = isset($details['title']) && $details['title'] != "" ? $details['title'] : "";
$description = isset($details['description']) && $details['description'] != "" ? $details['description'] : "";
$body = isset($details['body']) && $details['body'] != "" ? $details['body'] : "";
$colorBtn = isset($details['colorBtn']) && $details['colorBtn'] != "" ? $details['colorBtn'] : "green";
$textBtn = isset($details['textBtn']) && $details['textBtn'] != "" ? $details['textBtn'] : translate('show');
$url = isset($details['url']) && $details['url'] != "" ? $details['url'] : url('/');


?>

@if(isset($title))
<h1 style="text-align: center; font-size: 20px; white-space: break-spaces;font-weight: bold;
    font-family: IRANSans,'IRAN Sans',Iransans,IranSansWeb,calibri,Segoe UI,tahoma,arial,sans-serif; margin-bottom: 2rem;">{{$title}}</h1>
@endif
@if(isset($description))
<h4 style="text-align: justify;
    font-size: 17px;
    direction: rtl;
    margin: 20px 5px;
    white-space: break-spaces;
    color: #333;
        font-family: IRANSans,'IRAN Sans',Iransans,IranSansWeb,calibri,Segoe UI,tahoma,arial,sans-serif;">{!! $description !!}</h4>
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
        font-family: IRANSans,'IRAN Sans',Iransans,IranSansWeb,calibri,Segoe UI,tahoma,arial,sans-serif;
    line-height: 1.9em;">{{$body}}</p>
@endif
{{--{{$body}}--}}

@endcomponent
