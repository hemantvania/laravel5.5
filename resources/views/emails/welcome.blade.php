@component('mail::message')

    Welcome {{ $user->name }}

@component('mail::button', ['url' => 'http://google.com'])
Google
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
