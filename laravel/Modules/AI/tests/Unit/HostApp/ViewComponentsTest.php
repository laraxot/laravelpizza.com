<?php

declare(strict_types=1);

use App\View\Components\Alert;
use App\View\Components\AppLayout;
use App\View\Components\GuestLayout;
use App\View\Components\Header;
use App\View\Components\Input;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Facades\View;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Contratto dei componenti Blade di App\View\Components: quale vista sceglie
 * ciascun componente e quali dati passa.
 *
 * Le viste reali stanno nei tema (Themes/One, Themes/Zero) e non sono
 * risolvibili sotto Testbench: il test registra `tests/Unit/fixtures/views`
 * come percorso aggiuntivo, cosi' `view()` risolve senza montare un tema.
 * Nessun accesso al database.
 *
 * Queste classi esistono solo negli host con lo scheletro completo (ptvx,
 * predict, ...). Gli host con app/ minimale (restaurant, techplanner, ...)
 * non le forniscono: ogni test salta se la classe mancante, invece di fallire.
 */

uses(TestCase::class);

beforeEach(function (): void {
    View::addLocation(__DIR__.'/fixtures/views');
});

test('alert component renders the alert view and keeps its payload', function (): void {
    if (! class_exists(Alert::class)) {
        $this->markTestSkipped('Host app senza App\View\Components\Alert.');
    }

    $component = new Alert('danger', 'Qualcosa e andato storto');

    Assert::assertSame('danger', $component->type);
    Assert::assertSame('Qualcosa e andato storto', $component->message);

    $view = $component->render();

    Assert::assertInstanceOf(ViewContract::class, $view);
    Assert::assertSame('components.alert', $view->name());
    Assert::assertSame('components.alert', $view->getData()['view']);
});

test('input component renders the input view', function (): void {
    if (! class_exists(Input::class)) {
        $this->markTestSkipped('Host app senza App\View\Components\Input.');
    }

    $view = (new Input)->render();

    Assert::assertInstanceOf(ViewContract::class, $view);
    Assert::assertSame('components.input', $view->name());
    Assert::assertSame('components.input', $view->getData()['view']);
});

test('header component renders the header view', function (): void {
    if (! class_exists(Header::class)) {
        $this->markTestSkipped('Host app senza App\View\Components\Header.');
    }

    $view = (new Header)->render();

    Assert::assertInstanceOf(ViewContract::class, $view);
    Assert::assertSame('components.header', $view->name());
    Assert::assertSame('components.header', $view->getData()['view']);
});

test('app layout component renders the app layout', function (): void {
    if (! class_exists(AppLayout::class)) {
        $this->markTestSkipped('Host app senza App\View\Components\AppLayout.');
    }

    $view = (new AppLayout)->render();

    Assert::assertInstanceOf(ViewContract::class, $view);
    Assert::assertSame('layouts.app', $view->name());
});

test('guest layout component renders the guest layout', function (): void {
    if (! class_exists(GuestLayout::class)) {
        $this->markTestSkipped('Host app senza App\View\Components\GuestLayout.');
    }

    $view = (new GuestLayout)->render();

    Assert::assertInstanceOf(ViewContract::class, $view);
    Assert::assertSame('layouts.guest', $view->name());
});
