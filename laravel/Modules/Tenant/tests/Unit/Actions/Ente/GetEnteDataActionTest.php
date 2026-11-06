<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Ente;

use Modules\Tenant\Actions\Ente\GetEnteDataAction;
use Modules\Tenant\Datas\EnteData;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class);

/*
 * DCP-289: i dati dell'ente (nome, regione, recapiti, DPO, social, orari) hanno UNA sorgente, `config('ente')` del tenant, e UNA Action che li
 * restituisce gia' normalizzati. Un valore non valido vale "manca": non si mostra e non si linka mai. I valori di prova sono sintetici
 * (domini `.test`, numeri `000`): nessun dato di un ente vero.
 */
function enteAction(?string $locale = null): EnteData
{
    return app(GetEnteDataAction::class)->execute($locale);
}

it('returns an all-empty EnteData when the tenant has no ente config', function (): void {
    config()->set('ente', null);

    $ente = enteAction('it');

    expect($ente->name)->toBe('')
        ->and($ente->region_name)->toBe('')
        ->and($ente->toll_free)->toBe('')
        ->and($ente->social)->toBe([])
        ->and($ente->hasContacts())->toBeFalse()
        ->and($ente->rightsContact())->toBeNull()
        ->and($ente->link('toll_free'))->toBeNull();
});

it('treats blank strings, wrong types and unknown keys as missing', function (): void {
    config()->set('ente', ['name' => '   ', 'region_name' => 12, 'phone' => ['x'], 'toll_free' => null, 'sconosciuta' => 'x']);

    $ente = enteAction('it');

    expect($ente->name)->toBe('')
        ->and($ente->region_name)->toBe('')
        ->and($ente->phone)->toBe('')
        ->and($ente->toll_free)->toBe('')
        ->and($ente->hasContacts())->toBeFalse();
});

it('returns trimmed values and builds valid tel and mailto hrefs', function (): void {
    config()->set('ente', [
        'name' => '  Ente di prova  ',
        'region_name' => 'Regione di prova',
        'region_url' => 'https://regione.example.test/portale',
        'phone' => '000 111222',
        'toll_free' => '800.000.000',
        'pec' => 'ente@pec.example.test',
        'email' => 'info@example.test',
        'dpo_email' => 'dpo@example.test',
        'dpo_name' => 'Responsabile di prova',
        'address' => "Via di prova 1\n00000 Citta",
        'hours' => 'Lun-Ven 9-13',
        'tax_code' => '00000000000',
        'vat' => '00000000000',
    ]);

    $ente = enteAction('it');

    expect($ente->name)->toBe('Ente di prova')
        ->and($ente->region_url)->toBe('https://regione.example.test/portale')
        ->and($ente->address)->toBe("Via di prova 1\n00000 Citta")
        ->and($ente->hasContacts())->toBeTrue()
        ->and($ente->link('toll_free'))->toBe(['label' => '800.000.000', 'href' => 'tel:800000000'])
        ->and($ente->link('phone'))->toBe(['label' => '000 111222', 'href' => 'tel:000111222'])
        ->and($ente->link('pec'))->toBe(['label' => 'ente@pec.example.test', 'href' => 'mailto:ente@pec.example.test'])
        ->and($ente->link('name'))->toBeNull();
});

it('accepts a leading plus in phone numbers', function (): void {
    config()->set('ente', ['phone' => '+39 000 1112223']);

    expect(enteAction('it')->link('phone'))->toBe(['label' => '+39 000 1112223', 'href' => 'tel:+390001112223']);
});

it('drops phone numbers that are not numeric so a tel link is never malformed', function (string $bad): void {
    config()->set('ente', ['phone' => $bad, 'toll_free' => $bad]);

    $ente = enteAction('it');

    expect($ente->phone)->toBe('')
        ->and($ente->toll_free)->toBe('')
        ->and($ente->link('phone'))->toBeNull();
})->with([
    'letters' => ['numero verde in attivazione'],
    'tel scheme' => ['tel:050505'],
    'javascript' => ['javascript:alert(1)'],
    'too short' => ['12'],
    'too long' => ['1234567890123456'],
    'markup' => ['800 <b>000</b>'],
    'plus inside' => ['800+000000'],
]);

it('drops email and pec that are malformed or could add mailto parameters', function (string $bad): void {
    config()->set('ente', ['pec' => $bad, 'email' => $bad, 'dpo_email' => $bad]);

    $ente = enteAction('it');

    expect($ente->pec)->toBe('')
        ->and($ente->email)->toBe('')
        ->and($ente->dpo_email)->toBe('')
        ->and($ente->rightsContact())->toBeNull();
})->with([
    'no at' => ['non-una-email'],
    'with query' => ['a?bcc=altro@example.test@example.test'],
    'with ampersand' => ['a&b@example.test'],
    'with space' => ['a b@example.test'],
    'markup' => ['<script>@example.test'],
]);

it('keeps only http and https urls with a host', function (string $bad): void {
    config()->set('ente', ['region_url' => $bad]);

    expect(enteAction('it')->region_url)->toBe('');
})->with([
    'javascript' => ['javascript:alert(1)'],
    'data' => ['data:text/html,x'],
    'ftp' => ['ftp://example.test/x'],
    'protocol relative' => ['//example.test/x'],
    'no host' => ['https://'],
    'relative' => ['/portale'],
    'quote' => ['https://example.test/"onmouseover="x'],
    'space' => ['https://example .test'],
    'angle' => ['https://example.test/<x>'],
]);

it('keeps only allowed social networks with a valid url and gives them label and icon', function (): void {
    config()->set('ente', ['social' => [
        ['network' => 'Facebook', 'url' => 'https://www.facebook.com/ente.prova'],
        ['network' => 'youtube', 'url' => 'https://www.youtube.com/@prova', 'label' => 'Canale video'],
        ['network' => 'sconosciuta', 'url' => 'https://example.test/x'],
        ['network' => 'telegram', 'url' => 'javascript:alert(1)'],
        ['network' => 'twitter', 'url' => ''],
        'non-un-array',
        ['url' => 'https://example.test/senza-rete'],
    ]]);

    expect(enteAction('it')->social)->toBe([
        ['network' => 'facebook', 'label' => 'Facebook', 'url' => 'https://www.facebook.com/ente.prova', 'icon' => 'it-facebook'],
        ['network' => 'youtube', 'label' => 'Canale video', 'url' => 'https://www.youtube.com/@prova', 'icon' => 'it-youtube'],
    ]);
});

it('picks the text for the requested locale, then the fallback locale, then the first available', function (): void {
    config()->set('app.fallback_locale', 'it');
    config()->set('ente', [
        'hours' => ['it' => 'Orari it', 'en' => 'Hours en'],
        'address' => ['de' => 'Adresse de'],
        'region_name' => 'Regione unica',
    ]);

    expect(enteAction('en')->hours)->toBe('Hours en')
        ->and(enteAction('it')->hours)->toBe('Orari it')
        ->and(enteAction('es')->hours)->toBe('Orari it')
        ->and(enteAction('it')->address)->toBe('Adresse de')
        ->and(enteAction('es')->region_name)->toBe('Regione unica');
});

it('uses the application locale when none is passed', function (): void {
    app()->setLocale('en');
    config()->set('ente', ['hours' => ['it' => 'Orari it', 'en' => 'Hours en']]);

    expect(enteAction()->hours)->toBe('Hours en');
});

it('chooses the contact for the exercise of data rights: dpo email, then pec, then email', function (): void {
    config()->set('ente', ['dpo_email' => 'dpo@example.test', 'pec' => 'pec@example.test', 'email' => 'info@example.test']);
    expect(enteAction('it')->rightsContact())->toBe(['label' => 'dpo@example.test', 'href' => 'mailto:dpo@example.test']);

    config()->set('ente', ['pec' => 'pec@example.test', 'email' => 'info@example.test']);
    expect(enteAction('it')->rightsContact())->toBe(['label' => 'pec@example.test', 'href' => 'mailto:pec@example.test']);

    config()->set('ente', ['email' => 'info@example.test']);
    expect(enteAction('it')->rightsContact())->toBe(['label' => 'info@example.test', 'href' => 'mailto:info@example.test']);

    config()->set('ente', ['phone' => '000 111222']);
    expect(enteAction('it')->rightsContact())->toBeNull();
});

it('declares every EnteData field in the tenant file and never ships a placeholder value', function (): void {
    $path = base_path('config/local/fixcity/ente.php');
    expect($path)->toBeFile();

    /** @var array<string, mixed> $config */
    $config = require $path;
    $fields = array_map(
        static fn (\ReflectionProperty $property): string => $property->getName(),
        (new \ReflectionClass(EnteData::class))->getProperties(\ReflectionProperty::IS_PUBLIC),
    );

    expect($fields)->not->toBe([])
        ->and(array_diff($fields, array_keys($config)))->toBe([]);

    $encoded = json_encode($config, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    foreach (['05 0505', '050505', 'Demo', 'Name of the Region', 'Nome della Regione', 'Nome Comune', 'info@comune.it', 'comune@pec.it', '000-0000000'] as $placeholder) {
        expect($encoded)->not->toContain($placeholder);
    }
});

it('counts the dpo email as a contact to publish, so the rights link always has a footer target', function (): void {
    config()->set('ente', ['dpo_email' => 'dpo@example.test']);
    expect(enteAction('it')->hasContacts())->toBeTrue();

    config()->set('ente', ['dpo_name' => 'Solo il nome']);
    expect(enteAction('it')->hasContacts())->toBeFalse();
});
