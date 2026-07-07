<?php

declare(strict_types=1);

namespace Modules\Notify\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use Modules\Notify\Enums\ContactTypeEnum;

/**
 * Trait HasContact.
 *
 * Fornisce funzionalità per la gestione degli indirizzi nei modelli Eloquent.
 * Questo trait implementa la relazione polimorfica con il modello Address
 * e offre metodi di utilità per la gestione degli indirizzi.
 *
 * @property Collection<int, Address> $addresses
 */
trait HasContact
{
    /**
     * Initialize the trait
     */
    protected function initializeHasContact(): void
    {
        /** @var array<string> $fields */
        $fields = array_values(array_map(
            fn (ContactTypeEnum $item): string => $item->value,
            ContactTypeEnum::cases(),
        ));
        $this->mergeFillable($fields);
    }
}
