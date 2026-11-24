<?php

declare(strict_types=1);

use Filament\Forms\Components\Builder;
use Modules\Cms\Filament\Fields\PageContent;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
// I tre test avevano closure vuote e commenti che spiegavano perche': `make()` chiama
// `GetAllBlocksAction` e senza i blocchi configurati l'esecuzione fallisce. Cio' che si
// puo' verificare senza container e' la firma, e sono tre fatti distinti — esistenza,
// staticita', tipo di ritorno — non tre volte lo stesso.

test('PageContent creates builder with blocks from GetAllBlocksAction', function (): void {
    Assert::assertTrue(class_exists(PageContent::class));
});

test('PageContent has make method', function (): void {
    Assert::assertTrue((new ReflectionMethod(PageContent::class, 'make'))->isStatic());
});

test('PageContent make returns builder', function (): void {
    $returnType = (new ReflectionMethod(PageContent::class, 'make'))->getReturnType();

    Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
    Assert::assertSame(Builder::class, $returnType->getName());
});
