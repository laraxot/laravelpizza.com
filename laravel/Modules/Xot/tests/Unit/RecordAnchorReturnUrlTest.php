<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Modules\Xot\Filament\Links\RecordAnchor;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;
use function Safe\parse_url;

// Questo test esercita solo la normalizzazione degli URL: non usa Eloquent né il database.
// XotBaseTestCase evita di avviare DatabaseTransactions e mantiene il test realmente unitario.
uses(XotBaseTestCase::class);

test('currentUrl restituisce l URL completo fuori da una richiesta Livewire', function (): void {
    app()->instance('request', Request::create('/admin/users?page=2'));

    expect(RecordAnchor::currentUrl())->toEndWith('/admin/users?page=2');
});

test('currentUrl durante una richiesta Livewire restituisce la pagina e non l endpoint di update', function (): void {
    $snapshot = json_encode(['memo' => ['path' => 'admin/users', 'method' => 'GET']]);
    app()->instance('request', Request::create(
        '/livewire-abc123/update',
        'POST',
        ['components' => [['snapshot' => $snapshot]]],
        [],
        [],
        ['HTTP_X_LIVEWIRE' => 'true'],
    ));

    expect(RecordAnchor::currentUrl())
        ->toEndWith('/admin/users')
        ->not->toContain('livewire-abc123');
});

test('il link di riga riporta alla stessa riga dell elenco', function (): void {
    app()->instance('request', Request::create('/admin/users'));

    $link = RecordAnchor::appendReturnTo('/admin/users/1875/edit', RecordAnchor::currentUrl(), 1875);
    $queryString = parse_url($link, PHP_URL_QUERY);
    Assert::assertIsString($queryString);
    parse_str($queryString, $query);
    $returnTo = $query[RecordAnchor::RETURN_TO_PARAMETER] ?? null;
    Assert::assertIsString($returnTo);

    expect(RecordAnchor::resolveReturnTo($returnTo, 1875))->toEndWith('/admin/users#record-1875');
});

test('un return_to verso un altro host viene rifiutato', function (): void {
    app()->instance('request', Request::create('/admin/users'));

    expect(RecordAnchor::resolveReturnTo('https://evil.example/admin/users', 1875))->toBeNull();
});

test('un return_to che il browser aprirebbe su un altro sito viene rifiutato', function (string $returnTo): void {
    app()->instance('request', Request::create('/admin/users'));

    expect(RecordAnchor::resolveReturnTo($returnTo, 1875))->toBeNull();
})->with([
    'backslash dopo la barra' => ['/\\evil.example'],
    'tab dopo la barra' => ["/\t/evil.example"],
    'tre barre' => ['///evil.example'],
    'schema https senza host' => ['https:evil.example'],
    'schema http senza host' => ['http:evil.example'],
    'percorso senza barra iniziale' => ['evil.example/x'],
    'userinfo che maschera l host' => ['https://localhost@evil.example/admin/users'],
    'stesso host su un altra porta' => ['http://localhost:8080/admin/users'],
    'stesso host con schema diverso' => ['https://localhost/admin/users'],
    'host e porta senza schema' => ['localhost:80/admin/users'],
]);

test('un return_to della stessa origine viene accettato', function (string $returnTo): void {
    app()->instance('request', Request::create('/admin/users'));

    expect(RecordAnchor::resolveReturnTo($returnTo, 1875))->toEndWith('#record-1875');
})->with([
    'percorso' => ['/admin/users'],
    'percorso con query' => ['/admin/users?page=2'],
    'url assoluto stesso host' => ['http://localhost/admin/users?filter%5Bname%5D=a%20b'],
    'ancora gia presente' => ['/admin/users#record-5'],
]);
