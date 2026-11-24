<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature;

use Carbon\CarbonInterval;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Sleep;
use Modules\Geo\Actions\Osm\QueryNominatimAction;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

/*
 * Proxy OpenStreetMap del modulo Geo (config geo.config.osm_proxy, issue laraxot/theme_sixteen_fila5#106): il browser
 * chiede tile e geocoding al nostro dominio; il server rispetta le policy di OSMF (User-Agent con contatto, Referer,
 * cache, richieste condizionali, 1 richiesta al secondo a Nominatim, niente parametri arbitrari).
 */

beforeEach(function (): void {
    Storage::fake('local');
    Cache::flush();
    RateLimiter::clear(QueryNominatimAction::RATE_LIMIT_KEY);
    Sleep::fake();
    config([
        'app.name' => 'CivicApp',
        'app.url' => 'https://civic.example',
        'geo.config.osm_proxy.contact' => 'ops@civic.example',
        'geo.config.osm_proxy.nominatim.enabled' => true,
    ]);
});

afterEach(function (): void {
    Carbon::setTestNow();
});

function osmPng(): string
{
    return "\x89PNG\r\n\x1a\nfake-tile";
}

it('serves a tile from our domain with a contactable User-Agent, the forwarded Referer and no cookie', function (): void {
    Http::fake(['tile.openstreetmap.org/*' => Http::response(osmPng(), 200, ['Content-Type' => 'image/png', 'ETag' => '"abc"', 'Cache-Control' => 'max-age=3600'])]);

    $response = $this->get('/api/geo/tiles/osm/13/4350/2985.png', ['Referer' => 'https://civic.example/it/tickets']);

    $response->assertOk()
        ->assertHeader('Content-Type', 'image/png')
        ->assertHeader('ETag', '"abc"')
        ->assertHeaderMissing('Set-Cookie');
    expect($response->getContent())->toBe(osmPng());
    Http::assertSent(fn (Request $request): bool => $request->url() === 'https://tile.openstreetmap.org/13/4350/2985.png'
        && $request->header('User-Agent')[0] === 'CivicApp/osm-proxy (+https://civic.example; ops@civic.example)'
        && $request->header('Referer')[0] === 'https://civic.example/it/tickets');
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
<<<<<<< .merge_file_WNhrmp
})->group('GEO-TILE-INV-3');
=======
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
<<<<<<< .merge_file_5rjOE4
<<<<<<< HEAD
});
=======
<<<<<<< HEAD
});
=======
})->group('GEO-TILE-INV-3');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
})->group('GEO-TILE-INV-3');
>>>>>>> .merge_file_Fzv2bh
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
>>>>>>> .merge_file_G9OGsp
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39

it('keeps a tile at least 7 days even when OSM says one hour, then revalidates it with a conditional request', function (): void {
    Http::fakeSequence('tile.openstreetmap.org/*')
        ->push(osmPng(), 200, ['Content-Type' => 'image/png', 'ETag' => '"v1"', 'Cache-Control' => 'max-age=3600'])
        ->push('', 304, ['ETag' => '"v1"']);

    $this->get('/api/geo/tiles/osm/5/10/12.png')->assertOk();
    Carbon::setTestNow(now()->addDays(6));
    $this->get('/api/geo/tiles/osm/5/10/12.png')->assertOk();
    Http::assertSentCount(1);

    Carbon::setTestNow(now()->addDays(2));
    $response = $this->get('/api/geo/tiles/osm/5/10/12.png');

    $response->assertOk();
    expect($response->getContent())->toBe(osmPng());
    Http::assertSentCount(2);
    Http::assertSent(fn (Request $request): bool => $request->hasHeader('If-None-Match', '"v1"'));
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
<<<<<<< .merge_file_WNhrmp
})->group('GEO-TILE-INV-1', 'GEO-TILE-INV-2', 'GEO-TILE-INV-4');
=======
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
<<<<<<< .merge_file_5rjOE4
<<<<<<< HEAD
});
=======
<<<<<<< HEAD
});
=======
})->group('GEO-TILE-INV-1', 'GEO-TILE-INV-2', 'GEO-TILE-INV-4');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
})->group('GEO-TILE-INV-1', 'GEO-TILE-INV-2', 'GEO-TILE-INV-4');
>>>>>>> .merge_file_Fzv2bh
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
>>>>>>> .merge_file_G9OGsp
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39

it('serves the stale copy when OSM is down', function (): void {
    Http::fakeSequence('tile.openstreetmap.org/*')
        ->push(osmPng(), 200, ['Content-Type' => 'image/png'])
        ->push('down', 503);

    $this->get('/api/geo/tiles/osm/3/1/1.png')->assertOk();
    Carbon::setTestNow(now()->addDays(8));

    $response = $this->get('/api/geo/tiles/osm/3/1/1.png');
    $response->assertOk();
    expect($response->getContent())->toBe(osmPng());
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
<<<<<<< .merge_file_WNhrmp
})->group('GEO-TILE-INV-5');
=======
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
<<<<<<< .merge_file_5rjOE4
<<<<<<< HEAD
});
=======
<<<<<<< HEAD
});
=======
})->group('GEO-TILE-INV-5');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
})->group('GEO-TILE-INV-5');
>>>>>>> .merge_file_Fzv2bh
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
>>>>>>> .merge_file_G9OGsp
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39

it('answers 404 outside the tile grid without asking OSM', function (string $path): void {
    Http::fake();

    $this->get($path)->assertNotFound();
    Http::assertNothingSent();
})->with([
    'x beyond the grid' => ['/api/geo/tiles/osm/2/4/0.png'],
    'zoom above 19' => ['/api/geo/tiles/osm/20/1/1.png'],
]);

it('proxies an address search in json, in the page language, and caches it', function (): void {
    Http::fake(['nominatim.openstreetmap.org/*' => Http::response([['display_name' => 'Piazza della Signoria, Firenze', 'lat' => '43.76', 'lon' => '11.25']])]);

    $first = $this->getJson('/api/geo/nominatim/search?q=Piazza+della+Signoria&limit=50&polygon_geojson=1', ['Accept-Language' => 'it-IT']);
    $this->getJson('/api/geo/nominatim/search?q=Piazza+della+Signoria&limit=50&polygon_geojson=1', ['Accept-Language' => 'it-IT'])->assertOk();

    $first->assertOk()->assertJsonPath('0.display_name', 'Piazza della Signoria, Firenze');
    Http::assertSentCount(1);
    Http::assertSent(fn (Request $request): bool => str_starts_with($request->url(), 'https://nominatim.openstreetmap.org/search?')
        && $request['format'] === 'json'
        && $request['accept-language'] === 'it'
        && $request['limit'] === '10'
        && ! isset($request['polygon_geojson'])
        && is_string($userAgent = $request->header('User-Agent')[0] ?? null)
        && str_starts_with($userAgent, 'CivicApp/osm-proxy'));
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
<<<<<<< .merge_file_WNhrmp
})->group('GEO-NOMINATIM-INV-2', 'GEO-NOMINATIM-INV-3', 'GEO-NOMINATIM-INV-4', 'GEO-NOMINATIM-INV-6');
=======
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
<<<<<<< .merge_file_5rjOE4
<<<<<<< HEAD
});
=======
<<<<<<< HEAD
});
=======
})->group('GEO-NOMINATIM-INV-2', 'GEO-NOMINATIM-INV-3', 'GEO-NOMINATIM-INV-4', 'GEO-NOMINATIM-INV-6');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
})->group('GEO-NOMINATIM-INV-2', 'GEO-NOMINATIM-INV-3', 'GEO-NOMINATIM-INV-4', 'GEO-NOMINATIM-INV-6');
>>>>>>> .merge_file_Fzv2bh
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
>>>>>>> .merge_file_G9OGsp
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39

it('rejects invalid geocoding requests without calling Nominatim', function (string $path, int $status): void {
    Http::fake();

    $this->getJson($path)->assertStatus($status);
    Http::assertNothingSent();
})->with([
    'query too short' => ['/api/geo/nominatim/search?q=ab', 422],
    'latitude out of range' => ['/api/geo/nominatim/reverse?lat=95&lon=11', 422],
    'unknown endpoint' => ['/api/geo/nominatim/lookup?osm_ids=R1', 404],
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
<<<<<<< .merge_file_WNhrmp
])->group('GEO-NOMINATIM-INV-5');
=======
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
<<<<<<< .merge_file_5rjOE4
<<<<<<< HEAD
]);
=======
<<<<<<< HEAD
]);
=======
])->group('GEO-NOMINATIM-INV-5');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
])->group('GEO-NOMINATIM-INV-5');
>>>>>>> .merge_file_Fzv2bh
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
>>>>>>> .merge_file_G9OGsp
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39

it('can be switched off without a software update, as the Nominatim policy requires', function (): void {
    config(['geo.config.osm_proxy.nominatim.enabled' => false]);
    Http::fake();

    $this->getJson('/api/geo/nominatim/reverse?lat=43.7&lon=11.2')->assertStatus(503);
    Http::assertNothingSent();
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
<<<<<<< .merge_file_WNhrmp
})->group('GEO-NOMINATIM-INV-7');
=======
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
<<<<<<< .merge_file_5rjOE4
<<<<<<< HEAD
});
=======
<<<<<<< HEAD
});
=======
})->group('GEO-NOMINATIM-INV-7');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
})->group('GEO-NOMINATIM-INV-7');
>>>>>>> .merge_file_Fzv2bh
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
>>>>>>> .merge_file_G9OGsp
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39

it('never sends Nominatim more than one request per second for the whole site', function (): void {
    Http::fake(['nominatim.openstreetmap.org/*' => Http::response([])]);

    $this->getJson('/api/geo/nominatim/reverse?lat=43.70&lon=11.20')->assertOk();
    // stesso secondo, altra richiesta: si aspetta il secondo dopo; se il posto e' ancora occupato, 429
    $this->getJson('/api/geo/nominatim/reverse?lat=43.71&lon=11.21')->assertStatus(429);

    Http::assertSentCount(1);
    Sleep::assertSlept(fn (CarbonInterval $duration): bool => $duration->totalSeconds === 1.0, 1);
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
<<<<<<< .merge_file_WNhrmp
})->group('GEO-NOMINATIM-INV-1');
=======
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
<<<<<<< .merge_file_5rjOE4
<<<<<<< HEAD
});
=======
<<<<<<< HEAD
});
=======
})->group('GEO-NOMINATIM-INV-1');
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
=======
})->group('GEO-NOMINATIM-INV-1');
>>>>>>> .merge_file_Fzv2bh
<<<<<<< .merge_file_fgTtLF
<<<<<<< .merge_file_6Zv1Tn
<<<<<<< .merge_file_bKuHMa
>>>>>>> .merge_file_G9OGsp
=======
>>>>>>> .merge_file_i9aQs0
=======
>>>>>>> .merge_file_42kQxI
=======
>>>>>>> .merge_file_3eiH39
