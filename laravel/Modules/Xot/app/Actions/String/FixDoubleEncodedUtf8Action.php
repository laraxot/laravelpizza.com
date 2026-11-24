<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\String;

use Spatie\QueueableAction\QueueableAction;

use function Safe\mb_convert_encoding;

/**
 * Ripara il testo UTF-8 codificato due volte: «SÃ¬» torna «Sì».
 *
 * Succede quando un dump UTF-8 viene importato come `latin1`, che in MySQL e'
 * Windows-1252: ogni byte diventa un carattere, e il testo arriva corretto in
 * apparenza ma con i caratteri sbagliati. Trovato nei backup locali del
 * 2026-10-23 (story `docs/stories/fix-double-encoded-utf8-action.story.md`).
 *
 * ## Perche' non tocca il testo pulito
 *
 * Il testo si riporta ai byte Windows-1252 e si accetta il risultato solo se il
 * passaggio non perde niente **e** i byte ottenuti sono UTF-8 valido. Un testo
 * pulito non passa: «Città» diventa il byte `E0` da solo, che non e' UTF-8; un
 * carattere che Windows-1252 non ha, come un'emoji, si perde nel passaggio. Su
 * dati puliti l'Action non cambia niente.
 *
 * ## Perche' Windows-1252 e non ISO-8859-1
 *
 * L'apostrofo tipografico rovinato e' `â€™`: `€` e `™` esistono solo in
 * Windows-1252, e con ISO-8859-1 il testo resterebbe rovinato.
 */
class FixDoubleEncodedUtf8Action
{
    use QueueableAction;

    private const string WRONG_CHARSET = 'Windows-1252';

    public function execute(string $text): string
    {
        if (! mb_check_encoding($text, 'UTF-8') || mb_check_encoding($text, 'ASCII')) {
            return $text;
        }

        $bytes = mb_convert_encoding($text, self::WRONG_CHARSET, 'UTF-8');
        if (! \is_string($bytes) || ! mb_check_encoding($bytes, 'UTF-8')) {
            return $text;
        }

        $roundTrip = mb_convert_encoding($bytes, 'UTF-8', self::WRONG_CHARSET);

        return $roundTrip === $text ? $bytes : $text;
    }
}
