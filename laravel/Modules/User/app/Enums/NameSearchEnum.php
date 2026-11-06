<?php

declare(strict_types=1);

namespace Modules\User\Enums;

use Illuminate\Support\Stringable;

/**
 * Quale porzione di un nome completo ("Mario Rossi", "mario.rossi@...") estrarre.
 *
 * Il valore backed coincide con il metodo Stringable usato storicamente
 * (`before`/`after`), ma l'enum rende lo stato non valido irrappresentabile:
 * niente chiamate dinamiche `->$metodo()` ne' validazioni a runtime.
 */
enum NameSearchEnum: string
{
    /** Parte che precede il separatore (nome). */
    case Name = 'before';

    /** Parte che segue il separatore (cognome). */
    case Surname = 'after';

    public function applyTo(Stringable $value, string $separator): Stringable
    {
        return match ($this) {
            self::Name => $value->before($separator),
            self::Surname => $value->after($separator),
        };
    }
}
