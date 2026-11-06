<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Xot\Actions\Route\BuildActionUrlAction;
use Modules\Xot\Datas\RouteParamsData;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

// Route::name() chiamato dopo la registrazione non aggiorna l'indice dei nomi: Route::has() non le vedrebbe.
function xotUrlActRefreshNames(): void
{
    Route::getRoutes()->refreshNameLookups();
}

/**
 * L'URL dell'azione si ricava dalla route CORRENTE: prima del cleanup PHPStan del 2026-10-06 partiva
 * da '' e restituiva sempre '#show'.
 */
it('builds the url of the action route starting from the current route name', function (): void {
    Route::get('/xot-url-act/items', static fn (): string => 'ok')->name('xot_url_act.items.index');
    Route::get('/xot-url-act/items/show', static fn (): string => 'ok')->name('xot_url_act.items.show');

    xotUrlActRefreshNames();
    $this->get('/xot-url-act/items')->assertOk();

    expect(app(BuildActionUrlAction::class)->execute(['act' => 'show']))->toEndWith('/xot-url-act/items/show');
});

it('replaces only the last segment of the route name', function (): void {
    Route::get('/xot-url-act/profile/edit', static fn (): string => 'ok')->name('xot_url_act.edit_profile.edit');
    Route::get('/xot-url-act/profile', static fn (): string => 'ok')->name('xot_url_act.edit_profile.show');

    xotUrlActRefreshNames();
    $this->get('/xot-url-act/profile/edit')->assertOk();

    // 'edit' compare anche in 'edit_profile': una sostituzione sulla prima occorrenza darebbe 'xot_url_act.show'.
    expect(app(BuildActionUrlAction::class)->execute(['act' => 'show']))->toEndWith('/xot-url-act/profile');
});

it('replaces the whole name when the current route name has no dots', function (): void {
    Route::get('/xot-url-act/flat/edit', static fn (): string => 'ok')->name('edit');
    Route::get('/xot-url-act/flat', static fn (): string => 'ok')->name('show');

    xotUrlActRefreshNames();
    $this->get('/xot-url-act/flat/edit')->assertOk();

    expect(app(BuildActionUrlAction::class)->execute(['act' => 'show']))->toEndWith('/xot-url-act/flat');
});

it('returns a marked anchor when the action route does not exist', function (): void {
    Route::get('/xot-url-act/lonely', static fn (): string => 'ok')->name('xot_url_act.lonely.index');

    xotUrlActRefreshNames();
    $this->get('/xot-url-act/lonely')->assertOk();

    expect(app(BuildActionUrlAction::class)->execute(['act' => 'show']))->toBe('#xot_url_act.lonely.show');
});

it('returns an anchor on the action when the current route has no name', function (): void {
    Route::get('/xot-url-act/anonymous', static fn (): string => 'ok');

    $this->get('/xot-url-act/anonymous')->assertOk();

    expect(app(BuildActionUrlAction::class)->execute(['act' => 'edit']))->toBe('#edit');
});

it('passes the optional row as positional route parameter', function (): void {
    Route::get('/xot-url-act/rows', static fn (): string => 'ok')->name('xot_url_act.rows.index');
    Route::get('/xot-url-act/rows/{row}', static fn (): string => 'ok')->name('xot_url_act.rows.show');

    xotUrlActRefreshNames();
    $this->get('/xot-url-act/rows')->assertOk();

    expect(app(BuildActionUrlAction::class)->execute(['act' => 'show', 'row' => '42']))->toEndWith('/xot-url-act/rows/42');
});

it('ignores the keys that RouteParamsData leaves null and appends the query', function (): void {
    Route::get('/xot-url-act/pages', static fn (): string => 'ok')->name('xot_url_act.pages.index');
    Route::get('/xot-url-act/pages/show', static fn (): string => 'ok')->name('xot_url_act.pages.show');

    xotUrlActRefreshNames();
    $this->get('/xot-url-act/pages')->assertOk();

    /** @var array<string, mixed> $withoutRow */
    $withoutRow = RouteParamsData::from(['act' => 'show'])->toArray();
    /** @var array<string, mixed> $withQuery */
    $withQuery = RouteParamsData::from(['act' => 'show', 'query' => ['page' => 2]])->toArray();

    expect(app(BuildActionUrlAction::class)->execute($withoutRow))->toEndWith('/xot-url-act/pages/show')
        ->and(app(BuildActionUrlAction::class)->execute($withQuery))->toEndWith('/xot-url-act/pages/show?page=2');
});
