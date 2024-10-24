<h1>Welcome {{ $user->name }}</h1>
<a href="http://front.com/email-verification?token={{ $user->token }}">Lien vers la vérification</a>