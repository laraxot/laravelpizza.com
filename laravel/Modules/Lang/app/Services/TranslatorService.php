<?php

declare(strict_types=1);

/**
 * @see https://github.com/barryvdh/laravel-translation-manager/blob/master/src/Translator.php
 */

namespace Modules\Lang\Services;

use Illuminate\Events\Dispatcher;
use Illuminate\Translation\Translator as LaravelTranslator;
use Modules\Lang\Models\Translation;

class TranslatorService extends LaravelTranslator
{
    /** @var Dispatcher */
    protected $events;

    /**
     * Get the translation for the given key.
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

        return $result;
    }

    /*
     * public function setTranslationManager(Manager $manager)
     * {
     * $this->manager = $manager;
     * }
     */
    /**
     * Undocumented function.
     */
    protected function notifyMissingKey(string $key): void
    {
        $lang = app()->getLocale();
        [$namespace, $group, $item] = $this->parseKey($key);
        $data = [
            'lang' => $lang,
            'namespace' => $namespace,
            'group' => $group,
            'item' => $item,
        ];
        Translation::firstOrCreate($data);
    }
}
