<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions;

use Illuminate\Support\Str;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Database\Factories\PageFactory;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

describe('Resolve Page Action', function (): void {
    test('it resolves adynamic model from known mappings', function (): void {
        /* @var TestCase $this */
        if (! class_exists('Modules\\Meetup\\Models\\Event')) {
            $this->skipTest('Meetup module not available.');
        }

        $this->skipTest('Meetup EventFactory not configured in this workspace.');
    });

    test('it resolves acms page with exact slug', function (): void {
        $slug = 'about.us-'.uniqid();
        PageFactory::new()->createOne(['slug' => $slug]);

        $action = app(ResolvePageAction::class);
        $result = $action->execute('about', (string) Str::after($slug, 'about.'));

        Assert::assertSame('cms', $result->renderMode);
        Assert::assertSame($slug, $result->pageSlug);
    });

    test('it falls back to container view if slug not found', function (): void {
        $viewSlug = 'blog.view';
        PageFactory::new()->createOne(['slug' => $viewSlug]);

        $container = (string) Str::before($viewSlug, '.');
        $action = app(ResolvePageAction::class);
        $result = $action->execute($container, 'non-existent');

        Assert::assertSame('cms', $result->renderMode);
        Assert::assertSame($viewSlug, $result->pageSlug);
    });

    test('it returns full slug as final fallback', function (): void {
        $action = app(ResolvePageAction::class);
        $result = $action->execute('unknown', 'page');

        Assert::assertSame('cms', $result->renderMode);
        Assert::assertSame('unknown.page', $result->pageSlug);
    });
});
