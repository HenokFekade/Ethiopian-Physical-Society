@component('mail::message')
# Account Deactivated!

Dear {{ucwords($user->name)}}, your account is deactivated.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
