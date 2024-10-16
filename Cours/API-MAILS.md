![image](imgs/api-base-cover.png)
## Mise en place d'une pipeline mail de test
1. Créer un compte `mailtrap`.
2. Copier la config dans notre fichier d'environnement.

## Créer un email
```
# php artisan make:mail SampleEmail
```

## Définition de l'email
```php
use Illuminate\Mail\Mailable;

class SampleEmail extends Mailable
{
    public function build()
    {
        return $this->subject('Sample Email')->view('emails.sample');
    }
}
```

## Envois de l'email
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SampleEmail;

class MailTesterController extends Controller
{
    public function sendMail(Request $request)
    {
        Mail::to('recipient@example.com')->send(new SampleEmail());
    }
}
```