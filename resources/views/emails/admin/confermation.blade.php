@component('mail::message')
# Introduction

The body of your message.
<strong>Name: </strong> {{auth()->user()->name}}<br>
<strong>Email: </strong>{{auth()->user()->email}}<br>
<strong>Password: </strong>{{auth()->user()->password}}

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
