@component('mail::message')
    
Salut <b>{{ $user->name }}</b>

<p>Vous êtes presque prêt de profiter des avantages de Molla.com .</p>

<p>Cliquez simplement sur le bouton pour vérifier votre adresse mail</p>

<p>
    @component('mail::button', ['url' => url('activate/'.base64_encode($user->id))])
        Vérification
    @endcomponent
</p>

<p>Cela vérifiera votre adresse mail, et vous ferez alors officiellement partie de Molla.com </p>

@endcomponent