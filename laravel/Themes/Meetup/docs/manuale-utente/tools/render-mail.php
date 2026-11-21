<?php

declare(strict_types=1);
use Illuminate\Contracts\Console\Kernel;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Notifications\EventRegistrationConfirmedNotification;
use Modules\User\Models\User;

/*
 * HTML dell'email di conferma iscrizione, generato dalla notifica vera, per lo screenshot p08.
 * Uso (da laravel/):  php Themes/Meetup/docs/manuale-utente/tools/render-mail.php $PWD /tmp/mail.html [it|en]
 */
$root = $argv[1];
require $root.'/vendor/autoload.php';
$app = require $root.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
$locale = $argv[3] ?? 'it';
app()->setLocale($locale);
$event = Event::query()->where('slug', 'laravel-13-e-filament-5-cosa-cambia-davvero')->firstOrFail();
$user = User::query()->where('email', 'giulia@laravelpizza.test')->firstOrFail();
$n = new EventRegistrationConfirmedNotification($event, $locale);
$html = (string) $n->toMail($user)->render();
file_put_contents($argv[2], $html);
echo strlen($html), "\n";
