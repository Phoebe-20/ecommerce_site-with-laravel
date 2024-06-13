@component('mail::message')
Salut {{ $user->name }},

<p>Nous comprenons que cela s'est produit. </p>

@component('mail::button', ['url' => url('reset/'.$user->remember_token)])
     Réinitialisez votre mot de passe
@endcomponent

<p>Si vous rencontrez des problèmes pour récupérer votre mot de passe, veuillez nous contacter. </p>

Merci,<br>
{{ config('app.name') }}
@endcomponent