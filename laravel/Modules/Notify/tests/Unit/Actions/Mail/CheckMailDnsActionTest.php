<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Actions\Mail;

use Modules\Notify\Actions\Mail\CheckMailDnsAction;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Risolutore finto: "TIPO nome" => valori. I valori sono esattamente cio' che un resolver restituisce,
 * quindi anche l'errore tipico (zona Hetzner che completa un nome senza punto finale).
 *
 * @param  array<string, list<string>>  $records
 */
function fakeDnsResolver(array $records): \Closure
{
    return static fn (string $name, string $type): array => $records[$type.' '.$name] ?? [];
}

const MAIL_DNS_EXPECTED_CNAMES = [
    'mt78' => 'smtp.mailtrap.live',
    'rwmt1._domainkey' => 'rwmt1.dkim.smtp.mailtrap.live',
];

it('passes when every CNAME and a DMARC record are published with the exact target', function (): void {
    $results = app(CheckMailDnsAction::class)->execute('fixcity.eu', MAIL_DNS_EXPECTED_CNAMES, fakeDnsResolver([
        'CNAME mt78.fixcity.eu' => ['smtp.mailtrap.live.'],
        'CNAME rwmt1._domainkey.fixcity.eu' => ['RWMT1.dkim.smtp.mailtrap.live'],
        'TXT _dmarc.fixcity.eu' => ['v=DMARC1; p=none; rua=mailto:dmarc@reports.mailtrap.io'],
    ]));

    Assert::assertCount(3, $results);
    foreach ($results as $result) {
        Assert::assertTrue($result['ok'], $result['record'].' deve passare');
        Assert::assertNull($result['hint']);
    }
});

it('flags a CNAME target completed with the zone origin as a missing trailing dot', function (): void {
    $results = app(CheckMailDnsAction::class)->execute('fixcity.eu', MAIL_DNS_EXPECTED_CNAMES, fakeDnsResolver([
        'CNAME mt78.fixcity.eu' => ['smtp.mailtrap.live.fixCity.eu.'],
        'CNAME rwmt1._domainkey.fixcity.eu' => ['rwmt1.dkim.smtp.mailtrap.live.fixcity.eu'],
        'TXT _dmarc.fixcity.eu' => ['v=DMARC1; p=none'],
    ]));

    Assert::assertFalse($results[0]['ok']);
    Assert::assertSame('missing-trailing-dot', $results[0]['hint']);
    Assert::assertFalse($results[1]['ok']);
    Assert::assertSame('missing-trailing-dot', $results[1]['hint']);
});

it('reports a record that does not exist and a wrong target distinctly', function (): void {
    $results = app(CheckMailDnsAction::class)->execute('fixcity.eu', MAIL_DNS_EXPECTED_CNAMES, fakeDnsResolver([
        'CNAME rwmt1._domainkey.fixcity.eu' => ['something.else.example.'],
    ]));

    Assert::assertSame('missing', $results[0]['hint']);
    Assert::assertSame('wrong-target', $results[1]['hint']);
    Assert::assertSame('missing', $results[2]['hint']);
    Assert::assertSame('_dmarc.fixcity.eu', $results[2]['record']);
});
