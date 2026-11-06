<?php

declare(strict_types=1);

namespace Modules\Geo\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Illuminate\View\Component;

use function Safe\json_encode;
use function Safe\preg_match;

/**
 * Mappa di SOLA LETTURA di un punto: `<x-geo::point-map :latitude="$lat" :longitude="$lng" :address="$addr" />`.
 *
 * Monta `coordinate-picker-lit` con l'attributo `readonly` (marker non trascinabile, nessun click che scrive
 * lo stato, nessuna ricerca/geolocalizzazione/fullscreen; pan e zoom restano). Non e' un campo: nessuno stato Livewire.
 * Senza coordinate valide stampa un segnaposto testuale. Le prop sono `mixed` di proposito: arrivano dallo
 * stato di un form e una stringa sporca deve dare il segnaposto, non un errore di rendering.
 */
class PointMap extends Component
{
    public const string DEFAULT_HEIGHT = '16rem';

    public const int DEFAULT_ZOOM = 16;

    public readonly ?float $lat;

    public readonly ?float $lng;

    public readonly string $latText;

    public readonly string $lngText;

    public readonly string $address;

    public readonly int $zoom;

    public readonly string $height;

    public readonly string $mapId;

    public readonly string $wireKey;

    public readonly string $ariaLabel;

    public readonly string $stateJson;

    public readonly string $labelsJson;

    public readonly string $osmUrl;

    public function __construct(
        mixed $latitude = null,
        mixed $longitude = null,
        mixed $address = null,
        mixed $zoom = self::DEFAULT_ZOOM,
        mixed $height = self::DEFAULT_HEIGHT,
        mixed $label = null,
        mixed $id = null,
    ) {
        $lat = self::coordinate($latitude, 90.0);
        $lng = self::coordinate($longitude, 180.0);
        $hasPoint = null !== $lat && null !== $lng;

        $this->lat = $hasPoint ? $lat : null;
        $this->lng = $hasPoint ? $lng : null;
        $this->latText = number_format($lat ?? 0.0, 6, '.', '');
        $this->lngText = number_format($lng ?? 0.0, 6, '.', '');
        $this->address = \is_string($address) ? trim($address) : '';
        $this->zoom = is_numeric($zoom) ? max(1, min(19, (int) $zoom)) : self::DEFAULT_ZOOM;
        // La altezza finisce in uno stile inline e in un attributo: solo lunghezze semplici, mai CSS libero.
        $this->height = \is_string($height) && 1 === preg_match('/^\d+(?:\.\d+)?(?:px|rem|em|vh|%)$/', $height)
            ? $height
            : self::DEFAULT_HEIGHT;

        $mapLabel = \is_string($label) && '' !== trim($label) ? trim($label) : __('geo::point-map.default_label');
        $place = '' !== $this->address ? $this->address : $this->latText.', '.$this->lngText;
        $this->ariaLabel = __('geo::point-map.aria_label', ['label' => $mapLabel, 'place' => $place]);

        $this->stateJson = json_encode([
            'latitude' => $this->lat,
            'longitude' => $this->lng,
            'address' => $this->address,
        ], JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE);
        $this->labelsJson = json_encode([
            'zoom_in' => __('geo::coordinate-picker.zoom_in'),
            'zoom_out' => __('geo::coordinate-picker.zoom_out'),
        ], JSON_UNESCAPED_UNICODE);
        $this->osmUrl = \sprintf(
            'https://www.openstreetmap.org/?mlat=%s&mlon=%s#map=%d/%s/%s',
            $this->latText,
            $this->lngText,
            $this->zoom,
            $this->latText,
            $this->lngText,
        );

        // id casuale: due istanze nella stessa pagina non collidono. Il wire:key invece e' legato al contenuto
        // (stabile tra i render Livewire; cambia solo se cambia il punto, cosi' la mappa si rimonta nel nuovo punto).
        // ponytail: due istanze con lo stesso punto nello stesso componente Livewire devono avere `id` esplicito.
        $explicitId = \is_string($id) && '' !== trim($id) ? trim($id) : null;
        $this->mapId = $explicitId ?? 'geo-point-map-'.Str::lower(Str::random(8));
        $this->wireKey = $explicitId ?? 'geo-point-map-'.substr(md5($this->stateJson), 0, 12);
    }

    public function render(): View
    {
        /** @var view-string $view */
        $view = 'geo::components.point-map';

        return view($view);
    }

    private static function coordinate(mixed $value, float $limit): ?float
    {
        if (! is_numeric($value)) {
            return null;
        }

        $number = (float) $value;

        return is_finite($number) && abs($number) <= $limit ? $number : null;
    }
}
