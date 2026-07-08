<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Modules\Sigma\Models\Rep00f;

trait EnteStabiMutator
{
    /**
     * Calcola lo stabi.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function getStabi(): ?int
    {
        $rep00f = Rep00f::where('ente', $this->ente)
            ->where('matr', $this->matr)
            ->whereRaw('repann=""')
            ->ofYear($this->anno ?? 0)
            ->latest('rep2kd')
            ->first();

        $value = $rep00f?->repst1;
        if ($value == 0 && $rep00f?->repst2 != 0) {
            $value = $rep00f->repst2;
        }

        return $value;
    }

    protected function getStabiAttribute(?int $value): ?int
    {
        if (($value !== null && $value != 0) || $this->getKey() === null) {
            return $value;
        }

        $value = $this->getStabi();
        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        static::withoutEvents(function () use ($value): void {
            $this->update(['stabi' => $value]);
        });

        return $value;
    }

    protected function getRepar(): ?int
    {
        $rep00f = Rep00f::where('ente', $this->ente)
            ->where('matr', $this->matr)
            ->whereRaw('repann=""')
            ->ofYear($this->anno ?? 0)
            ->latest('rep2kd')
            ->first();

        $value = $rep00f?->repre1;
        if ($value == 0 && $rep00f?->repre2 != 0) {
            $value = $rep00f->repre2;
        }

        return $value;
    }

    protected function getReparAttribute(?int $value): ?int
    {
        if (($value !== null && $value != 0) || $this->getKey() === null) {
            return $value;
        }

        $value = $this->getRepar();
        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        static::withoutEvents(function () use ($value): void {
            $this->update(['repar' => $value]);
        });

        return $value;
    }

    protected function getStabiTxtAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $stabi = $this->reparts->where('repar', 0)->first();
        if (! \is_object($stabi)) {
            return '---';
        }

        $value = $stabi->dest1;

        if ($this->getKey() !== null) {
            $this->update(['stabi_txt' => $value]);
        }

        return $value;
    }

    protected function getReparTxtAttribute(?string $value): ?string
    {
        if ($value !== null && $value !== '---') {
            return $value;
        }

        if (! \is_object($this->reparts)) {
            dddx($this);
        }

        // reprep1 può essere una proprietà dinamica da anag o da attributi
        $repar = isset($this->repre1) && is_numeric($this->repre1) ? (int) $this->repre1 : null;
        if ($repar === null) {
            $repar = $this->repar;
        }

        $repar = $this->reparts->where('repar', $repar)->first();
        if (! \is_object($repar)) {
            return '---';
        }

        $value = $repar->dest1;
        if ($this->getKey() !== null) {
            $this->update(['repar_txt' => $value]);
        }

        return $value;
    }
}
