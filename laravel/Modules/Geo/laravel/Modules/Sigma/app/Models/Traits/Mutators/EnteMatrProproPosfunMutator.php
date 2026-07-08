<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

/**
 * @phpstan-ignore trait.unused
 */
trait EnteMatrProproPosfunMutator
{
    protected function getCategoriaEcoAttribute(?string $value)
    {
        if ($value !== null) {
            return $value;
        }

        /*-- forse mettere se esiste il metodo
         * if (! is_object($this->qua00f)) {
         * return null;
         * }
         */
        $qua00f = $this->qua00f()
            ->where('propro', $this->propro)
            ->where('posfun', $this->posfun)
            ->where('qua2kd', $this->qua2kd)
            ->first();
        if (! \is_object($qua00f)) {
            return null;
        }

        $tqu00f = $qua00f->tqu00f;
        $categoria_eco = $tqu00f->desc1;
        $categoria_eco = str_replace('Posizione economica ', '', (string) $categoria_eco);
        $this->categoria_eco = $categoria_eco;

        if ($this->getKey() !== null) {
            $this->update([
                'categoria_eco' => $categoria_eco,
            ]);
        }

        return $this->attributes['categoria_eco'];
    }
}
