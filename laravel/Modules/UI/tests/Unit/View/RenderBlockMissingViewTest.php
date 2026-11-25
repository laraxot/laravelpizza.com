<?php

declare(strict_types=1);

use Illuminate\View\View;
use Modules\UI\Tests\TestCase;
use Modules\UI\View\Components\Render\Block;

uses(TestCase::class);

/*
 * ADR docs/adr/0003-missing-block-view-shows-type-not-content.md: un blocco con vista mancante mostra un avviso con
 * vista e tipo, mai i dati del blocco (possono essere bozze o dati personali).
 */
it('renders the alert with view and type only when the block view does not exist', function (): void {
    $missingView = 'ui::view-that-does-not-exist-'.uniqid('', true);
    $block = new Block(['type' => 'hero', 'data' => ['view' => $missingView, 'title' => 'Bozza riservata', 'email' => 'mario@example.test']]);

    $rendered = $block->render();

    expect($rendered)->toBeInstanceOf(View::class);
    /** @var View $rendered */
    $data = $rendered->getData();
    expect($rendered->name())->toBe('ui::alert')
        ->and(array_keys($data))->toEqualCanonicalizing(['title', 'message'])
        ->and($data['message'])->toContain($missingView)->toContain('hero')
        ->and(serialize($data))->not->toContain('Bozza riservata')->not->toContain('mario@example.test');
});
