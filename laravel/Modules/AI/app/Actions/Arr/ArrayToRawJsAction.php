<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Arr;

use Filament\Support\RawJs;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match;

/**
 * Converte un array PHP in RawJs (oggetto JavaScript) sicuro per attributi HTML.
 *
 * Usa virgolette singole per stringhe e chiavi non-identificatore, così l'output
 * può essere usato dentro x-data="..." senza spezzare l'attributo.
 * I valori RawJs vengono emessi raw (es. formatter function per Chart.js).
 *
 * @see docs/contracts/array-to-raw-js-action.md
 *
 * @contract docs/contracts/array-to-raw-js-action.md
 */
class ArrayToRawJsAction
{
    use QueueableAction;

    /**
     * Converte l'array in una stringa JavaScript (oggetto letterale) e restituisce RawJs.
     *
     * @param  array<int|string, mixed>  $array  Array associativo (anche annidato); valori RawJs restano raw
     */
    public function execute(array $array): RawJs
    {
        $parts = [];
        foreach ($array as $key => $value) {
            $k = $this->jsKey((string) $key);
            if ($value instanceof RawJs) {
                $parts[] = $k.': '.$this->rawJsExpression($value);
            } elseif (is_array($value)) {
                /** @var array<int|string, mixed> $value */
                $parts[] = $k.': '.$this->rawJsExpression($this->execute($value));
            } else {
                $parts[] = $k.': '.$this->jsValue($value);
            }
        }

        return RawJs::make('{'.implode(', ', $parts).'}');
    }

    /**
     * Espressione JS grezza da un RawJs.
     *
     * RawJs estende Illuminate\Support\Js (Htmlable + Stringable): il contenuto
     * vive in `protected $js` ed e' esposto da __toString()/toHtml(). Si usa il
     * cast a string (contratto Stringable) cosi' PHPStan non dipende dalla
     * visibilita' ereditata di toHtml() sul sottotipo Filament.
     */
    private function rawJsExpression(RawJs $raw): string
    {
        return (string) $raw;
    }

    /** Chiave JS sicura per attributo HTML: identificatore o 'key'. */
    private function jsKey(string $key): string
    {
        return preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key) ? $key : "'".str_replace("'", "\\'", $key)."'";
    }

    /** Valore JS sicuro per attributo HTML: niente virgolette doppie. */
    private function jsValue(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_null($value)) {
            return 'null';
        }
        if (is_numeric($value)) {
            return (string) $value;
        }

        return "'".str_replace(['\\', "'"], ['\\\\', "\\'"], SafeStringCastAction::cast($value))."'";
    }
}
