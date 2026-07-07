import { html } from 'lit';
import { unsafeHTML } from 'lit/directives/unsafe-html.js';
import magnifyingGlassSvg from '../../../svg/magnifying-glass.svg?raw';
import arrowsPointingOutSvg from '../../../svg/arrows-pointing-out.svg?raw';
import arrowsPointingInSvg from '../../../svg/arrows-pointing-in.svg?raw';
import mapPinSvg from '../../../svg/map-pin.svg?raw';
import squares2x2Svg from '../../../svg/squares-2x2.svg?raw';
import plusSvg from '../../../svg/plus.svg?raw';
import minusSvg from '../../../svg/minus.svg?raw';
import xMarkSvg from '../../../svg/x-mark.svg?raw';
import lightBulbSvg from '../../../svg/light-bulb.svg?raw';
import trashSvg from '../../../svg/trash.svg?raw';
import wrenchSvg from '../../../svg/wrench.svg?raw';
import sparklesSvg from '../../../svg/sparkles.svg?raw';
import archiveBoxSvg from '../../../svg/archive-box.svg?raw';
import buildingOfficeSvg from '../../../svg/building-office.svg?raw';
import globeAltSvg from '../../../svg/globe-alt.svg?raw';
import truckSvg from '../../../svg/truck.svg?raw';
import shieldCheckSvg from '../../../svg/shield-check.svg?raw';
import documentTextSvg from '../../../svg/document-text.svg?raw';
import questionMarkCircleSvg from '../../../svg/question-mark-circle.svg?raw';

/**
 * Heroicons for shared map controls (Lit).
 * SVG from Modules/Geo/resources/svg/ via Vite ?raw import.
 * Uses unsafeHTML() so Lit does not escape inline SVG markup.
 */
const icons = {
    'magnifying-glass': html`${unsafeHTML(magnifyingGlassSvg)}`,
    'arrows-pointing-out': html`${unsafeHTML(arrowsPointingOutSvg)}`,
    'arrows-pointing-in': html`${unsafeHTML(arrowsPointingInSvg)}`,
    'map-pin': html`${unsafeHTML(mapPinSvg)}`,
    'squares-2x2': html`${unsafeHTML(squares2x2Svg)}`,
    'plus': html`${unsafeHTML(plusSvg)}`,
    'minus': html`${unsafeHTML(minusSvg)}`,
    'x-mark': html`${unsafeHTML(xMarkSvg)}`,
    'light-bulb': html`${unsafeHTML(lightBulbSvg)}`,
    'trash': html`${unsafeHTML(trashSvg)}`,
    'wrench': html`${unsafeHTML(wrenchSvg)}`,
    'sparkles': html`${unsafeHTML(sparklesSvg)}`,
    'archive-box': html`${unsafeHTML(archiveBoxSvg)}`,
    'building-office': html`${unsafeHTML(buildingOfficeSvg)}`,
    'globe-alt': html`${unsafeHTML(globeAltSvg)}`,
    'truck': html`${unsafeHTML(truckSvg)}`,
    'shield-check': html`${unsafeHTML(shieldCheckSvg)}`,
    'document-text': html`${unsafeHTML(documentTextSvg)}`,
    'question-mark-circle': html`${unsafeHTML(questionMarkCircleSvg)}`,
};

const rawIcons = {
    'light-bulb': lightBulbSvg,
    'trash': trashSvg,
    'wrench': wrenchSvg,
    'sparkles': sparklesSvg,
    'archive-box': archiveBoxSvg,
    'building-office': buildingOfficeSvg,
    'globe-alt': globeAltSvg,
    'truck': truckSvg,
    'shield-check': shieldCheckSvg,
    'document-text': documentTextSvg,
    'question-mark-circle': questionMarkCircleSvg,
};

export function geoIcon(name) {
    return icons[name] ?? html``;
}

export function geoIconRaw(name) {
    return rawIcons[name] ?? '';
}
