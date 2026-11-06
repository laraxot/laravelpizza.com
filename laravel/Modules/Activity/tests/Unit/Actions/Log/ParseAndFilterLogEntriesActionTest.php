<?php

declare(strict_types=1);
use Modules\Activity\Actions\Log\FilterLogEntriesAction;
use Modules\Activity\Actions\Log\ParseLogEntriesAction;
use Tests\TestCase;

uses(TestCase::class);

const SAMPLE_LOG = <<<'LOG'
[2026-09-20 10:00:00] production.INFO: contacts.received
{"index":0,"contact":{"email":"a@example.test"}}
{"index":1,"contact":{"email":"b@example.test"}}
[2026-09-20 10:05:00] production.ERROR: Connection could not be established with host "outbound.example.test"
#0 /var/www/vendor/symfony/mailer/Transport.php(12): connect()
#1 {main}
[2026-09-20 10:06:00] production.warning: Slow query
LOG;

it('splits a Monolog file into entries and keeps stack traces attached to their entry', function (): void {
    $entries = (new ParseLogEntriesAction)->execute(SAMPLE_LOG."\n");

    expect($entries)->toHaveCount(3);

    expect($entries[0]->timestamp)->toBe('2026-09-20 10:00:00');
    expect($entries[0]->environment)->toBe('production');
    expect($entries[0]->level)->toBe('INFO');
    expect($entries[0]->message)->toBe('contacts.received');
    expect($entries[0]->body)->toContain('a@example.test')->toContain('b@example.test');

    expect($entries[1]->level)->toBe('ERROR');
    expect($entries[1]->body)->toContain('#0 /var/www/vendor/symfony/mailer/Transport.php')->toContain('#1 {main}');
    // Lo stack trace NON e' finito nella voce successiva.
    expect($entries[2]->body)->not->toContain('#0 /var/www');
});

it('normalizes the level to uppercase', function (): void {
    $entries = (new ParseLogEntriesAction)->execute(SAMPLE_LOG);

    expect($entries[2]->level)->toBe('WARNING');
});

it('keeps unrecognized leading lines as a raw entry without date or level', function (): void {
    $text = "parte finale di una voce tagliata\n[2026-09-20 10:00:00] local.INFO: ok\n";

    $entries = (new ParseLogEntriesAction)->execute($text);

    expect($entries)->toHaveCount(2);
    expect($entries[0]->level)->toBeNull();
    expect($entries[0]->timestamp)->toBeNull();
    expect($entries[0]->message)->toBe('parte finale di una voce tagliata');
    expect($entries[1]->level)->toBe('INFO');
});

it('returns no entries for empty or blank text and trims trailing blank lines', function (): void {
    expect((new ParseLogEntriesAction)->execute(''))->toBe([]);
    expect((new ParseLogEntriesAction)->execute("\n\n"))->toBe([]);

    $entries = (new ParseLogEntriesAction)->execute("[2026-09-20 10:00:00] local.INFO: ok\n\n\n");
    expect($entries[0]->body)->toBe('[2026-09-20 10:00:00] local.INFO: ok');
});

it('understands Windows and old Mac line endings', function (): void {
    $entries = (new ParseLogEntriesAction)->execute("[2026-09-20 10:00:00] local.INFO: uno\r\nriga di contesto\r[2026-09-20 10:01:00] local.ERROR: due\r\n");

    expect($entries)->toHaveCount(2);
    expect($entries[0]->body)->toContain('riga di contesto');
    expect($entries[1]->level)->toBe('ERROR');
});

it('filters by level', function (): void {
    $entries = (new ParseLogEntriesAction)->execute(SAMPLE_LOG);

    $result = (new FilterLogEntriesAction)->execute($entries, 'error');

    expect($result->total)->toBe(1);
    expect($result->entries[0]->level)->toBe('ERROR');
});

it('searches the whole entry body case-insensitively, including the stack trace', function (): void {
    $entries = (new ParseLogEntriesAction)->execute(SAMPLE_LOG);

    expect((new FilterLogEntriesAction)->execute($entries, '', 'B@EXAMPLE')->total)->toBe(1);
    expect((new FilterLogEntriesAction)->execute($entries, '', 'transport.php')->total)->toBe(1);
    expect((new FilterLogEntriesAction)->execute($entries, '', 'inesistente')->total)->toBe(0);
});

it('combines level and search filters', function (): void {
    $entries = (new ParseLogEntriesAction)->execute(SAMPLE_LOG);

    expect((new FilterLogEntriesAction)->execute($entries, 'INFO', 'a@example')->total)->toBe(1);
    expect((new FilterLogEntriesAction)->execute($entries, 'ERROR', 'a@example')->total)->toBe(0);
});

it('returns the newest entries first and applies the limit while reporting the total', function (): void {
    $entries = (new ParseLogEntriesAction)->execute(SAMPLE_LOG);

    $result = (new FilterLogEntriesAction)->execute($entries, '', '', 2);

    expect($result->total)->toBe(3);
    expect($result->entries)->toHaveCount(2);
    expect($result->entries[0]->timestamp)->toBe('2026-09-20 10:06:00');
    expect($result->entries[1]->timestamp)->toBe('2026-09-20 10:05:00');
});
