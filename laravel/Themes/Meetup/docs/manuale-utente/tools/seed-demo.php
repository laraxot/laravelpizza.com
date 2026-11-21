<?php

declare(strict_types=1);

/*
 * Dati dimostrativi per gli screenshot del manuale: persone ed eventi inventati.
 * Uso (da laravel/):  php Themes/Meetup/docs/manuale-utente/tools/seed-demo.php $PWD
 * Si rifiuta di girare se il database non ha "demo" nel nome: non va MAI usato su dati veri.
 * Password di tutti gli account: Password!2026
 */

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Hash;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Meetup\Models\Performer;
use Modules\Meetup\Models\Sponsor;
use Modules\Meetup\Models\Venue;
use Modules\User\Models\Role;
use Modules\User\Models\User;

$root = $argv[1];
require $root.'/vendor/autoload.php';
$app = require $root.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$database = (string) config('database.connections.'.config('database.default').'.database');
if (! str_contains($database, 'demo')) {
    fwrite(STDERR, "Database \"{$database}\": il seed demo gira solo su un database con \"demo\" nel nome.\n");
    exit(1);
}

$venues = [
    'milano' => Venue::query()->create(['name' => 'Talent Garden Calabiana', 'address' => 'Via Arcivescovo Calabiana 6', 'city' => 'Milano']),
    'roma' => Venue::query()->create(['name' => 'Binario F', 'address' => 'Via Marsala 29H', 'city' => 'Roma']),
    'torino' => Venue::query()->create(['name' => 'OGR Tech', 'address' => 'Corso Castelfidardo 22', 'city' => 'Torino']),
];

$admin = User::query()->create([
    'name' => 'Marta Organizzatrice', 'first_name' => 'Marta', 'last_name' => 'Organizzatrice',
    'email' => 'organizzatrice@laravelpizza.test', 'password' => Hash::make('Password!2026'),
    'email_verified_at' => now(), 'is_active' => true,
]);
$admin->assignModule('meetup');

// Amministratore del sito: gestisce utenti e ruoli (capitolo 4 del manuale).
$superadmin = User::query()->create([
    'name' => 'Super Admin', 'first_name' => 'Super', 'last_name' => 'Admin',
    'email' => 'superadmin@laravelpizza.test', 'password' => Hash::make('Password!2026'),
    'email_verified_at' => now(), 'is_active' => true,
]);
$superadmin->assignRole(Role::query()->firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']));

$giulia = User::query()->create([
    'name' => 'Giulia Partecipante', 'first_name' => 'Giulia', 'last_name' => 'Partecipante',
    'email' => 'giulia@laravelpizza.test', 'password' => Hash::make('Password!2026'),
    'email_verified_at' => now(), 'is_active' => true,
]);

$make = function (array $data) use ($admin): Event {
    return Event::query()->create(array_merge([
        'status' => 'published',
        'event_status' => 'EventScheduled',
        'event_attendance_mode' => 'OfflineEventAttendanceMode',
        'in_language' => 'it',
        'attendees_count' => 0,
        'user_id' => (string) $admin->getKey(),
        'organizer_id' => (string) $admin->getKey(),
    ], $data));
};

$d = now()->startOfDay();
$events = [
    $make(['title' => 'Laravel 13 e Filament 5: cosa cambia davvero', 'description' => "Una serata pratica sulle novità di Laravel 13 e Filament 5, con demo dal vivo e tanta pizza.\n\nPorta il portatile: faremo insieme l'upgrade di un progetto reale.", 'start_date' => $d->copy()->addDays(12)->setTime(19, 0), 'end_date' => $d->copy()->addDays(12)->setTime(22, 0), 'location' => 'Milano', 'location_id' => $venues['milano']->id, 'max_attendees' => 60]),
    $make(['title' => 'Livewire 4 in produzione: lezioni imparate', 'description' => 'Tre talk brevi su performance, test e accessibilità con Livewire 4.', 'start_date' => $d->copy()->addDays(26)->setTime(18, 30), 'end_date' => $d->copy()->addDays(26)->setTime(21, 30), 'location' => 'Roma', 'location_id' => $venues['roma']->id, 'max_attendees' => 40]),
    $make(['title' => 'Pizza & Pest: testare senza paura', 'description' => 'Workshop per chi non ha mai scritto un test: Pest dalle basi ai test di feature.', 'start_date' => $d->copy()->addDays(40)->setTime(19, 0), 'end_date' => $d->copy()->addDays(40)->setTime(22, 0), 'location' => 'Torino', 'location_id' => $venues['torino']->id, 'max_attendees' => 3]),
    $make(['title' => 'Meetup di settembre: architettura modulare', 'description' => 'Moduli, confini e convenzioni in un monolite Laravel.', 'start_date' => $d->copy()->subDays(50)->setTime(19, 0), 'end_date' => $d->copy()->subDays(50)->setTime(22, 0), 'location' => 'Milano', 'location_id' => $venues['milano']->id, 'max_attendees' => 50, 'attendees_count' => 47]),
    $make(['title' => 'Bozza: hackathon di primavera', 'description' => 'Evento in preparazione, non ancora pubblicato.', 'status' => 'draft', 'start_date' => $d->copy()->addDays(90)->setTime(10, 0), 'end_date' => $d->copy()->addDays(90)->setTime(18, 0), 'location' => 'Roma', 'location_id' => $venues['roma']->id, 'max_attendees' => 80]),
];

$people = [];
foreach ([['Paolo', 'Ferri'], ['Sara', 'Conti'], ['Andrea', 'Galli'], ['Elena', 'Riva'], ['Marco', 'Testa']] as [$first, $last]) {
    $people[] = User::query()->create([
        'name' => "$first $last", 'first_name' => $first, 'last_name' => $last,
        'email' => strtolower("$first.$last").'@laravelpizza.test', 'password' => Hash::make('Password!2026'),
        'email_verified_at' => now(), 'is_active' => true,
    ]);
}
$register = static function (Event $event, array $users): void {
    foreach ($users as $user) {
        EventUser::query()->create(['event_id' => $event->id, 'user_id' => (string) $user->getKey(), 'status' => 'attending', 'registered_at' => now()]);
    }
    $event->forceFill(['attendees_count' => count($users)])->save();
};
// Il workshop di Torino è quasi pieno: 2 iscritti su 3 posti.
$register($events[2], [$people[3], $people[4]]);
// Qualche iscrizione per la lista iscritti e la bacheca.
$register($events[0], [$people[0], $people[1], $people[2]]);

// Relatori e sponsor del primo evento.
$speaker = Performer::query()->create(['name' => 'Chiara Moretti', 'type' => 'speaker', 'company' => 'Studio Moretti', 'bio' => 'Sviluppatrice Laravel dal 2015, parla di upgrade e testing.']);
$host = Performer::query()->create(['name' => 'Luca Neri', 'type' => 'host', 'company' => 'Laravel Pizza Milano']);
$sponsor = Sponsor::query()->create(['name' => 'Forno Digitale', 'level' => 'gold', 'website' => 'https://example.com']);
$events[0]->performers()->attach([$speaker->id, $host->id]);
$events[0]->sponsors()->attach([$sponsor->id]);

foreach ($events as $e) {
    echo $e->status.' '.$e->slug."\n";
}
