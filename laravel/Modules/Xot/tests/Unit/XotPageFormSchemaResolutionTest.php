<?php

declare(strict_types=1);
use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Pages\XotBasePage;
use Modules\Xot\Tests\TestCase;
use Modules\Xot\Tests\Unit\Fixtures\FormSchemaPageFixture;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

uses(TestCase::class);

test('un override di getFormSchema viene onorato su XotBasePage', function (): void {
    $fixture = new FormSchemaPageFixture;
    $method = new ReflectionMethod($fixture, 'resolveFormSchemaForXotPage');
    $method->setAccessible(true);

    /** @var array<int|string, TextInput> $schema */
    $schema = $method->invoke($fixture);

    Assert::assertArrayHasKey('legacy_field', $schema);
    Assert::assertInstanceOf(TextInput::class, $schema['legacy_field']);
});

test('senza override getFormSchema restituisce schema vuoto', function (): void {
    $fixture = new class extends XotBasePage
    {
        protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document';

        protected string $view = 'xot::filament.pages.base';
    };

    $method = new ReflectionMethod($fixture, 'resolveFormSchemaForXotPage');
    $method->setAccessible(true);

    Assert::assertSame([], $method->invoke($fixture));
});

test('getXotFormSchema non esiste piu su XotBasePage', function (): void {
    Assert::assertFalse(method_exists(XotBasePage::class, 'getXotFormSchema'));
});
