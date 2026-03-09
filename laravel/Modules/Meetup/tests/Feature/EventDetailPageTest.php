<?php

/**
 * Feature coverage for localized event detail rendering.
 *
 * @category Tests
 * @package  Modules\Meetup\Tests\Feature
 * @author   Laravel Pizza <info@laravelpizza.com>
 * @license  https://opensource.org/licenses/MIT MIT
 * @link     https://laravelpizza.com
 */

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test(
    'localized event detail page renders successfully from slug route',
    function (): void {
        $slug = 'laravel-pizza-detail-test-'.uniqid();

        Event::factory()->upcoming()->create(
            [
                'title' => 'Laravel Pizza Detail Test',
                'slug' => $slug,
                'cover_image' => null,
                'url' => null,
                'offers' => null,
                'meta_data' => null,
                'keywords' => '["laravel","pizza","test"]',
            ]
        );

        $this->get('/it/events/'.$slug)
            ->assertOk()
            ->assertSee('Laravel Pizza Detail Test')
            ->assertDontSee('Undefined variable $pageSlug')
            ->assertDontSee('Nessun evento trovato');
    }
);
