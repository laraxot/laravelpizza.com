<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Modules\Cms\Actions\ResolvePageAction;
use Modules\Cms\Datas\ResolvePageData;
use Modules\Cms\Models\Page as PageModel;
use Modules\Meetup\Models\Event;
use Tests\TestCase;

class ResolvePageActionTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * The connections that should be transacted.
     *
     * @var array<int, string>
     */
    protected $connectionsToTransact = ['mysql', 'meetup', 'user', 'tenant'];

    public function test_it_resolves_a_dynamic_model_from_known_mappings(): void
    {
        $event = Event::factory()->create(['slug' => 'test-event-'.uniqid()]);
        PageModel::where('slug', 'events.'.$event->slug)->delete();

        $action = app(ResolvePageAction::class);
        $result = $action->execute('events', (string) $event->slug);

        expect($result)->toBeInstanceOf(ResolvePageData::class);
        expect($result->renderMode)->toBeIn(['model', 'cms']);

        if ('model' === $result->renderMode) {
            expect($result->item)->not->toBeNull();
            expect($result->item->id)->toBe($event->id);
        }
    }

    public function test_it_resolves_a_cms_page_with_exact_slug(): void
    {
        $slug = 'about.us-'.uniqid();
        PageModel::factory()->create(['slug' => $slug]);
        
        $action = app(ResolvePageAction::class);
        $result = $action->execute('about', (string) Str::after($slug, 'about.'));

        expect($result->renderMode)->toBe('cms');
        expect($result->pageSlug)->toBe($slug);
    }

    public function test_it_falls_back_to_container_view_if_slug_not_found(): void
    {
        $viewSlug = 'blog.view-'.uniqid();
        PageModel::factory()->create(['slug' => $viewSlug]);
        
        $container = (string) Str::before($viewSlug, '.');
        $action = app(ResolvePageAction::class);
        $result = $action->execute($container, 'non-existent');

        expect($result->renderMode)->toBe('cms');
        expect($result->pageSlug)->toBeIn([$container.'.view', $viewSlug]);
    }

    public function test_it_returns_full_slug_as_final_fallback(): void
    {
        $action = app(ResolvePageAction::class);
        $result = $action->execute('unknown', 'page');

        expect($result->renderMode)->toBe('cms');
        expect($result->pageSlug)->toBe('unknown.page');
    }
}
