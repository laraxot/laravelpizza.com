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
    /** @return MorphMany<Address, $this> */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model'); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function primaryAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('is_primary', true); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function homeAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::HOME->value); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function workAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::WORK->value); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function billingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::BILLING->value); // @phpstan-ignore return.type
    }

    /** @return MorphOne<Address, $this> */
    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::SHIPPING->value); // @phpstan-ignore return.type
    }

    /**
     * Imposta un indirizzo come principale.
     */
    public function setPrimaryAddress(Address $address): void
    {
        // Assicurati che l'indirizzo appartenga a questo modello
        if ($address->model_id !== $this->id || $address->model_type !== static::class) {
            throw new \InvalidArgumentException('L\'indirizzo non appartiene a questo modello.');
        }

        // Rimuovi lo stato primario da tutti gli altri indirizzi
        $this->addresses()->update(['is_primary' => false]);

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
            $this->addresses()->update(['is_primary' => false]);
        }

        // Crea il nuovo indirizzo
        $data['is_primary'] = $isPrimary;

        return $this->addresses()->create($data);
    }

    /** @return Collection<int, Address> */
    public function getAddressesByType(AddressTypeEnum|string $type): Collection
    {
        $typeValue = $type instanceof AddressTypeEnum ? $type->value : $type;

        return $this->addresses()->where('type', $typeValue)->get();
    }
}
