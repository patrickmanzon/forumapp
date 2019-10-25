@component('mail::message')

Hi {{ $user->name }}, we need to confirm your account to fully use our app. Just click the link bellow.

@component('mail::button', ['url' => url('confirmation?token='.$user->confirmation_token)])
Connfirm your account here!
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
