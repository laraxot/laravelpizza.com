import { html } from 'lit';
import { unsafeHTML } from 'lit/directives/unsafe-html.js';
import magnifyingGlassSvg from '../../svg/magnifying-glass.svg?raw';
import arrowsPointingOutSvg from '../../svg/arrows-pointing-out.svg?raw';
import arrowsPointingInSvg from '../../svg/arrows-pointing-in.svg?raw';
import mapPinSvg from '../../svg/map-pin.svg?raw';
import squares2x2Svg from '../../svg/squares-2x2.svg?raw';
import plusSvg from '../../svg/plus.svg?raw';
import minusSvg from '../../svg/minus.svg?raw';

/**
 * geo-heroicons.js — "Filament way" icon system for Lit components.
 * Icons referenced by Heroicons name, mirroring <x-heroicon-o-NAME> Blade pattern.
 * SVG files loaded from ../../svg/ via Vite ?raw import.
 * Usage: geoIcon('magnifying-glass') → Lit html template
 *
 * FIX 2026-04-28: usa unsafeHTML() perché raw SVG string interpolata con html``
 * viene HTML-escaped da Lit (sicurezza XSS) → SVG appare come testo grezzo.
 */
const icons = {
    'magnifying-glass': html`${unsafeHTML(magnifyingGlassSvg)}`,
    'arrows-pointing-out': html`${unsafeHTML(arrowsPointingOutSvg)}`,
    'arrows-pointing-in': html`${unsafeHTML(arrowsPointingInSvg)}`,
    'map-pin': html`${unsafeHTML(mapPinSvg)}`,
    'squares-2x2': html`${unsafeHTML(squares2x2Svg)}`,
    'plus': html`${unsafeHTML(plusSvg)}`,
    'minus': html`${unsafeHTML(minusSvg)}`,
};

export function geoIcon(name) {
    return icons[name] ?? html``;
}
