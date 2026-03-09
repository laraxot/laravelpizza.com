<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions;

use Illuminate\Support\Str;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Datas\ResolvePageData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Meetup\Models\Event;
use Tests\TestCase;

final class ResolvePageActionTest extends TestCase
{
    /**
     * The connections that should be transacted.
     *
     * @var array<int, string>
     */
    protected array $connectionsToTransact = ['mysql', 'meetup', 'user', 'tenant'];

    public function testItResolvesADynamicModelFromKnownMappings(): void
    {
        $event = Event::factory()->create([
            'slug' => 'test-event-'.uniqid(),
            'cover_image' => null,
            'url' => null,
            'offers' => null,
            'meta_data' => null,
            'keywords' => '["laravel","resolver","test"]',
        ]);
        PageModel::where('slug', 'events.'.$event->slug)->delete();

        $action = app(ResolvePageAction::class);
        $result = $action->execute('events', (string) $event->slug);

        expect($result)->toBeInstanceOf(ResolvePageData::class);
        expect($result->renderMode)->toBe('model');
        expect($result->item)->not->toBeNull();
        expect($result->item->id)->toBe($event->id);
    }

    public function testItResolvesACmsPageWithExactSlug(): void
    {
        $slug = 'about.us-'.uniqid();
        PageModel::factory()->create(['slug' => $slug]);

        $action = app(ResolvePageAction::class);
        $result = $action->execute('about', (string) Str::after($slug, 'about.'));

        expect($result->renderMode)->toBe('cms');
        expect($result->pageSlug)->toBe($slug);
    }

    public function testItFallsBackToContainerViewIfSlugNotFound(): void
    {
        $viewSlug = 'blog.view';
        PageModel::factory()->create(['slug' => $viewSlug]);

        $container = (string) Str::before($viewSlug, '.');
        $action = app(ResolvePageAction::class);
        $result = $action->execute($container, 'non-existent');

        expect($result->renderMode)->toBe('cms');
        expect($result->pageSlug)->toBe($viewSlug);
    }

    public function testItReturnsFullSlugAsFinalFallback(): void
    {
        $action = app(ResolvePageAction::class);
        $result = $action->execute('unknown', 'page');

        expect($result->renderMode)->toBe('cms');
        expect($result->pageSlug)->toBe('unknown.page');
    }
}
