<?php

declare(strict_types=1);

namespace Modules\Geo\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Xot\Contracts\ProfileContract;

/**
 * Class Address.
 *
 * Implementazione di Schema.org PostalAddress
 *
 * @property int $id
 * @property string|null $model_type
 * @property string|null $model_id
 * @property string|null $name Nome identificativo dell'indirizzo
 * @property string|null $description Descrizione opzionale
 * @property string|null $route Via/Piazza
 * @property string|null $street_number Numero civico
 * @property string|null $locality Comune/Città
 * @property string|null $administrative_area_level_3 Provincia
 * @property string|null $administrative_area_level_2 Regione
 * @property string|null $administrative_area_level_1 Stato/Paese
 * @property string|null $country Codice paese ISO
 * @property string|null $postal_code CAP
 * @property string|null $formatted_address
 * @property string|null $place_id ID Google Places
 * @property float|null $latitude
 * @property float|null $longitude
 * @property AddressTypeEnum|null $type Tipo indirizzo (home, work, etc.)
 * @property bool $is_primary
 * @property array<array-key, mixed>|null $extra_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @property Model|\Eloquent|null $addressable
 * @property ProfileContract|null $creator
 * @property string $full_address
 * @property string $street_address
 * @property Model|\Eloquent|null $model
 * @property ProfileContract|null $updater
 *
 * @method static Builder<static>|Address nearby(float $latitude, float $longitude, float $radiusKm = 10)
 * @method static Builder<static>|Address newModelQuery()
 * @method static Builder<static>|Address newQuery()
 * @method static Builder<static>|Address ofType($type)
 * @method static Builder<static>|Address primary()
 * @method static Builder<static>|Address query()
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
 * @method static Builder<static>|Address wherePlaceId($value)
 * @method static Builder<static>|Address wherePostalCode($value)
 * @method static Builder<static>|Address whereRoute($value)
 * @method static Builder<static>|Address whereStreetNumber($value)
 * @method static Builder<static>|Address whereType($value)
 * @method static Builder<static>|Address whereUpdatedAt($value)
 * @method static Builder<static>|Address whereUpdatedBy($value)
 *
 * @property ProfileContract|null $deleter
 *
 * @method static AddressFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Address extends BaseModel
{
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
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relazione polimorfica (alternativa con nome più descrittivo).
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo('model');
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
    public function getRegione(): ?array
    {
        /** @phpstan-ignore method.unresolvableReturnType */
        $res = Comune::select('regione')
            ->distinct()
            ->orderBy('regione->nome')
            ->where('regione->codice', $this->administrative_area_level_1)
            ->get()
            /* @phpstan-ignore argument.unresolvableType */
            ->map(function ($item) {
                $regione = $item->regione;
                if (! is_array($regione) || ! isset($regione['codice'], $regione['nome'])) {
                    return;
                }

                return ['codice' => $regione['codice'], 'nome' => $regione['nome']];
            })
            ->filter();

        return $res->first();
    }

    public function getProvincia(): ?array
    {
        /** @phpstan-ignore method.unresolvableReturnType */
        $res = Comune::select('provincia')
            ->distinct()
            ->orderBy('provincia->nome')
            ->where('provincia->codice', $this->administrative_area_level_2)
            ->get()
            /* @phpstan-ignore argument.unresolvableType */
            ->map(fn ($item) => [
                /* @phpstan-ignore offsetAccess.notFound */
                'codice' => $item->provincia['codice'],
                /* @phpstan-ignore offsetAccess.notFound */
                'nome' => $item->provincia['nome'],
            ]);

        return $res->first();
    }

    public function getLocality(): ?array
    {
        /* @phpstan-ignore-next-line */
        return Comune::where('codice', $this->locality)
            ->distinct()
            ->first()
            ?->toArray();
    }

    /**
     * Getter per l'indirizzo completo in formato italiano.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            is_string($this->route) && is_string($this->street_number) ? $this->route.($this->street_number !== '' ? ' '.$this->street_number : '') : null,
            $this->locality,
            $this->administrative_area_level_3, // Provincia
            $this->administrative_area_level_2, // Regione
            $this->postal_code,
            $this->country,
        ], function ($part): bool {
            // PHPStan L10: verifica prima il tipo, poi se è vuoto
            if (! \is_string($part)) {
                return false;
            }

            // Dopo is_string(), $part è string, quindi verifica se è vuoto
            return $part !== '';
        });

        return implode(', ', $parts);
    }

    public function getFullAddress(): ?string
    {
        $parts = array_filter([
            $this->route.($this->street_number ? ' '.$this->street_number : ''),
            $this->locality,
            $this->administrative_area_level_3, // Provincia
            $this->administrative_area_level_2, // Regione
            $this->postal_code,
            $this->country,
        ]);

        return implode(', ', $parts);
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
     * Get the formatted address.
     */
    public function getFormattedAddressAttribute(?string $value): ?string
    {
        // PHPStan L10: $value è già ?string, dopo !== null è string
        if ($value !== null) {
            return $value;
        }

        $parts = [];

        // Indirizzo stradale
        if ($this->route) {
            $route = $this->route;
            $streetNumber = $this->street_number;
            $streetAddress = is_string($route) && is_string($streetNumber) ? trim($route.' '.$streetNumber) : '';
            if ($streetAddress !== '') {
                $parts[] = $streetAddress;
            }
        }

        // Località e provincia (formato italiano)
        $localityParts = [];
        if ($this->postal_code && is_string($this->postal_code)) {
            $localityParts[] = $this->postal_code;
        }

        if ($this->locality && is_string($this->locality)) {
            $localityParts[] = $this->locality;

            // Per indirizzi italiani, aggiungiamo la sigla provincia
            if (($this->country ?? '') === 'IT' && $this->administrative_area_level_3 && is_string($this->administrative_area_level_3)) {
                // Se è un'implementazione reale, potremmo derivare la sigla dalla provincia
                $provinciaSigla = $this->extra_data['provincia_sigla'] ?? null;
                if ($provinciaSigla && is_string($provinciaSigla)) {
                    $localityParts[] = "({$provinciaSigla})";
                }
            }
        }

        if (! empty($localityParts)) {
            $parts[] = implode(' ', $localityParts);
        }

        // Regione
        if ($this->administrative_area_level_2 && is_string($this->administrative_area_level_2)) {
            $parts[] = $this->administrative_area_level_2;
        }

        // Paese
        if ($this->country && is_string($this->country)) {
            $countryName = ($this->administrative_area_level_1 ?? $this->country) ?? '';
            $parts[] = strtoupper(is_string($countryName) ? $countryName : '');
        }

        return implode("\n", $parts);
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
    public function scopeNearby(Builder $query, float $latitude, float $longitude, float $radiusKm = 10): Builder
    {
        return $query
            ->selectRaw('
            *,
            (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance
        ', [$latitude, $longitude, $latitude])
            ->having('distance', '<', $radiusKm)
            ->orderBy('distance');
    }

    /**
     * Scope a query to only include primary addresses.
     */
    public function scopePrimary(Builder $query): Builder
    {
        return $query->where('is_primary', true);
    }

    /**
     * Scope a query to filter by address type.
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
    #[\Override]
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
}
