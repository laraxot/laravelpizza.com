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

/**
 * Trait HasAddress.
 *
 * Fornisce funzionalità per la gestione degli indirizzi nei modelli Eloquent.
 * Questo trait implementa la relazione polimorfica con il modello Address
 * e offre metodi di utilità per la gestione degli indirizzi.
 *
 * @property Collection<int, Address> $addresses
 */
trait HasAddress
{
    /**
     * Initialize the trait.
     *
     * @return void
     */
    protected function initializeHasAddress()
    {
        // Automatically create a random token
        /** @var array<int, string> $fields */
        $fields = Arr::map(AddressItemEnum::cases(), fn (AddressItemEnum $item): string => $item->value);
        $this->mergeFillable($fields);
    }

    /**
     * Ottiene gli indirizzi associati al modello.
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    /**
     * Ottiene indirizzo associato al modello.
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
        if (null === $res) {
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
        if (null !== $value) {
            return $value;
        }
        $address = sprintf(
            '%s, %s - %s, %s (%s)',
            $this->route,
            $this->street_number,
            $this->postal_code,
            $this->city,
            $this->province,
        );

        return trim(preg_replace('/[,\s]+/', ' ', $address));
    }

    public function getFullAddressesAttribute(?string $value): ?string
    {
        if ($value) {
            return $value;
        }
        $address = $this->address()->first();
        if (null === $address) {
            return null;
        }
        Assert::isInstanceOf($address, Address::class);

        $locality = $address->getLocality();
        if (null === $locality) {
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
        // Verifica che l'indirizzo appartenga a questo modello
        if ($address->model_id !== $this->id || $address->model_type !== static::class) {
            return false;
        }

        // Rimuovi il flag is_primary da tutti gli altri indirizzi
        $this->addresses()
            ->where('id', '!=', $address->id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);

        // Imposta questo indirizzo come principale
        return $address->update(['is_primary' => true]);
    }

    /**
     * Ottiene gli indirizzi di un determinato tipo.
     */
    public function getAddressesByType(string $type): Collection
    {
        return $this->addresses()->where('type', $type)->get();
    }

    /**
     * Aggiunge un nuovo indirizzo al modello.
     *
     * @param array<string, mixed> $data
     * @param bool                 $setPrimary Se impostare questo indirizzo come principale
     */
    public function addAddress(array $data, bool $setPrimary = false): Address
    {
        // Se è il primo indirizzo o è richiesto esplicitamente, impostalo come principale
        if ($setPrimary || 0 === $this->addresses()->count()) {
            $data['is_primary'] = true;

            // Rimuovi il flag is_primary da tutti gli altri indirizzi
            if ($this->addresses()->count() > 0) {
                $this->addresses()->update(['is_primary' => false]);
            }
        }

        /* @phpstan-ignore return.type */
        return $this->addresses()->create($data);
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
     */
    public function scopeInCity(Builder $query, string $city): Builder
    {
        return $query->whereHas('addresses', function ($q) use ($city): void {
            $q->where('locality', $city);
        });
    }

    /**
     * Scope per filtrare i modelli in base alla provincia dell'indirizzo.
     */
    public function scopeInProvince(Builder $query, string $province): Builder
    {
        return $query->whereHas('addresses', function ($q) use ($province): void {
            $q->where('administrative_area_level_3', $province);
        });
    }

    /**
     * Scope per filtrare i modelli in base alla regione dell'indirizzo.
     */
    public function scopeInRegion(Builder $query, string $region): Builder
    {
        return $query->whereHas('addresses', function ($q) use ($region): void {
            $q->where('administrative_area_level_2', $region);
        });
    }

    /**
     * Scope per filtrare i modelli in base al CAP dell'indirizzo.
     */
    public function scopeInPostalCode(Builder $query, string $postalCode): Builder
    {
        return $query->whereHas('addresses', function ($q) use ($postalCode): void {
            $q->where('postal_code', $postalCode);
        });
    }
}
