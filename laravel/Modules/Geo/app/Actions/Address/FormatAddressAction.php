<?php

declare(strict_types=1);

namespace Modules\Geo\Actions\Address;

use Illuminate\Support\Facades\Cache;
use Modules\Geo\Actions\GeoData\GetItalianMunicipalitiesPathAction;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Province;
use Spatie\QueueableAction\QueueableAction;

use function Safe\file_get_contents;
use function Safe\filemtime;
use function Safe\json_decode;

/**
 * Indirizzo in forma italiana: «Viale delle Nazioni 12, 48122 Ravenna (RA)».
 *
 * Il form dell'indirizzo (AddressForm) salva i CODICI ISTAT: `locality` = comune, `administrative_area_level_2`
 * = provincia, `administrative_area_level_1` = regione. Senza questa conversione `full_address` mostrava
 * «Viale delle Nazioni 12, 39014, 39, 48122» (nelle tabelle e nel geocoding). Gli indirizzi scritti per nome
 * (geocoding, import) restano come sono.
 */
class FormatAddressAction
{
    use QueueableAction;

    public function execute(Address $address): string
    {
        $street = trim(implode(' ', array_filter([
            self::text($address->route),
            self::text($address->street_number),
        ])));

        $locality = self::text($address->locality);
        $provinceCode = self::text($address->administrative_area_level_2);
        $localityName = $locality !== null && ctype_digit($locality) ? $this->localityName((int) $locality) : $locality;
        $abbreviation = $provinceCode !== null && ctype_digit($provinceCode) ? $this->provinceAbbreviation((int) $provinceCode) : null;

        $cityLine = trim(implode(' ', array_filter([self::text($address->postal_code), $localityName])));
        if ($abbreviation !== null) {
            $cityLine .= ' ('.$abbreviation.')';
        }

        $parts = [$street, $cityLine];
        // Province e regioni scritte per nome (indirizzi geocodificati): si aggiungono come prima.
        foreach ([$address->administrative_area_level_3, $address->administrative_area_level_2] as $area) {
            $area = self::text($area);
            if ($area !== null && ! ctype_digit($area)) {
                $parts[] = $area;
            }
        }
        $parts[] = self::text($address->country);

        return implode(', ', array_filter($parts, static fn (?string $part): bool => $part !== null && $part !== ''));
    }

    private function localityName(int $code): ?string
    {
        $name = Locality::query()->find($code)?->name;

        return \is_string($name) && $name !== '' ? $name : null;
    }

    /**
     * Sigla della provincia (RA) dal file ISTAT; senza sigla, il nome della provincia.
     */
    private function provinceAbbreviation(int $code): ?string
    {
        $abbreviations = $this->abbreviations();
        if (isset($abbreviations[$code])) {
            return $abbreviations[$code];
        }
        $name = Province::query()->find($code)?->name;

        return \is_string($name) && $name !== '' ? $name : null;
    }

    /**
     * @return array<int, string> codice provincia => sigla
     */
    private function abbreviations(): array
    {
        $path = app(GetItalianMunicipalitiesPathAction::class)->execute();
        if (! is_file($path)) {
            return [];
        }

        /** @var array<int, string> */
        return Cache::rememberForever('geo:province-abbreviations:'.md5($path).':'.filemtime($path), static function () use ($path): array {
            $map = [];
            $rows = json_decode(file_get_contents($path), true);
            if (! \is_array($rows)) {
                return [];
            }
            foreach ($rows as $row) {
                if (! \is_array($row) || ! \is_array($row['provincia'] ?? null)) {
                    continue;
                }
                $code = $row['provincia']['codice'] ?? null;
                $abbreviation = $row['sigla'] ?? null;
                if (is_numeric($code) && \is_string($abbreviation) && $abbreviation !== '') {
                    $map[(int) $code] = $abbreviation;
                }
            }

            return $map;
        });
    }

    private static function text(mixed $value): ?string
    {
        if (\is_int($value)) {
            return (string) $value;
        }

        return \is_string($value) && trim($value) !== '' ? trim($value) : null;
    }
}
