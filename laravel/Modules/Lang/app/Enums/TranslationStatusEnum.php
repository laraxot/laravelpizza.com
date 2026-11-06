<?php

declare(strict_types=1);

namespace Modules\Lang\Enums;

/**
 * Stato di sincronizzazione di una riga `Translation` rispetto ai file di lingua
 * (vocabolario ereditato da barryvdh/laravel-translation-manager).
 *
 * Sostituisce le costanti `Translation::STATUS_SAVED` / `Translation::STATUS_CHANGED`.
 * Nota: la tabella `translations` non ha (ancora) una colonna `status`, quindi il modello
 * non dichiara il cast; aggiungerlo in `casts()` insieme alla migration della colonna.
 */
enum TranslationStatusEnum: int
{
    /** La riga coincide con il file di lingua. */
    case SAVED = 0;

    /** La riga e' stata modificata e non ancora pubblicata nel file di lingua. */
    case CHANGED = 1;
}
