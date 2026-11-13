<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Feature;

use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Route;
use Livewire\Features\SupportLockedProperties\CannotUpdateLockedPropertyException;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/*
 * Un update Livewire su una proprieta' #[Locked] arriva solo da un payload manomesso (scanner): bootstrap/app.php
 * lo tratta come accesso negato. Prima: 500 e ~40 righe ERROR al giorno in laravel.log (pageSlug, data della homepage).
 */
describe('tampered #[Locked] Livewire property', function (): void {
    it('answers 403 and is not reported', function (): void {
        Exceptions::fake();
        Route::post('/_test/locked-property', static function (): never {
            throw new CannotUpdateLockedPropertyException('pageSlug');
        });

        $this->postJson('/_test/locked-property')->assertForbidden();

        Exceptions::assertNotReported(CannotUpdateLockedPropertyException::class);
    });
});
