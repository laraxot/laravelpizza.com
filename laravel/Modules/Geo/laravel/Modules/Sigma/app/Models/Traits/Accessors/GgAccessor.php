<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Accessors;

/**
 * GgAccessor - Accessor per campi gg_* (giorni).
 *
 * @phpstan-ignore trait.unused
 */
trait GgAccessor
{
    protected function getGgAttribute(?int $_value): ?int
    {
        // Guard: dipendenze devono esistere
        if ($this->getKey() == null) {
            return null;
        }

        if ($this->matr == null) {
            return null;
        }
        if ($this->qua2kd == null) {
            return null;
        }

        if ($this->matr == 201661) {
            dddx([
                'gg_in_sede' => $this->gg_in_sede,
                'gg_fuori_sede' => $this->gg_fuori_sede,
            ]);
        }

        // Delega calcolo al metodo helper puro
        $value = $this->getGg();

        // Persist con update chirurgico (salva SOLO questo campo, previene loop)
        $this->update(['gg' => $value]);

        return $value;
    }
}
