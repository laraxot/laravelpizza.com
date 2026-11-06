<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

use function Safe\mb_chr;

/**
 * Etichette delle lingue (`🇮🇹 Italiano`) per i selettori: bandiera dal codice regionale e nome nativo
 * presi da `laravellocalization.supportedLocales`, l'elenco delle lingue note al progetto.
 */
class ListLocaleOptionsAction
{
    use QueueableAction;

    /**
     * @param  list<string>|null  $codes  lingue da elencare, nell'ordine dato; `null`: tutte le note
     * @return array<string, string> codice => etichetta
     */
    public function execute(?array $codes = null): array
    {
        $known = config('laravellocalization.supportedLocales');
        $known = is_array($known) ? $known : [];

        $options = [];
        foreach ($codes ?? array_map(strval(...), array_keys($known)) as $code) {
            $locale = $known[$code] ?? null;
            $locale = is_array($locale) ? $locale : [];
            $native = $locale['native'] ?? null;
            $regional = $locale['regional'] ?? null;

            $name = is_string($native) && $native !== '' ? Str::ucfirst($native) : $code;
            $options[$code] = trim($this->flag(is_string($regional) ? $regional : '').' '.$name);
        }

        return $options;
    }

    /**
     * `it_IT` => bandiera dell'Italia (coppia di indicatori regionali Unicode); vuoto se non c'e' paese.
     */
    private function flag(string $regional): string
    {
        $country = Str::after($regional, '_');
        if ($country === $regional || strlen($country) !== 2 || ! ctype_alpha($country)) {
            return '';
        }

        $flag = '';
        foreach (str_split(strtoupper($country)) as $letter) {
            $flag .= mb_chr(0x1F1E6 + ord($letter) - ord('A'), 'UTF-8');
        }

        return $flag;
    }
}
