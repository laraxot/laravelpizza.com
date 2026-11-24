<?php

declare(strict_types=1);

namespace Modules\Notify\Actions;

use Illuminate\Support\Facades\Log;
use Spatie\QueueableAction\QueueableAction;

use function Safe\preg_match;
use function Safe\preg_replace_callback;

/**
 * Sostituisce i segnaposto di un template di notifica letto dal database (DCP-283, C-08).
 *
 * Prima il testo passava per `Blade::render`: chi poteva modificare un template eseguiva PHP sul server
 * (`{{ system('id') }}`, `@php`). Qui si sostituiscono solo le espressioni `{{ ... }}` che sono un segnaposto, cioe'
 * un nome o un percorso con punti (`name`, `$name`, `user.address.city`), con la stessa escapatura di `{{ }}` di Blade.
 * Tutto il resto resta testo: altre espressioni, `{!! !!}`, direttive (`@php`, `@if`, `@include`, ...), tre graffe.
 * Stesso approccio di `HasBlocks::compile` (DCP-181): un costrutto in piu' si aggiunge a `PLACEHOLDER` con un test.
 */
final class RenderNotificationTemplateStringAction
{
    use QueueableAction;

    /** Nome o percorso con punti, `$` opzionale: niente chiamate, operatori, indici, `->`, virgolette. */
    private const string PLACEHOLDER = '/^\$?[A-Za-z_][A-Za-z0-9_]*(?:\.[A-Za-z0-9_]+)*$/';

    /**
     * @param  array<string, mixed>  $data
     */
    public function execute(string $template, array $data): string
    {
        $replace = fn (array $match): string => $this->substitute($match, $data);

        $rendered = preg_replace_callback('/\{\{\s*(.+?)\s*\}\}/s', $replace, $template);

        return is_string($rendered) ? $rendered : $template;
    }

    /**
     * @param  array<mixed>  $match  `[0]` testo con le graffe, `[1]` espressione interna
     * @param  array<string, mixed>  $data
     */
    private function substitute(array $match, array $data): string
    {
        $whole = $match[0] ?? null;
        $expression = $match[1] ?? null;
        if (! \is_string($whole) || ! \is_string($expression)) {
            return '';
        }

        if (preg_match(self::PLACEHOLDER, $expression) !== 1) {
            Log::warning('Espressione non ammessa in un template di notifica, lasciata come testo.', ['expression' => $expression]);

            return $whole;
        }

        $name = ltrim($expression, '$');
        $missing = new \stdClass;
        $value = data_get($data, $name, $missing);

        if ($value === $missing) {
            Log::warning('Variabile mancante in un template di notifica, resa vuota.', ['variable' => $name]);

            return '';
        }

        if ($value === null) {
            return '';
        }

        if (\is_scalar($value) || $value instanceof \Stringable) {
            return e((string) $value);
        }

        Log::warning('Variabile non stampabile in un template di notifica, resa vuota.', ['variable' => $name, 'type' => get_debug_type($value)]);

        return '';
    }
}
