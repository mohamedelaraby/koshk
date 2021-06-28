@component('mail::message')
#REset Account
Welcome {{ $data['data']->name }}

The body of your message.

@component('mail::button', ['url' => admin_url('reset/password/'.$data['token'])]);
Click Here To Reset Password.
@endcomponent

Or <br>
copy this link:
<a href="{{  admin_url('reset/password/'.$data['token']) }}"> {{  admin_url('reset/password/'.$data['token']) }}</a>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
