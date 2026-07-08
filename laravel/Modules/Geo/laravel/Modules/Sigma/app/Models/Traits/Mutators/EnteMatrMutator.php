<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Traits\Mutators;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Modules\Sigma\Models\Ana10f;
use Modules\Sigma\Models\Codici;

/**
 * Trait EnteMatrMutator.
 *
 * @property-read int|null $emaind
 * @property-read string|null $sesso
 * @property-read string|null $codfis
 * @property-read string|null $inail
 * @property-read string|null $st2kas
 */
trait EnteMatrMutator
{
    protected function getEnteAttribute(?int $value): ?int
    {
        if ($value !== null) {
            return $value;
        }
        $value = 90;
        if (\in_array('ente', $this->getFillable(), false)) {
            $this->ente = $value;

            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['ente' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getCognomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $anag = $this->ana10f;
        if (! \is_object($anag)) {
            return '---';
        }

        // $anag è già verificato come oggetto sopra, non può essere null
        $value = $anag->getAttribute('cognome');

        if ($this->getKey() != null) {
            static::withoutEvents(function () use ($value): void {
                $this->update(['cognome' => $value]);
            });
        }

        return (string) ($value ?? '').' ';
    }

    protected function getEmailAttribute(?string $value): ?string
    {
        if ($value != null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('emaind !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{emaind: string|null} $ana02f */
        $value = $ana02f->emaind;
        if (\in_array('email', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['email' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getSessoAttribute(?string $value): ?string
    {
        if ($value != null) {
            return Str::of($value)->lower()->toString();
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('sesso !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{sesso: string|null} $ana02f */
        $value = Str::of((string) $ana02f->sesso)->lower()->toString();
        if (\in_array('sesso', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['sesso' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getCodiceFiscaleAttribute(?string $value): ?string
    {
        if ($value != null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('codfis !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{codfis: string|null} $ana02f */
        $value = $ana02f->codfis;
        if (\in_array('codfis', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['codfis' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getInailAttribute(?string $value): ?string
    {
        if ($value != null) {
            return $value;
        }
        if ($this->matr == null) {
            return null;
        }

        $ana02f = $this->ana02f()
            ->whereRaw('inail !="" ')
            ->orderBy('datdec', 'desc')
            ->first();
        if ($ana02f === null) {
            return null;
        }

        /** @var object{inail: string|null} $ana02f */
        $value = $ana02f->inail;
        if (\in_array('inail', $this->getFillable(), false)) {
            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['inail' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getNomeAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $anag = $this->ana10f;
        if (! ($anag instanceof Ana10f)) {
            return '---';
        }

        $value = $anag->nome ?? null;
        if ($value === null) {
            return '---';
        }
        if (\in_array('nome', $this->getFillable(), false)) {
            $this->nome = $value;

            if ($this->getKey() != null) {
                static::withoutEvents(function () use ($value): void {
                    $this->update(['nome' => $value]);
                });
            }
        }

        return $value;
    }

    protected function getTitoloDiStudioAttribute(?string $value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        $ana02f = $this->ana02f->last();
        if (! \is_object($ana02f)) {
            return null;
        }

        $row = Codici::where('tipo', 10)->where('codice', $ana02f->getAttribute('titstu'))->first();
        if (! \is_object($row)) {
            return null;
        }

        $value = $row->desc1;
        $fieldname = 'titolo_di_studio';

        if (! Schema::connection($this->getConnectionName())->hasColumn($this->getTable(), $fieldname)) {
            Schema::connection($this->getConnectionName())->table($this->getTable(), static function (Blueprint $table) use (
                $fieldname,
            ): void {
                $table->string($fieldname);
            });
        }

        if ($this->getKey() != null) {
            static::withoutEvents(function () use ($fieldname, $value): void {
                $this->update([$fieldname => $value]);
            });
        }

        return $value;
    }

    /**
     * Get last_data_assunz attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Persisto AUTOMATICAMENTE con ActivityLog-Safe
     */
    protected function getLastDataAssunzAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_string($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        $value = $this->calculateLastDataAssunz();

        // ✅ Livello 4: Persisto AUTOMATICAMENTE con ActivityLog-Safe
        if ($this->getKey() != null) {
            static::withoutEvents(function () use ($value): void {
                tap($this)->update(['last_data_assunz' => $value]);
            });
        }

        return $value;
    }

    /**
     * Calcola last_data_assunz.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateLastDataAssunz(): ?string
    {
        $row = $this->sto00f()->orderBy('st2kas', 'desc')->first();

        if (! \is_object($row)) {
            return null;
        }

        /** @var object{st2kas: string|int|null} $row */
        $value = $row->st2kas;

        return $value === null ? null : (string) $value;
    }
}
