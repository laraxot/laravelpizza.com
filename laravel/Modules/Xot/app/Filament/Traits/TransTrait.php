<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Webmozart\Assert\Assert;

trait TransTrait
{
    use TransFuncTrait;
    use TransKeyTrait;

    /**
     * Get translation for a given key.
     *
     * @param  array<string, bool|float|int|string|null>  $params
     *
     * @throws \Exception Se exceptionIfNotExist è true e la traduzione non esiste
     */
    public static function trans(string $key, bool $exceptionIfNotExist = false, array $params = []): string
    {
        $tmp = static::getKeyTrans($key);
        /** @var array<string, mixed>|Translator|string $res */
        $res = trans($tmp, $params);

        if (is_string($res)) {
            if ($exceptionIfNotExist && $res === $tmp) {
                throw new \Exception('['.__LINE__.']['.class_basename(self::class).']');
            }

            return $res;
        }

        if (is_array($res)) {
            $first = current($res);
            if (is_string($first) || is_numeric($first)) {
                return is_string($first) ? $first : ((string) $first);
            }
        }

        return 'fix:'.$tmp;
    }

    /**
     * Get translation key for a given class name.
     */
    public static function getKeyTransClass(string $class): string
    {
        /** @var array<int, string> $piece */
        $piece = Str::of($class)->explode('\\')->toArray();
        /** @var string $type */
        $type = $piece[2] ?? '';
        Assert::string($type, __FILE__.':'.__LINE__.' - '.class_basename(self::class));
        $module = Str::of($class)->between('Modules\\', '\\'.$type.'\\')->toString();

        $module_low = Str::of($module)->lower()->toString();

        $model_str = Str::of($class)->after('\\'.$type.'\\');
        $model = $model_str->contains('\\') ? $model_str->before('\\')->toString() : $model_str->toString();
        $model_snake = Str::of($model)->snake()->toString();

        return $module_low.'::'.$model_snake;
    }

    /**
     * Get translation for a given class name.
     */
    public static function transClass(string $class, string $key): string
    {
        $class_key = static::getKeyTransClass($class);
        $key_full = $class_key.'.'.$key;
        /** @var array<string, mixed>|Translator|string $result */
        $result = trans($key_full);

        if ($key_full === $result) {
            $group = Str::of($key_full)->before('.')->toString();
            $item = Str::of($key_full)->after($group.'.')->toString();
            /** @var array<string, mixed>|Translator|string $group_arr */
            $group_arr = trans($group);
            if (is_array($group_arr)) {
                $transValue = Arr::get($group_arr, $item);
                if (is_string($transValue) || is_numeric($transValue)) {
                    return is_string($transValue) ? $transValue : (string) $transValue;
                }
            }

            return 'fix:'.$key_full;
        }

        return is_string($result) ? $result : 'fix:'.$key_full;
    }

    /**
     * Ottiene la chiave di traduzione per un dato key.
     * Genera un percorso di traduzione standardizzato basato sul modulo e sul nome della classe.
     *
     * @param  string  $key  La chiave di traduzione specifica
     * @param  array<string, bool|float|int|string|null>  $replace  Parametri di sostituzione per la traduzione
     * @param  string|null  $locale  Locale da utilizzare (null = locale corrente)
     * @param  bool  $useFallback  Se true, utilizza la chiave come fallback se la traduzione non esiste
     * @return string La stringa tradotta o la chiave originale se non trovata
     */
    public static function getTranslatedString(
        string $key,
        array $replace = [],
        ?string $locale = null,
        bool $useFallback = true,
    ): string {
        $moduleName = static::getModuleName();
        $moduleNameLow = Str::lower($moduleName);
        $p = Str::after(static::class, 'Filament\\Pages\\');
        $p_arr = explode('\\', $p);
        $slug = collect($p_arr)->map(Str::kebab(...))->implode('.');

        $translationKey = $moduleNameLow.'::'.$slug.'.'.$key;
        $translation = __($translationKey, $replace, $locale);

        if ($translation === $translationKey && App::environment('local', 'development', 'testing')) {
            Log::warning("Traduzione mancante: {$translationKey}");

            return $useFallback ? $key : $translationKey;
        }

        if (! is_string($translation)) {
            return $useFallback ? $key : $translationKey;
        }

        return $translation;
    }

    /**
     * Ottiene la chiave di traduzione per un dato key (alias per getTranslatedString).
     * Genera un percorso di traduzione standardizzato basato sul modulo e sul nome della classe.
     *
     * @param  string  $key  La chiave di traduzione specifica
     * @param  array<string, bool|float|int|string|null>  $replace  Parametri di sostituzione per la traduzione
     * @param  string|null  $locale  Locale da utilizzare (null = locale corrente)
     * @param  bool  $useFallback  Se true, utilizza la chiave come fallback se la traduzione non esiste
     * @return string La stringa tradotta o la chiave originale se non trovata
     */
    public static function transOLD(
        string $key,
        array $replace = [],
        ?string $locale = null,
        bool $useFallback = true,
    ): string {
        return static::getTranslatedString($key, $replace, $locale, $useFallback);
    }

    /**
     * Ottiene il nome del modulo dalla classe.
     * Estrae il nome del modulo dal namespace della classe.
     *
     * @return string Il nome del modulo (es. '<main module>', 'User', ecc.)
     */
    public static function getModuleName(): string
    {
        $namespace = static::class;
        $moduleName = Str::between($namespace, 'Modules\\', '\\Filament');

        if ($moduleName === '') {
            throw new \LogicException(sprintf('Cannot extract module name from class %s', static::class));
        }

        return $moduleName;
    }

    /**
     * Get a translation according to an integer value.
     *
     * @param  array<string, bool|float|int|string|null>  $replace
     */
    protected function transChoice(string $key, int $number, array $replace = []): string
    {
        /** @var string $result */
        $result = trans_choice($key, $number, $replace);

        return is_string($result) ? $result : $key;
    }
}
