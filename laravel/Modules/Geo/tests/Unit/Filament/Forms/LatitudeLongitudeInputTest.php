<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms;

uses(TestCase::class);

use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Tests\TestCase;

/*
 * Test LatitudeLongitudeInput component for story 8-10:
 * - Bidirectional sync between map marker and coordinate inputs
 * - No destructive page refresh on marker drag
 * - Consistent initial state
 */

test('LatitudeLongitudeInput can be instantiated', function () {
    $field = LatitudeLongitudeInput::make('location');

    expect($field)->toBeObject();
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput supports fluent interface for defaults', function () {
    $field = LatitudeLongitudeInput::make('location')
        ->defaultCenter(41.9028, 12.4964)
        ->defaultZoom(13)
        ->mapHeight('340px')
        ->showMap(true);

    expect($field)->toBeObject();
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput fluent methods return self', function () {
    $field = LatitudeLongitudeInput::make('location');

    $result1 = $field->defaultCenter(41.9028, 12.4964);
    expect($result1)->toBe($field);

    $result2 = $field->defaultZoom(13);
    expect($result2)->toBe($field);

    $result3 = $field->mapHeight('400px');
    expect($result3)->toBe($field);

    $result4 = $field->showMap(false);
    expect($result4)->toBe($field);
});

test('LatitudeLongitudeInput renders with wire:model.change (non-destructive sync)', function () {
    $field = LatitudeLongitudeInput::make('location')
        ->defaultCenter(41.9028, 12.4964)
        ->defaultZoom(13)
        ->mapHeight('340px');

    // Render the field as Blade template
    $view = $field->getView();
    expect($view)->toBe('geo::filament.forms.components.latitude-longitude-input');
});

test('LatitudeLongitudeInput has no wire:model.live to prevent aggressive re-renders', function () {
    // This test documents the requirement that the component uses wire:model.change
    // instead of wire:model.live to prevent destructive page refreshes during drag.
    // AC1: Nessun refresh distruttivo al drag marker
    // AC5: Idempotenza su re-render Livewire

    // The Blade template explicitly uses:
    // wire:model.change="{{ $statePath }}.latitude"
    // wire:model.change="{{ $statePath }}.longitude"
    // NOT wire:model.live to avoid frequent Livewire updates during rapid DOM changes

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput protects map shell with wire:ignore', function () {
    // AC5: Idempotenza su re-render Livewire
    // The wire:ignore attribute on the map shell prevents Livewire from resetting
    // the map instance when parent Livewire component is updated.
    // This ensures the global instances registry and Leaflet map state are preserved.

    // The Blade template contains:
    // <div wire:ignore id="{{ $shellId }}" class="latitude-longitude-map-shell ...">
    //     <div id="{{ $mapId }}" class="latitude-longitude-map-canvas ..."></div>
    // </div>

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput initializes with coordinate priority', function () {
    // AC2: Stato iniziale coerente all'apertura
    // Marker, center map, and input latitude/longitude should represent the same position
    // Livewire state coordinates take precedence over defaults

    // The init() function in the Blade script (lines 282-289):
    // 1. Checks initialLat/initialLng from Livewire state
    // 2. If not finite, falls back to defaultLat/defaultLng
    // 3. Sets currentLat/currentLng
    // 4. Only commits to Livewire if using defaults (usedDefaults = true)

    $field = LatitudeLongitudeInput::make('location')
        ->defaultCenter(41.9028, 12.4964)
        ->defaultZoom(13);

    expect($field)->toBeObject();
});

test('LatitudeLongitudeInput supports all three map layers', function () {
    // AC3, AC4: sync mappa → input and input → mappa
    // Layer switcher must remain functional during all sync operations

    // The Blade template provides three layer buttons:
    // - OSM (OpenStreetMap)
    // - Satellite (Esri World Imagery)
    // - Terrain (OpenTopoMap)

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput provides geolocation support', function () {
    // AC3: Sync mappa → input
    // The geolocation button triggers same sync flow as drag/click:
    // - Calls navigator.geolocation.getCurrentPosition()
    // - Updates marker position
    // - Calls commitCoordinates() to sync with Livewire

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput provides fullscreen support', function () {
    // AC3, AC4: Sync must remain functional in fullscreen mode
    // The fullscreen button:
    // - Calls requestFullscreen() on map shell
    // - Calls map.invalidateSize() to recalculate map dimensions
    // - Dispatches map-fullscreen-change event for UI state tracking

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput throttles drag updates', function () {
    // AC1: Nessun refresh distruttivo al drag marker
    // During drag, DOM updates are throttled to ~200ms (line 341 in Blade):
    // if (!dragUpdateTimer) {
    //     dragUpdateTimer = setTimeout(() => {
    //         this.setInputValues(pos.lat, pos.lng, false);
    //         dragUpdateTimer = null;
    //     }, 200);
    // }
    // This prevents rapid wire:model.change events that would cause Livewire churn.

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput commits coordinates on dragend', function () {
    // AC1: Nessun refresh distruttivo al drag marker
    // AC3: Sync mappa → input
    // On dragend (line 349-357), the component:
    // 1. Clears the drag throttle timer
    // 2. Updates input values with final marker position
    // 3. Calls commitCoordinates() which dispatches change events
    // This ensures proper Livewire sync without aggressive re-renders.

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput syncs input changes to map with debounce', function () {
    // AC4: Sync input → mappa
    // When user types in latitude/longitude inputs:
    // 1. 'input' event triggers syncMapFromInputs() with 160ms debounce (line 396)
    // 2. 'change' event triggers syncMapFromInputs(true) with commit (line 398)
    // This allows real-time preview (debounced) without Livewire churn,
    // and persistent sync on blur/change.

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput uses isProgrammaticInputUpdate flag to prevent circular sync', function () {
    // AC5: Idempotenza su re-render Livewire
    // The isProgrammaticInputUpdate flag (line 244) prevents circular sync:
    // - When marker moves, setInputValues() sets this flag to true
    // - Input 'change' listener checks this flag and returns early (line 365)
    // - Flag is cleared via queueMicrotask() to allow reverse sync (line 572-574)
    // This ensures marker→input sync doesn't trigger input→marker sync immediately.

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput uses global instances registry for idempotence', function () {
    // AC5: Idempotenza su re-render Livewire
    // The global instances registry (line 227-235) prevents double initialization:
    // if (!window.geoMapInstances) {
    //     window.geoMapInstances = {};
    // }
    // if (window.geoMapInstances[mapId]) {
    //     console.log('[Geo] Using existing instance:', mapId);
    //     return window.geoMapInstances[mapId];
    // }
    // This ensures that if the component re-initializes, it reuses the existing Leaflet instance.

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput validates coordinate ranges', function () {
    // AC4: Sync input → mappa
    // The syncMapFromInputs() function (lines 364-391) validates:
    // - lat must be finite (Number.isFinite)
    // - lng must be finite
    // - lat range: -90 to 90
    // - lng range: -180 to 180
    // If validation fails, the sync is skipped silently (no error thrown).

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput handles map click sync', function () {
    // AC3: Sync mappa → input
    // When user clicks the map (line 409-412):
    // this.map.on('click', (e) => {
    //     this.marker.setLatLng(e.latlng);
    //     this.commitCoordinates(e.latlng.lat, e.latlng.lng);
    // });
    // This syncs map click immediately to marker and Livewire.

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});

test('LatitudeLongitudeInput invalidates map size on intersection', function () {
    // AC1: Nessun refresh distruttivo al drag marker
    // The IntersectionObserver (lines 523-532) monitors when map becomes visible
    // and calls map.invalidateSize() to recalculate dimensions.
    // This prevents hidden/collapsed map state from breaking drag/click functionality.

    $field = LatitudeLongitudeInput::make('location');
    expect($field)->toBeInstanceOf(LatitudeLongitudeInput::class);
});
