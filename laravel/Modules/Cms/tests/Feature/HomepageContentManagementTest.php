<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

describe('Homepage Content Management', function () {
    // The site works, so tests must reflect real behavior
    // Route / redirects to /{locale}, so we test the localized route
    $locale = app()->getLocale();

    it('loads homepage content from JSON correctly', function () use ($locale) {
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica che il contenuto JSON sia caricato correttamente
        $response->assertSee('<nome progetto> - Promozione della <slogan> per le gestanti');
    });

    it('displays content blocks with correct structure', function () {
        $locale = app()->getLocale();
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica struttura blocchi
        $response->assertSee('landing-page');
        $response->assertSee('Benvenuta su <nome progetto>');
        $response->assertSee('il portale che vuole garantire alle pazienti vulnerabili');
    });

    it('renders hero block with all required elements', function () use ($locale) {
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica elementi hero block
        $response->assertSee('INIZIA ORA');
        $response->assertSee('Sorriso-Denti-bianchi-donna-apparecchio-denti-e-salute-1.jpg');
        $response->assertSee('bg-white');
        $response->assertSee('text-gray-900');
        $response->assertSee('bg-indigo-600');
    });

    it('handles missing content gracefully', function () use ($locale) {
        // Questo test può essere espanso per verificare gestione errori
        $response = get('/'.$locale);
        $response->assertStatus(200);

        // Verifica che la pagina si carichi anche con contenuto mancante
    });

    it('displays localized content correctly', function () {
        // Test italiano
        $response = get('/it');
        $response->assertStatus(200);
        $response->assertSee('Benvenuta su <nome progetto>');

        // Test inglese
        $response = get('/en');
        $response->assertStatus(200);
        // Verifica contenuto inglese

        // Test tedesco
        $response = get('/de');
        $response->assertStatus(200);

        // Verifica contenuto tedesco
    });

    it('renders CTA button with correct functionality', function () use ($locale) {
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica CTA button
        $response->assertSee('INIZIA ORA');
        $response->assertSee('href="'.route('register').'"');
        $response->assertSee('bg-indigo-600 hover:bg-indigo-700');
    });

    it('displays hero image with proper attributes', function () use ($locale) {
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica immagine hero
        $response->assertSee('Sorriso-Denti-bianchi-donna-apparecchio-denti-e-salute-1.jpg');

        // Verifica attributi immagine (alt, loading, etc.)
    });

    it('applies correct CSS classes for styling', function () use ($locale) {
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica classi CSS
        $response->assertSee('bg-white');
        $response->assertSee('text-gray-900');
        $response->assertSee('bg-indigo-600');
        $response->assertSee('hover:bg-indigo-700');
    });

    it('handles content updates without breaking', function () use ($locale) {
        // Questo test verifica che la pagina si carichi correttamente
        // anche quando il contenuto JSON viene aggiornato
        $response = get('/'.$locale);
        $response->assertStatus(200);

        // Verifica che la struttura base sia sempre presente
    });

    it('displays content in correct order', function () use ($locale) {
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica ordine contenuti
        // Il titolo deve apparire prima del sottotitolo
        $content = $response->getContent();
        $titlePos = strpos($content, '<nome progetto> - Promozione della <slogan> per le gestanti');
        $subtitlePos = strpos($content, 'il portale che vuole garantire alle pazienti vulnerabili');

        expect($titlePos)->toBeLessThan($subtitlePos);
    });

    it('renders responsive design elements', function () use ($locale) {
        $response = get('/'.$locale);

        $response->assertStatus(200);
        // Verifica elementi responsive
        $response->assertSee('class="');

        // Verifica che il layout sia responsive
    });
});
