<?php

declare(strict_types=1);

namespace Modules\Pdnd\Services\Anpr\Shared\Traits;

use function Safe\json_encode;

trait HasArrayConversion
{
    /**
     * Converte l'oggetto in array rimuovendo valori null
     */
    public function toArrayClean(): array
    {
        return array_filter($this->toArray(), fn ($value) => $value !== null);
    }

    /**
     * Converte l'oggetto in JSON
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Converte l'oggetto in JSON pulito (senza null)
     */
    public function toJsonClean(): string
    {
        return json_encode($this->toArrayClean(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
