@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# Whoops!
@else
# Hello!
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
<tr>
    <td valign="top" align="left" bgcolor="#ffffff"><table width="600" class="full-width" cellpadding="0" cellspacing="0" border="0" >
            <tr>
                <td valign="top" align="left" bgcolor="#ffffff"><table width="600" class="full-width" cellpadding="0" cellspacing="0" border="0" >
                        <tr>
                            <td valign="top" align="left" width="30" class="webOnly"></td>
                            <td valign="top" align="left" width="540" class="full-width"><table width="540" class="inner" align="center" cellpadding="0" cellspacing="0" border="0" style="font-family: arial,verdana,sans-serif; font-size: 15px;">
                                    <tr>
                                        <td valign="top" height="15" align="left" style="font-size: 1px; line-height: 1px;"><img width="1" height="1" border="0" style="display: block;" alt="" src="{{config('app.url')}}/assests/images/spacer.gif" /></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" align="left" style="color:#1c60a3; line-height: 22px;">Thanks</td>
                                    </tr>
                                    <tr>
                                        <td valign="top" align="left" style="color:#1c60a3; line-height: 22px; font-size:16px;"><a href="{{ config('app.url') }}" title="Title 2" target="_blank" style="font-family:arial,verdana,sans-serif; color:#1c60a3; outline:0; text-decoration:none;"><strong>{{ config('app.name') }}</strong></a></td>
                                    </tr>
                                    <tr>
                                        <td valign="top" height="20" align="left" style="font-size: 1px; line-height: 1px;"><img width="1" height="1" border="0" style="display: block;" alt="" src="{{config('app.url')}}/assests/images/spacer.gif" /></td>
                                    </tr>
                                </table></td>
                            <td valign="top" align="left" width="30" class="webOnly"></td>
                        </tr>
                    </table></td>
            </tr>
        </table></td>
</tr>
<!-- footer end here -->
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below
into your web browser: [{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endisset
@endcomponent
