<?php

declare(strict_types=1);

namespace Modules\Geo\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Arr;
use Modules\Geo\Enums\AddressItemEnum;
use Modules\Geo\Models\Address;
use Webmozart\Assert\Assert;

use function Safe\preg_replace;

/**
 * Trait HasAddress.
 *
 * Fornisce funzionalità per la gestione degli indirizzi nei modelli Eloquent.
 * Questo trait implementa la relazione polimorfica con il modello Address
 * e offre metodi di utilità per la gestione degli indirizzi.
 *
 * @property MorphMany<Address, $this> $addresses
 * @property MorphOne<Address, $this>  $address
 */
trait HasAddress
{
    /**
     * Ottiene gli indirizzi associati al modello.
     *
     * @return MorphMany<Address, $this>
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    /**
     * Ottiene indirizzo associato al modello.
     *
     * @return MorphOne<Address, $this>
     */
    public function address(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    /**
     * Ottiene l'indirizzo principale del modello.
     */
    public function primaryAddress(): ?Address
    {
        $res = $this->addresses()->where('is_primary', true)->first();
        if ($res === null) {
            return $res;
        }
        Assert::isInstanceOf($res, Address::class);

        return $res;
    }

    /**
     * Ottiene l'indirizzo completo formattato.
     */
    public function getFullAddress(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->getFullAddress() : null;
    }

    public function getFullAddressAttribute(?string $value): string
    {
        if ($value !== null) {
            return $value;
        }

        $route = $this->getAttribute('route');
        $streetNumber = $this->getAttribute('street_number');
        $postalCode = $this->getAttribute('postal_code');
        $city = $this->getAttribute('city');
        $province = $this->getAttribute('province');

        $formatted = sprintf(
            '%s, %s - %s, %s (%s)',
            is_string($route) ? $route : '',
            is_string($streetNumber) ? $streetNumber : '',
            is_string($postalCode) ? $postalCode : '',
            is_string($city) ? $city : '',
            is_string($province) ? $province : '',
        );

        return trim(preg_replace('/[,\s]+/', ' ', $formatted));
    }

    public function getFullAddressesAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }
        $address = $this->address()->first();
        if ($address === null) {
            return null;
        }
        Assert::isInstanceOf($address, Address::class);

        $locality = $address->getLocality();
        if ($locality === null) {
            return null;
        }

        $streetAddress = is_string($address->street_address) ? $address->street_address : '';
        $streetNumber = is_string($address->street_number) ? $address->street_number : '';
        $postalCode = is_string($address->postal_code) ? $address->postal_code : '';

        $localityNome = isset($locality['nome']) && is_string($locality['nome']) ? $locality['nome'] : '';
        $provinciaNome = isset($locality['provincia']) && is_array($locality['provincia']) && isset($locality['provincia']['nome']) && is_string($locality['provincia']['nome']) ? $locality['provincia']['nome'] : '';

        return $streetAddress.
            ', '.
            $streetNumber.
            ' - '.
            $postalCode.
            ' '.
            $localityNome.
            ' ('.
            $provinciaNome.
            ') ';
    }

    /**
     * Ottiene la località dell'indirizzo principale.
     */
    public function getCity(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->locality : null;
    }

    /**
     * Ottiene il CAP dell'indirizzo principale.
     */
    public function getPostalCode(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->postal_code : null;
    }

    /**
     * Ottiene la provincia dell'indirizzo principale.
     */
    public function getProvince(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->administrative_area_level_3 : null;
    }

    /**
     * Ottiene la regione dell'indirizzo principale.
     */
    public function getRegion(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->administrative_area_level_2 : null;
    }

    /**
     * Ottiene il paese dell'indirizzo principale.
     */
    public function getCountry(): ?string
    {
        $address = $this->primaryAddress();

        return $address ? $address->country : null;
    }

    /**
     * Imposta un indirizzo come principale e rimuove il flag da tutti gli altri.
     */
    public function setAsPrimaryAddress(Address $address): bool
    {
        if ($address->model_id !== $this->id || $address->model_type !== static::class) {
            return false;
        }

        $this->addresses()
            ->where('id', '!=', $address->id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);

        return $address->update(['is_primary' => true]);
    }

    /**
     * Ottiene gli indirizzi di un determinato tipo.
     *
     * @return Collection<int, Address>
     */
    public function getAddressesByType(string $type): Collection
    {
        return $this->addresses()->where('type', $type)->get();
    }

    /**
     * Aggiunge un nuovo indirizzo al modello.
     *
     * @param array<string, mixed> $data
     */
    public function addAddress(array $data, bool $setPrimary = false): Address
    {
        $payload = $data;

        if ($setPrimary || $this->addresses()->count() === 0) {
            $payload = array_merge($payload, ['is_primary' => true]);

            if ($this->addresses()->count() > 0) {
                $this->addresses()->update(['is_primary' => false]);
            }
        }

        $address = $this->addresses()->create($payload);
        Assert::isInstanceOf($address, Address::class);

        return $address;
    }

    /**
     * Aggiorna l'indirizzo principale.
     *
     * @param array<string, mixed> $data
     */
    public function updatePrimaryAddress(array $data): ?Address
    {
        $primaryAddress = $this->primaryAddress();

        if (! $primaryAddress) {
            return $this->addAddress($data, true);
        }

        $primaryAddress->update($data);

        return $primaryAddress;
    }

    /**
     * Scope per filtrare i modelli in base alla città dell'indirizzo.
     *
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInCity(Builder $query, string $city): Builder
    {
        $query->whereHas('addresses', function ($q) use ($city): void {
            $q->where('locality', $city);
        });

        return $query;
    }

    /**
     * Scope per filtrare i modelli in base alla provincia dell'indirizzo.
     *
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInProvince(Builder $query, string $province): Builder
    {
        $query->whereHas('addresses', function ($q) use ($province): void {
            $q->where('administrative_area_level_3', $province);
        });

        return $query;
    }

    /**
     * Scope per filtrare i modelli in base alla regione dell'indirizzo.
     *
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInRegion(Builder $query, string $region): Builder
    {
        $query->whereHas('addresses', function ($q) use ($region): void {
            $q->where('administrative_area_level_2', $region);
        });

        return $query;
    }

    /**
     * Scope per filtrare i modelli in base al CAP dell'indirizzo.
     *
     * @param Builder<static> $query
     *
     * @return Builder<static>
     */
    public function scopeInPostalCode(Builder $query, string $postalCode): Builder
    {
        $query->whereHas('addresses', function ($q) use ($postalCode): void {
            $q->where('postal_code', $postalCode);
        });

        return $query;
    }

    /**
     * Initialize the trait.
     */
    protected function initializeHasAddress(): void
    {
        $this->mergeFillable(Arr::map(
            AddressItemEnum::cases(),
            static fn (AddressItemEnum $item): string => $item->value,
        ));
    }
}
