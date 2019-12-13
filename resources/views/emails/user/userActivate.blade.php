@component('mail::message')
# Introduction

Dear {{ucwords($user->name)}}, your account is activated.


Thanks,<br>
{{ config('app.name') }}
@endcomponent
