<?php

/**
 * Feature coverage for localized event detail rendering.
 *
 * @category Tests
 *
 * @author   Laravel Pizza <info@laravelpizza.com>
 * @license  https://opensource.org/licenses/MIT MIT
 *
 * @link     https://laravelpizza.com
 */

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

test(
    'localized event detail page renders successfully from slug route',
    function (): void {
        $slug = 'laravel-pizza-detail-test-'.uniqid();
        $organizer = User::factory()->create([
            'name' => 'Organizer Test',
            'email' => 'organizer-test-'.uniqid().'@example.com',
        ]);

        Event::factory()->upcoming()->create(
            [
                'title' => 'Laravel Pizza Detail Test',
                'slug' => $slug,
                'location' => "Via Roma 1\nMilano",
                'cover_image' => null,
                'url' => null,
                'offers' => null,
                'meta_data' => null,
                'keywords' => '["laravel","pizza","test"]',
                'attendees_count' => 0,
                'max_attendees' => 99,
                'is_accessible_for_free' => true,
                'organizer_id' => $organizer->getKey(),
                'user_id' => $organizer->getKey(),
            ]
        );

        $this->get('/it/events/'.$slug)
            ->assertOk()
            ->assertSee('Laravel Pizza Detail Test')
            ->assertSee('Organizer Test')
            ->assertSee('Ingresso gratuito')
            ->assertSee('Vedi sulla mappa')
            ->assertSee('Nessun partecipante confermato per ora')
            ->assertSee('Iscrizione online in arrivo')
            ->assertSee('Ci sono ancora molti posti disponibili')
            ->assertDontSee('Undefined variable $pageSlug')
            ->assertDontSee('Nessun evento trovato')
            ->assertDontSee('Conferma prenotazione')
            ->assertDontSee('Posti in esaurimento!')
            ->assertDontSee('URL Copied!');
    }
);
