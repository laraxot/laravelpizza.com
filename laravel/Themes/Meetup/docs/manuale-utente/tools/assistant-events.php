<?php

declare(strict_types=1);
use Illuminate\Contracts\Console\Kernel;
use Modules\Meetup\Actions\Event\BuildEventSummaryAction;
use Modules\Meetup\Actions\Event\SearchPublicEventsAction;
use Modules\Meetup\Models\Event;
use Modules\User\Models\User;

/*
 * Dati veri per le schermate dell'assistente (capitolo 2): eventi futuri di una città come li restituisce il tool
 * search_events, e il testo della conferma d'iscrizione, in una lingua. Nessun modello AI: le risposte della chat
 * le compone capture.cjs con questi dati.
 * Uso (da laravel/):  php Themes/Meetup/docs/manuale-utente/tools/assistant-events.php $PWD it [città] > /tmp/assistant-it.json
 */
[$root, $locale, $city] = [$argv[1], $argv[2] ?? 'it', $argv[3] ?? null];
require $root.'/vendor/autoload.php';
$app = require $root.'/bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();
app()->setLocale($locale);

$user = User::query()->where('email', 'giulia@laravelpizza.test')->firstOrFail();
$events = app(SearchPublicEventsAction::class)->execute(SearchPublicEventsAction::UPCOMING, ['city' => $city === '' ? null : $city], 4);
$summaries = $events->map(fn (Event $event): array => app(BuildEventSummaryAction::class)->execute($event, (string) $user->id, false, $locale))->values()->all();
$free = collect($summaries)->first(fn (array $e): bool => ! $e['registered'] && ! $e['is_full']);

echo json_encode([
    'events' => $summaries,
    'join' => $free === null ? null : [
        'slug' => $free['slug'],
        'title' => $free['title'],
        'approval' => __('meetup::assistant.approval.join', ['event' => $free['title']]),
    ],
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), "\n";
