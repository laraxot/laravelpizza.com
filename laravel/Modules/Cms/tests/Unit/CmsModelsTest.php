<?php

declare(strict_types=1);

use Modules\Cms\Database\Factories\PageFactory;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Section;
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
it('can create a cms page via factory', function (): void {
    $page = PageFactory::new()->createOne([
        'title' => 'Home Page',
        'slug' => 'home',
        'content' => 'Welcome to our website',
    ]);

    Assert::assertInstanceOf(Page::class, $page);
    Assert::assertSame('home', $page->slug);
    Assert::assertSame('Welcome to our website', $page->content);
});

it('can instantiate cms menu model', function (): void {
    $menu = new Menu;

    Assert::assertContains('title', $menu->getFillable());
});

it('can instantiate cms section model', function (): void {
    $section = new Section;

    Assert::assertContains('name', $section->getFillable());
});

it('page factory produces sushi-backed page rows', function (): void {
    $page = PageFactory::new()->createOne([
        'slug' => 'cms-models-test',
    ]);

    Assert::assertInstanceOf(Page::class, $page);
    Assert::assertSame('cms-models-test', $page->slug);
});
