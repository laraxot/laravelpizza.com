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
<<<<<<< HEAD
        // Get without fallback
        $result = parent::get($key, $replace, $locale, $fallback);
        if ($result === $key) {
            $this->notifyMissingKey($key);

            // Reget with fallback
            $result = parent::get($key, $replace, $locale, $fallback);
=======
        $result = parent::get($key, $replace, $locale, $fallback);

        if ($result === $key) {
            $this->notifyMissingKey($key);

            // Qui c'era una seconda `parent::get()` con gli **stessi** argomenti,
            // commentata «Reget with fallback» — ma `$fallback` non cambiava, e
            // una funzione pura chiamata due volte con gli stessi argomenti da'
            // due volte lo stesso risultato. Il ritentativo non e' mai
            // avvenuto: l'unico effetto era rifare il lavoro. Togliere la
            // chiamata non cambia niente, ed e' il punto.
            //
            // Il ritentativo **voluto** — cercare senza fallback, registrare
            // l'assenza, poi cercare con fallback — e' un'altra cosa, e cambia
            // cio' che l'utente vede: oggi una chiave presente solo nella lingua
            // di ripiego mostra il testo di ripiego alla prima chiamata e non
            // viene mai registrata come mancante. Farlo per davvero significa
            // registrare molte piu' chiavi e, in locale, scriverne i file.
            // La scelta sta in base_quaeris_fila5#236.
>>>>>>> laraxot/dev
        }

        if (is_array($result)) {
            return $result;
        }

<<<<<<< HEAD
        if (! is_string($result)) {
            return (string) $key;
        }

        return $result;
=======
        if (is_string($result)) {
            return $result;
        }

        // Un numero dentro una traduzione **JSON** e' un valore, non un errore:
        // si rende «99», non la chiave.
        //
        // Vale solo per le traduzioni JSON, e non e' una scelta di questo
        // adattatore: per le chiavi di **gruppo** (`messages.num`) e' Laravel a
        // scartare i valori non-stringa dentro `Translator::getLine()`, che
        // rende solo stringhe e array e per tutto il resto restituisce null —
        // quindi un `'num' => 7` in un file di gruppo non arriva nemmeno fino a
        // qui, e la chiave torna da `parent::get()`. Nel caso JSON il valore
        // passa da `makeReplacements()`, che senza sostituzioni lo restituisce
        // com'e', intero compreso.
        //
        // L'asimmetria e' di Laravel; qui si gestisce solo la parte che arriva
        // (base_quaeris_fila5#234).
        if (is_scalar($result)) {
            return (string) $result;
        }

        // `null`, un oggetto, una risorsa: non c'e' niente da mostrare, e la
        // chiave almeno dice al traduttore cosa cercare.
        return (string) $key;
>>>>>>> laraxot/dev
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
