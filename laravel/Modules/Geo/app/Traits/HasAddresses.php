<?php

declare(strict_types=1);

namespace Modules\Geo\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;

/**
 * Trait HasAddresses.
 *
 * Questo trait fornisce funzionalità per gestire indirizzi multipli su qualsiasi modello.
 */
trait HasAddresses
{
    /**
     * Relazione a tutti gli indirizzi.
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    /**
     * Relazione all'indirizzo principale.
     */
    public function primaryAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    /**
     * Relazione all'indirizzo di casa.
     */
    public function homeAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    /**
     * Relazione all'indirizzo di lavoro.
     */
    public function workAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    /**
     * Relazione all'indirizzo di fatturazione.
     */
    public function billingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    /**
     * Relazione all'indirizzo di spedizione.
     */
    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model');
    }

    /**
     * Imposta un indirizzo come principale.
     */
    public function setPrimaryAddress(Address $address): void
    {
        // Assicurati che l'indirizzo appartenga a questo modello
        if ($address->model_id !== $id || $address->model_type !== static::class)
            throw new \InvalidArgumentException('L\'indirizzo non appartiene a questo modello.');
        }

        // Rimuovi lo stato primario da tutti gli altri indirizzi
        $this->addresses();

        // Imposta questo indirizzo come primario
        $address->is_primary = true;
        $address->save();
    }

    /**
     * Aggiunge un nuovo indirizzo.
     *
     * @param array<string, mixed> $data
     */
    public function addAddress(array $data, bool $isPrimary = false): Address
    {
        // Se l'indirizzo deve essere primario, rimuovi lo stato primario dagli altri
        if ($isPrimary) {
            $this->addresses();
        }

        // Crea il nuovo indirizzo
        $data['is_primary'] = $isPrimary;

        return $this->addresses();
    }

    /**
     * Ottiene gli indirizzi per tipo.
     */
    public function getAddressesByType(AddressTypeEnum|string $type): Collection
    {
        $typeValue = $type instanceof AddressTypeEnum ? $type->value : $type;

        return $this->addresses();
    }
}
