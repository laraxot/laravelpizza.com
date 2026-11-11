<?php

declare(strict_types=1);
/**
 * @see https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Translator.php
 */

namespace Modules\Lang\Adapters;

use Illuminate\Events\Dispatcher;
use Illuminate\Translation\Translator as LaravelTranslator;
use Modules\Lang\Actions\Translation\RecordMissingTranslationAction;

/**
 * Translator Laravel esteso: registra chiavi mancanti nel DB delegando
 * la business logic a RecordMissingTranslationAction.
 *
 * Eccezione architetturale: estende Illuminate\Translator (non è una
 * QueueableAction di dominio) ed è bindato come singleton `translator`.
 */
class TranslatorAdapter extends LaravelTranslator
{
    protected Dispatcher $events;

    /**
     * Get the translation for the given key.
     *
     * I parametri nativi restano `mixed` per compatibilita' LSP con
     * `Illuminate\Translation\Translator::get()`, che non dichiara tipi.
     *
     * @param  array<string, mixed>  $replace
     * @param  string  $key
     * @param  string|null  $locale
     * @param  bool  $fallback
     * @return string|array<array-key, mixed>
     */
    public function get(mixed $key, array $replace = [], mixed $locale = null, mixed $fallback = true): string|array
    {
        // Get without fallback
        $result = parent::get($key, $replace, $locale, $fallback);
        if ($result === $key) {
            $this->notifyMissingKey($key);

            // Reget with fallback
            $result = parent::get($key, $replace, $locale, $fallback);
        }

        if (is_array($result)) {
            return $result;
        }

        if (! is_string($result)) {
            return (string) $key;
        }

        return $result;
    }

    /*
     * public function setTranslationManager(Manager $manager)
     * {
     * $this->manager = $manager;
     * }
     */
    /**
     * Record missing translation key.
     */
    protected function notifyMissingKey(string $key): void
    {
        app(RecordMissingTranslationAction::class)->execute($key, (string) app()->getLocale());
    }
}
