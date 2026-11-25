<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Filament;

use Illuminate\Support\HtmlString;
use Modules\UI\Filament\Tables\Columns\IDColumn;

/*
 * Unit puro (niente TestCase/DB): ancora + link frammento IDColumn.
 */

it('rende un link frammento same-page con id ancora stabile', function (): void {
    $html = IDColumn::renderAnchor(42)->toHtml();

    expect($html)->toBe(
        '<a id="record-42" href="#record-42" class="scroll-mt-24 fi-link text-primary-600 hover:underline" title="#record-42">42</a>'
    );
});

it('rende valori testuali in modo sicuro nell attributo e nel testo', function (): void {
    $html = IDColumn::renderAnchor('a&b')->toHtml();

    expect($html)->toBe(
        '<a id="record-a&amp;b" href="#record-a&amp;b" class="scroll-mt-24 fi-link text-primary-600 hover:underline" title="#record-a&amp;b">a&amp;b</a>'
    );
});

it('restituisce una stringa HTML vuota per uno stato non identificabile', function (): void {
    expect(IDColumn::renderAnchor(new HtmlString(''))->toHtml())->toBe('');
});
