<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Illuminate\Database\Eloquent\Model;

/**
 * Record padre per le prove di `AddressField`.
 *
 * Costruisce il figlio in memoria e restituisce sempre `true` da `touch()`: il test
 * riguarda il comportamento del componente, non la persistenza.
 */
final class UiCoverageAddressParentRecord extends Model
{
    protected $guarded = [];

    public UiCoverageAddressChildRecord $addressModel;

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->addressModel = new UiCoverageAddressChildRecord(['id' => 1]);
    }

    /**
     * @param  string|array<int, string>|null  $attribute
     */
    public function touch($attribute = null): bool
    {
        return true;
    }

    /**
     * @return UiCoverageAddressHasOneRelation<$this>
     */
    public function address(): UiCoverageAddressHasOneRelation
    {
        return new UiCoverageAddressHasOneRelation($this);
    }
}
