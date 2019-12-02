@component('mail::message')
# Your details

<strong>Name: </strong>{{$user->name}}<br />
<strong>Email: </strong>{{$user->email}}<br />
<strong>Password: </strong>{{$user->password}}<br />
<strong>Type: </strong>{{$user->type}}<br />

<p class="text-center text-success">
  Click to button below to go to the the site.
</p>

@component('mail::button', ['url' => 'http://127.0.0.1:8000/login'])
click me
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
