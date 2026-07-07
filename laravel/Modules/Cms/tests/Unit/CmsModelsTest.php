<?php

declare(strict_types=1);

use Modules\Cms\Database\Factories\PageFactory;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\Section;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
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
    $menu = new Menu();

    Assert::assertInstanceOf(Menu::class, $menu);
    Assert::assertContains('title', $menu->getFillable());
});

it('can instantiate cms section model', function (): void {
    $section = new Section();

    Assert::assertInstanceOf(Section::class, $section);
    Assert::assertContains('name', $section->getFillable());
});

it('page factory produces sushi-backed page rows', function (): void {
    $page = PageFactory::new()->createOne([
        'slug' => 'cms-models-test',
    ]);

    Assert::assertInstanceOf(Page::class, $page);
    Assert::assertSame('cms-models-test', $page->slug);
});
