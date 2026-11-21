<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Osm;

use Illuminate\Support\Facades\Config;

use function Safe\preg_replace;

/**
 * User-Agent delle richieste del proxy verso i servizi di OSMF.
 *
 * Le policy di tile e Nominatim chiedono un User-Agent che identifichi il servizio e permetta di contattarlo,
 * mai quello predefinito di una libreria HTTP: «<app>/osm-proxy (+<url>; <contatto>)».
 * Contatto: `geo.config.osm_proxy.contact` (GEO_OSM_CONTACT), altrimenti il mittente della posta dell'app.
 */
final class BuildOsmUserAgentAction
{
    public function execute(): string
    {
        $name = preg_replace('/[^A-Za-z0-9._-]+/', '-', Config::string('app.name', 'Laravel'));
        $url = Config::string('app.url', '');
        $contact = $this->contact();

        $details = array_values(array_filter([$url !== '' ? '+'.$url : '', $contact], static fn (string $part): bool => $part !== ''));

        return trim($name.'/osm-proxy'.($details === [] ? '' : ' ('.implode('; ', $details).')'));
    }

    private function contact(): string
    {
        foreach (['geo.config.osm_proxy.contact', 'mail.from.address'] as $key) {
            $value = config($key);
            if (is_string($value) && trim($value) !== '') {
                return trim($value);
            }
        }

        return '';
    }
}
