<?php

declare(strict_types=1);

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Log;
use Modules\Notify\Actions\RenderNotificationTemplateStringAction;
use Modules\Notify\Models\NotificationTemplate;
use Modules\Notify\Tests\Fixtures\NotifyNotificationTemplateProxy;
use Monolog\Handler\TestHandler;
use Monolog\Level;
use Monolog\Logger as Monolog;
use PHPUnit\Framework\Assert;

uses(\Modules\Notify\Tests\TestCase::class);
/*
 * DCP-283 (C-08): i template di notifica sono letti dal database. Blade::render eseguiva PHP (`{{ system('id') }}`,
 * `@php`). Il sostituto accetta solo i segnaposto: nome o percorso con punti, con o senza `$`, sempre escapati.
 */

/**
 * Contesti dei record `warning` emessi durante `$run`, raccolti da un logger di prova (indipendente dalla configurazione).
 *
 * @param  Closure(): mixed  $run
 * @return list<array<mixed>>
 */
function dcp283NotifyWarnings(Closure $run): array
{
    $handler = new TestHandler;
    Log::swap(new Logger(new Monolog('dcp283', [$handler])));
    $run();

    $contexts = [];
    foreach ($handler->getRecords() as $record) {
        if ($record->level === Level::Warning) {
            $contexts[] = $record->context;
        }
    }

    return $contexts;
}

/** Effetto osservabile: se il template viene eseguito, la funzione gira. */
function dcp283NotifyMarker(): string
{
    $GLOBALS['dcp283_notify_marker'] = true;

    return 'EXECUTED';
}

beforeEach(function (): void {
    $GLOBALS['dcp283_notify_marker'] = false;
});

/**
 * @param  array<string, mixed>  $data
 */
function dcp283Render(string $template, array $data = []): string
{
    return app(RenderNotificationTemplateStringAction::class)->execute($template, $data);
}

/** @return array<string, array{string, array<string, mixed>}> template e dati per etichetta */
function dcp283ParityCases(): array
{
    return [
        'variabile' => ['Benvenuto {{ $name }}!', ['name' => 'Mario Rossi']],
        'senza spazi' => ['Ciao {{$name}}', ['name' => 'Luigi']],
        'html nel testo' => ['<h1>Benvenuto {{ $name }}!</h1><p>{{ $email }}</p>', ['name' => 'Mario', 'email' => 'mario@example.com']],
        'html nei dati e escapato' => ['<p>{{ $name }}</p>', ['name' => '<script>alert(1)</script> & "x"']],
        'virgolette nei dati' => ['{{ $name }}', ['name' => "O'Brien \"Q\""]],
        'numero' => ['Ticket {{ $id }}', ['id' => 42]],
        'float' => ['{{ $score }}', ['score' => 1.5]],
        'variabile ripetuta' => ['{{ $a }} e {{ $a }}', ['a' => 'x']],
        'valore nullo' => ['[{{ $a }}]', ['a' => null]],
        'bool vero' => ['{{ $a }}', ['a' => true]],
        'bool falso' => ['[{{ $a }}]', ['a' => false]],
        'multilinea' => ["Riga 1\n{{ \$name }}\nRiga 3", ['name' => 'Anna']],
        'nessun segnaposto' => ['Testo semplice, senza variabili.', []],
    ];
}

test('rende gli stessi segnaposto di Blade, con la stessa escapatura', function (): void {
    foreach (dcp283ParityCases() as $label => [$template, $data]) {
        Assert::assertSame(Blade::render($template, $data), dcp283Render($template, $data), $label);
    }
});

test('accetta anche la forma senza dollaro usata dai fixture di Notify', function (): void {
    Assert::assertSame('Benvenuto Mario Rossi!', dcp283Render('Benvenuto {{name}}!', ['name' => 'Mario Rossi']));
    Assert::assertSame('Benvenuto Mario Rossi!', dcp283Render('Benvenuto {{ name }}!', ['name' => 'Mario Rossi']));
});

test('segue i percorsi con punti su array e oggetti', function (): void {
    $data = ['user' => ['name' => 'Anna', 'address' => ['city' => 'Roma']], 'obj' => (object) ['title' => 'Buca']];

    Assert::assertSame('Anna di Roma', dcp283Render('{{ $user.name }} di {{ user.address.city }}', $data));
    Assert::assertSame('Buca', dcp283Render('{{ $obj.title }}', $data));
});

test('un valore Stringable viene reso come stringa', function (): void {
    $data = ['code' => new class implements Stringable
    {
        public function __toString(): string
        {
            return 'AB-12';
        }
    }];

    Assert::assertSame('AB-12', dcp283Render('{{ $code }}', $data));
});

test('una variabile mancante o non stampabile diventa vuota e viene segnalata senza i dati', function (): void {
    $contexts = dcp283NotifyWarnings(function (): void {
        Assert::assertSame('[]', dcp283Render('[{{ $manca }}]', []));
        Assert::assertSame('[]', dcp283Render('[{{ $lista }}]', ['lista' => ['SECRETVALUE']]));
    });

    Assert::assertGreaterThanOrEqual(2, count($contexts));
    Assert::assertStringNotContainsString('SECRETVALUE', json_encode($contexts, JSON_THROW_ON_ERROR));
});

test('i valori dei dati non vengono rivalutati', function (): void {
    $out = dcp283Render('{{ $a }} {{ $b }}', ['a' => '{{ $b }}', 'b' => '{{ dcp283NotifyMarker() }}']);

    Assert::assertSame('{{ $b }} {{ dcp283NotifyMarker() }}', html_entity_decode($out, ENT_QUOTES));
    Assert::assertFalse($GLOBALS['dcp283_notify_marker']);
});

test('non esegue PHP: espressioni, direttive e uscita non escapata restano testo', function (string $template): void {
    Log::spy();

    $out = dcp283Render($template, ['name' => 'Mario', 'x' => 'X']);

    Assert::assertFalse($GLOBALS['dcp283_notify_marker'], 'il template non deve eseguire codice');
    Assert::assertStringNotContainsString('EXECUTED', $out);
    Assert::assertStringNotContainsString('uid=', $out);
})->with([
    'chiamata di funzione' => ['{{ dcp283NotifyMarker() }}'],
    'funzione di sistema' => ["{{ system('id') }}"],
    'concatenazione dopo una variabile' => ['{{ $name . dcp283NotifyMarker() }}'],
    'metodo su un oggetto' => ['{{ $name->dcp283NotifyMarker() }}'],
    'aritmetica' => ['{{ 1 + 1 }}'],
    'assegnazione' => ['{{ $x = dcp283NotifyMarker() }}'],
    'direttiva php' => ['@php dcp283NotifyMarker(); @endphp {{ $name }}'],
    'direttiva php inline' => ['@php(dcp283NotifyMarker())'],
    'uscita non escapata' => ['{!! dcp283NotifyMarker() !!}'],
    'tre graffe' => ['{{{ dcp283NotifyMarker() }}}'],
    'commento blade con codice' => ['{{-- x --}}{{ dcp283NotifyMarker() }}'],
    'verbatim' => ['@verbatim {{ dcp283NotifyMarker() }} @endverbatim'],
    'a capo prima del codice' => ["{{ \$name\n . dcp283NotifyMarker() }}"],
    'ternario' => ['{{ $name ? dcp283NotifyMarker() : 0 }}'],
    'null coalescing con chiamata' => ['{{ $nope ?? dcp283NotifyMarker() }}'],
    'facade' => ['{{ \\Illuminate\\Support\\Facades\\Auth::user() }}'],
    'if blade' => ['@if(true) {{ dcp283NotifyMarker() }} @endif'],
    'foreach blade' => ['@foreach([1] as $i) {{ dcp283NotifyMarker() }} @endforeach'],
    'include' => ["@include('notify::email')"],
    'inject' => ["@inject('m', 'Illuminate\\\\Support\\\\Facades\\\\DB')"],
]);

test('la direttiva php fuori dalle graffe non viene interpretata', function (): void {
    $out = dcp283Render('@php dcp283NotifyMarker(); @endphp {{ $name }}', ['name' => 'Mario']);

    Assert::assertSame('@php dcp283NotifyMarker(); @endphp Mario', $out);
});

test('compileString del modello non esegue piu il template del database', function (): void {
    $proxy = new NotifyNotificationTemplateProxy;

    Assert::assertSame('Ciao Mario', $proxy->exposedCompileString('Ciao {{ $name }}', ['name' => 'Mario']));
    $proxy->exposedCompileString('{{ dcp283NotifyMarker() }}', []);

    Assert::assertFalse($GLOBALS['dcp283_notify_marker']);
    Assert::assertNull($proxy->exposedCompileString(null, []));
    Assert::assertNull($proxy->exposedCompileString('', []));
});

test('compile e preview del modello rendono soggetto e corpi con i dati', function (): void {
    $template = new NotificationTemplate;
    $template->subject = 'Benvenuto {{ $name }}!';
    $template->body_html = '<h1>Benvenuto {{ $name }}!</h1><p>{{ $email }}</p>';
    $template->body_text = 'Benvenuto {{name}}! {{ $email }}';
    $template->preview_data = ['name' => 'Anteprima', 'email' => 'a@example.test'];

    $compiled = $template->compile(['name' => 'Mario', 'email' => 'mario@example.test']);
    $preview = $template->preview();

    Assert::assertSame('Benvenuto Mario!', $compiled['subject']);
    Assert::assertSame('<h1>Benvenuto Mario!</h1><p>mario@example.test</p>', $compiled['body_html']);
    Assert::assertSame('Benvenuto Mario! mario@example.test', $compiled['body_text']);
    Assert::assertSame('Benvenuto Anteprima!', $preview['subject']);
});