<?php

declare(strict_types=1);
use Modules\Xot\Actions\Route\GetRouteMethodAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('GetRouteMethodAction restituisce il metodo dichiarato as-is (Arr::wrap non filtra)', function (): void {
    // Nota: il test originale (RouteDynServiceTest) asseriva un filtro dei
    // valori non stringa che il codice reale (Arr::wrap) non esegue mai —
    // corretto qui per riflettere il comportamento verificato a runtime.
    Assert::assertSame(
        ['get', 1, 'post'],
        app(GetRouteMethodAction::class)->execute(['method' => ['get', 1, 'post']]),
    );
});

test('GetRouteMethodAction torna al default get+post se method non e specificato', function (): void {
    Assert::assertSame(['get', 'post'], app(GetRouteMethodAction::class)->execute([]));
});
