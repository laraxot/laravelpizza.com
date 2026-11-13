<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Modules\Geo\Actions\Address\FormatAddressAction;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Traits\GeoTrait;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Class Address.
 *
 * Implementazione di Schema.org PostalAddress
 *
 * @property int $id
 * @property Carbon|null $deleted_at
 * @property string|null $model_type
 * @property int|string|null $model_id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $phone
 * @property string|null $route
 * @property string|null $street_number
 * @property string|null $locality
 * @property string|null $administrative_area_level_3
 * @property string|null $administrative_area_level_2
 * @property string|null $administrative_area_level_1
 * @property string|null $country
 * @property string|null $postal_code
 * @property string|null $formatted_address
 * @property string|null $place_id
 * @property float|null $latitude
 * @property float|null $longitude
 * @property AddressTypeEnum $type
 * @property bool $is_primary
 * @property array<string, mixed>|null $extra_data
 * @property Model $addressable
 * @property ProfileContract|null $creator
 * @property string $full_address
 * @property string $street_address
 * @property Model $model
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|Address nearby(float $latitude, float $longitude, float $radiusKm = 10)
 * @method static Builder<static>|Address newModelQuery()
 * @method static Builder<static>|Address newQuery()
 * @method static Builder<static>|Address ofType(\Modules\Geo\Enums\AddressTypeEnum|string $type)
 * @method static Builder<static>|Address primary()
 * @method static Builder<static>|Address query()
 *
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_by
 *
 * @method static Builder<static>|Address onlyTrashed()
 * @method static Builder<static>|Address whereAdministrativeAreaLevel1($value)
 * @method static Builder<static>|Address whereAdministrativeAreaLevel2($value)
 * @method static Builder<static>|Address whereAdministrativeAreaLevel3($value)
 * @method static Builder<static>|Address whereCountry($value)
 * @method static Builder<static>|Address whereCreatedAt($value)
 * @method static Builder<static>|Address whereCreatedBy($value)
 * @method static Builder<static>|Address whereDeletedAt($value)
 * @method static Builder<static>|Address whereDeletedBy($value)
 * @method static Builder<static>|Address whereDescription($value)
 * @method static Builder<static>|Address whereExtraData($value)
 * @method static Builder<static>|Address whereFormattedAddress($value)
 * @method static Builder<static>|Address whereId($value)
 * @method static Builder<static>|Address whereIsPrimary($value)
 * @method static Builder<static>|Address whereLatitude($value)
 * @method static Builder<static>|Address whereLocality($value)
 * @method static Builder<static>|Address whereLongitude($value)
 * @method static Builder<static>|Address whereModelId($value)
 * @method static Builder<static>|Address whereModelType($value)
 * @method static Builder<static>|Address whereName($value)
 * @method static Builder<static>|Address wherePhone($value)
 * @method static Builder<static>|Address wherePlaceId($value)
 * @method static Builder<static>|Address wherePostalCode($value)
 * @method static Builder<static>|Address whereRoute($value)
 * @method static Builder<static>|Address whereStreetNumber($value)
 * @method static Builder<static>|Address whereType($value)
 * @method static Builder<static>|Address whereUpdatedAt($value)
 * @method static Builder<static>|Address whereUpdatedBy($value)
 * @method static Builder<static>|Address withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Address withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Address extends BaseModel
{
    use GeoTrait;

    /** @var list<string> */
    protected $fillable = [
        'model_type',
        'model_id',
        'name',
        'description',
        'route',
        'street_number',
        'locality',
        'administrative_area_level_3', // comune
        'administrative_area_level_2', // provincia
        'administrative_area_level_1', // regione
        'country', // Stato/Paese
        'postal_code',
        'formatted_address',
        'place_id',
        'latitude',
        'longitude',
        'type',
        'is_primary',
        'extra_data',
    ];

    /**
     * Get the parent model.
     *
     * @return MorphTo<Model, $this>
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relazione polimorfica (alternativa con nome più descrittivo).
     *
     * @return MorphTo<Model, $this>
     */
    public function addressable(): MorphTo
    {
        // Il nome della relazione deve coincidere col metodo, altrimenti l'eager loading
        // (with('addressable')) la registrerebbe come 'model'; le colonne restano model_type/model_id.
        return $this->morphTo('addressable', 'model_type', 'model_id');
    }

    /*
     * Get the city relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * public function city(): BelongsTo
     * {
     * return $this->belongsTo(City::class, 'locality', 'name');
     * }
     */
    /*
     * Get the province relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * public function provincia(): BelongsTo
     * {
     * return $this->belongsTo(Provincia::class, 'administrative_area_level_2', 'name');
     * }
     */
    /*
     * Get the region relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * public function regione(): BelongsTo
     * {
     * return $this->belongsTo(Regione::class, 'administrative_area_level_1', 'name');
     * }
     */
    /**
     * @return array{codice: mixed, nome: mixed}|null
     */
    public function getRegione(): ?array
    {
        $match = $this->findComuneArea('regione', $this->administrative_area_level_1);

        return $match === null ? null : ['codice' => $match['codice'], 'nome' => $match['nome']];
    }

    /**
     * @return array{codice: string, nome: string}|null
     */
    public function getProvincia(): ?array
    {
        $match = $this->findComuneArea('provincia', $this->administrative_area_level_2);

        if ($match === null) {
            return null;
        }

        return [
            'codice' => is_string($match['codice']) ? $match['codice'] : '',
            'nome' => is_string($match['nome']) ? $match['nome'] : '',
        ];
    }

    /**
     * Cerca fra i comuni l'area (regione/provincia) con il codice dato.
     *
     * Il filtro è fatto in PHP e non con json_extract(): i dati Sushi dei comuni possono
     * contenere valori non-JSON (es. "Sicilia") e SQLite fallirebbe con "malformed JSON".
     *
     * @param 'regione'|'provincia' $column
     *
     * @return array{codice: mixed, nome: mixed}|null
     */
    private function findComuneArea(string $column, mixed $code): ?array
    {
        if (! is_scalar($code) || (string) $code === '') {
            return null;
        }

        $matches = [];
        foreach (Comune::query()->select($column)->distinct()->get() as $comune) {
            $area = $comune->getAttribute($column);
            if (! is_array($area) || ! isset($area['codice'], $area['nome'])) {
                continue;
            }
            if (! is_scalar($area['codice']) || (string) $area['codice'] !== (string) $code) {
                continue;
            }

            $matches[] = ['codice' => $area['codice'], 'nome' => $area['nome']];
        }

        if ($matches === []) {
            return null;
        }

        usort($matches, static fn (array $a, array $b): int => strcmp(
            is_scalar($a['nome']) ? (string) $a['nome'] : '',
            is_scalar($b['nome']) ? (string) $b['nome'] : '',
        ));

        return $matches[0];
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getLocality(): ?array
    {
        $comune = Comune::where('codice', $this->locality)
            ->distinct()
            ->first();

        if ($comune === null) {
            return null;
        }

        return $comune->attributesToArray();
    }

    /**
     * Indirizzo completo in formato italiano, con i codici ISTAT convertiti in nomi (FormatAddressAction).
     */
    public function getFullAddressAttribute(): string
    {
        return app(FormatAddressAction::class)->execute($this);
    }

    public function getFullAddress(): ?string
    {
        return app(FormatAddressAction::class)->execute($this);
    }

    /**
     * Getter per l'indirizzo strada completo.
     */
    public function getStreetAddressAttribute(): string
    {
        $route = $this->route ?? '';
        $streetNumber = $this->street_number ?? '';

        $routeStr = is_string($route) ? $route : '';
        $streetNumberStr = is_string($streetNumber) ? $streetNumber : '';

        return trim($routeStr.' '.$streetNumberStr);
    }

    /**
     * Indirizzo su piu' righe: il valore salvato, altrimenti via, localita', regione e paese composti dai campi.
     */
    public function getFormattedAddressAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $lines = [
            $this->formattedStreetLine(),
            $this->formattedLocalityLine(),
            self::filledString($this->getAttribute('administrative_area_level_2')),
            $this->formattedCountryLine(),
        ];

        return implode("\n", array_filter($lines, static fn (?string $line): bool => $line !== null));
    }

    /**
     * Get the latitude of the address.
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * Get the longitude of the address.
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * Get the formatted address required by HasGeolocation interface.
     */
    public function getFormattedAddress(): string
    {
        return $this->formatted_address ?? '';
    }

    /**
     * Restituisce i dati in formato Schema.org PostalAddress.
     *
     * @return array<string, mixed>
     */
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'PostalAddress',
            'name' => $this->name,
            'description' => $this->description,
            'streetAddress' => $this->getStreetAddressAttribute(),
            'addressLocality' => $this->locality,
            'addressSubregion' => $this->administrative_area_level_3, // Provincia
            'addressRegion' => $this->administrative_area_level_2, // Regione
            'addressCountry' => $this->country,
            'postalCode' => $this->postal_code,
        ];
    }

    /**
     * Scope per cercare indirizzi nelle vicinanze.
     */
    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeNearby(Builder $query, float $latitude, float $longitude, float $radiusKm = 10): Builder
    {
        // `*` solo se la query non ha gia' colonne: `*, expr` dopo other
        // select columns e' syntax error su MariaDB (vedi GeoTrait::scopeWithDistance).
        $prefix = $query->getQuery()->columns === null ? '*,' : '';

        return $query
            ->selectRaw('
            '.$prefix.'
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ', [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radiusKm)
            ->orderBy('distance');
    }

    /**
     * Scope a query to only include primary addresses.
     */
    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopePrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to filter by address type.
     */
    /**
     * @param  Builder<static>  $query
     * @return Builder<static>
     */
    public function scopeOfType(Builder $query, string|AddressTypeEnum $type): Builder
    {
        return $query->where('type', $type instanceof AddressTypeEnum ? $type->value : $type);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'is_primary' => 'boolean',
            'extra_data' => 'array',
            'type' => AddressTypeEnum::class,
        ];
    }

    /**
     * Via e numero civico. Senza numero civico la riga non compare.
     */
    private function formattedStreetLine(): ?string
    {
        $route = self::filledString($this->getAttribute('route'));
        $streetNumber = $this->getAttribute('street_number');

        if ($route === null || ! is_string($streetNumber)) {
            return null;
        }

        return self::filledString(trim($route.' '.$streetNumber));
    }

    /**
     * CAP e localita'; con la localita', per gli indirizzi italiani, anche la sigla della provincia.
     */
    private function formattedLocalityLine(): ?string
    {
        $locality = self::filledString($this->getAttribute('locality'));

        $parts = array_filter(
            [
                self::filledString($this->getAttribute('postal_code')),
                $locality,
                $locality === null ? null : $this->provinceAbbreviation(),
            ],
            static fn (?string $part): bool => $part !== null,
        );

        return $parts === [] ? null : implode(' ', $parts);
    }

    /**
     * Sigla della provincia tra parentesi, letta da `extra_data`: solo per indirizzi italiani con provincia.
     */
    private function provinceAbbreviation(): ?string
    {
        $isItalianProvince = $this->getAttribute('country') === 'IT'
            && self::filledString($this->getAttribute('administrative_area_level_3')) !== null;

        if (! $isItalianProvince) {
            return null;
        }

        $abbreviation = self::filledString(data_get($this->getAttribute('extra_data'), 'provincia_sigla'));

        return $abbreviation === null ? null : '('.$abbreviation.')';
    }

    /**
     * Paese in maiuscolo: il nome (`administrative_area_level_1`) se c'e', altrimenti il codice.
     */
    private function formattedCountryLine(): ?string
    {
        $country = self::filledString($this->getAttribute('country'));

        if ($country === null) {
            return null;
        }

        $countryName = $this->getAttribute('administrative_area_level_1') ?? $country;

        return strtoupper(is_string($countryName) ? $countryName : '');
    }

    /**
     * La stringa, oppure null. '' e '0' valgono come assenti: e' la regola dei vecchi `if ($this->campo)`.
     */
    private static function filledString(mixed $value): ?string
    {
        return is_string($value) && (bool) $value ? $value : null;
    }
}
