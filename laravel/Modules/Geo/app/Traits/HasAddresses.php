<?php

declare(strict_types=1);

namespace Modules\Geo\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Webmozart\Assert\Assert;

/**
 * Trait HasAddresses.
 *
 * Questo trait fornisce funzionalità per gestire indirizzi multipli su qualsiasi modello.
 *
 * @property MorphMany<Address, $this> $addresses
 * @property MorphOne<Address, $this>  $primaryAddress
 * @property MorphOne<Address, $this>  $homeAddress
 * @property MorphOne<Address, $this>  $workAddress
 * @property MorphOne<Address, $this>  $billingAddress
 * @property MorphOne<Address, $this>  $shippingAddress
 */
trait HasAddresses
{
    /**
     * Relazione a tutti gli indirizzi.
     *
     * @return MorphMany<Address, $this>
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'model');
    }

    /**
     * Relazione all'indirizzo principale.
     *
     * @return MorphOne<Address, $this>
     */
    public function primaryAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('is_primary', true);
    }

    /**
     * Relazione all'indirizzo di casa.
     *
     * @return MorphOne<Address, $this>
     */
    public function homeAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::HOME->value);
    }

    /**
     * Relazione all'indirizzo di lavoro.
     *
     * @return MorphOne<Address, $this>
     */
    public function workAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::WORK->value);
    }

    /**
     * Relazione all'indirizzo di fatturazione.
     *
     * @return MorphOne<Address, $this>
     */
    public function billingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::BILLING->value);
    }

    /**
     * Relazione all'indirizzo di spedizione.
     *
     * @return MorphOne<Address, $this>
     */
    public function shippingAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'model')->where('type', AddressTypeEnum::SHIPPING->value);
    }

    /**
     * Imposta un indirizzo come principale.
     */
    public function setPrimaryAddress(Address $address): void
    {
        if ($address->model_id !== $this->id || $address->model_type !== static::class) {
            throw new \InvalidArgumentException('L\'indirizzo non appartiene a questo modello.');
        }

        $this->addresses()->update(['is_primary' => false]);

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
        if ($isPrimary) {
            $this->addresses()->update(['is_primary' => false]);
        }

        $payload = array_merge($data, ['is_primary' => $isPrimary]);

        $address = $this->addresses()->create($payload);
        Assert::isInstanceOf($address, Address::class);

        return $address;
    }

    /**
     * Ottiene gli indirizzi per tipo.
     *
     * @return Collection<int, Address>
     */
    public function getAddressesByType(AddressTypeEnum|string $type): Collection
    {
        $typeValue = $type instanceof AddressTypeEnum ? $type->value : $type;

        return $this->addresses()->where('type', $typeValue)->get();
    }
}
