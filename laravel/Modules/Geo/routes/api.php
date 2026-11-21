<?php

declare(strict_types=1);

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */
/*
 * Route::middleware('auth:api')->get('/geo', function (Request $request) {
 * return $request->user();
 * });
 */

use Illuminate\Support\Facades\Route;
use Modules\Geo\Http\Controllers\NominatimController;
use Modules\Geo\Http\Controllers\OsmTileController;

/*
 * Proxy OpenStreetMap (config `geo.config.osm_proxy`): il browser chiede tile e geocoding al nostro dominio, non a OSMF.
 * Gruppo `api` con prefisso `api`: nessuna sessione ne' cookie, risposte cachabili.
 * Limiti per IP: una mappa carica una ventina di tile per vista; la ricerca di un indirizzo e' un'azione esplicita.
 */
Route::get('geo/tiles/osm/{z}/{x}/{y}.png', OsmTileController::class)
    ->where(['z' => '[0-9]{1,2}', 'x' => '[0-9]{1,7}', 'y' => '[0-9]{1,7}'])
    ->middleware('throttle:1200,1')
    ->name('geo.osm.tile');

Route::get('geo/nominatim/{endpoint}', NominatimController::class)
    ->whereIn('endpoint', ['search', 'reverse'])
    ->middleware('throttle:30,1')
    ->name('geo.nominatim');
