@component('mail::message')
# Dear Customer,

This is <b>Budget</b> Message Reset Password.

@component('mail::button', ['url' => url('/newPassword')])
Click Here
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
