/**
 * Prova di resources/js/components/map/default-view.js (DCP-146, W2-GEO), senza browser.
 * Uso: node --test Modules/Geo/tests/js/default-view.test.mjs
 */
import { test } from 'node:test';
import assert from 'node:assert/strict';

import { FALLBACK_VIEW, parseDefaultView, resolveInitialView } from '../../resources/js/components/map/default-view.js';

const firenze = { lat: 43.77, lng: 11.25, zoom: 12 };

test('parse: accetta numeri e stringhe numeriche (env), scarta tutto il resto', () => {
    assert.deepEqual(parseDefaultView(firenze), firenze);
    assert.deepEqual(parseDefaultView({ lat: '43.77', lng: '11.25', zoom: '12' }), firenze);
    for (const bad of [null, undefined, {}, [], 'x', { lat: 43, lng: 11 }, { lat: null, lng: 11, zoom: 6 },
        { lat: '', lng: 11, zoom: 6 }, { lat: 91, lng: 11, zoom: 6 }, { lat: 43, lng: 181, zoom: 6 },
        { lat: 43, lng: 11, zoom: 0 }, { lat: 43, lng: 11, zoom: 20 }, { lat: 43, lng: 11, zoom: 6.5 }]) {
        assert.equal(parseDefaultView(bad), null, JSON.stringify(bad));
    }
});

test('ordine: punto salvato, centro esplicito, fuso orario, vista di default, Italia', () => {
    const point = { lat: 45.46, lng: 9.19 };
    const center = { lat: 44, lng: 10 };
    const approximate = { lat: 35.68, lng: 139.65 };

    assert.deepEqual(resolveInitialView({ point, center, approximate, defaultView: firenze, zoom: 13 }), { ...point, zoom: 13, source: 'state' });
    assert.deepEqual(resolveInitialView({ center, approximate, defaultView: firenze, zoom: 13 }), { ...center, zoom: 13, source: 'center' });
    assert.deepEqual(resolveInitialView({ approximate, defaultView: firenze, zoom: 13 }), { ...approximate, zoom: 6, source: 'timezone' });
    assert.deepEqual(resolveInitialView({ defaultView: firenze, zoom: 13 }), { ...firenze, source: 'default' });
    assert.deepEqual(resolveInitialView({ zoom: 13 }), { ...FALLBACK_VIEW, source: 'fallback' });
});

test('mai il mondo intero: vista non valida o assente ricade sull\'Italia, zoom >= 6', () => {
    for (const defaultView of [undefined, null, {}, { lat: 'x', lng: 1, zoom: 3 }, { lat: 200, lng: 0, zoom: 6 }]) {
        const view = resolveInitialView({ defaultView, zoom: 13 });
        assert.equal(view.source, 'fallback');
        assert.ok(view.zoom >= 6, `zoom ${view.zoom}`);
    }
});
