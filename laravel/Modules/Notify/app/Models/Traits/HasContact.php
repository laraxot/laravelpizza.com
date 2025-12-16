<?php

declare(strict_types=1);

namespace Modules\Notify\Models\Traits;

use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;
use Illuminate\Database\Eloquent\Builder;
use Modules\Notify\Enums\ContactTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
     *
     * @return void
     */
    protected function initializeHasContact()
    {
        // Automatically create a random token
        $fields=Arr::map(ContactTypeEnum::cases(), fn ($item) => $item->value);
        $this->mergeFillable($fields);
    }
}