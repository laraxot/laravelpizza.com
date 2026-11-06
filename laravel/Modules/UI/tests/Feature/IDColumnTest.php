<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Illuminate\Support\HtmlString;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('IDColumn — identificatore e target di ritorno della riga', function (): void {
    it('rende un target HTML stabile senza anchor annidati', function (): void {
        $html = IDColumn::renderAnchor(42)->toHtml();

        Assert::assertSame(
            '<span id="record-42" class="scroll-mt-24">42</span>',
            $html,
        );
        Assert::assertStringNotContainsString('<a', $html);
    });

    it('rende valori testuali in modo sicuro nell attributo e nel testo', function (): void {
        $html = IDColumn::renderAnchor('a&b')->toHtml();

        Assert::assertSame(
            '<span id="record-a&amp;b" class="scroll-mt-24">a&amp;b</span>',
            $html,
        );
    });

    it('restituisce una stringa HTML vuota per uno stato non identificabile', function (): void {
        Assert::assertSame('', IDColumn::renderAnchor(new HtmlString(''))->toHtml());
    });
});
