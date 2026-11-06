<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Xot\Actions\GetTransKeyAction;

/**
 * Subset of TransTrait for navigation labels — avoids trans() collisions when composed with HasXotTable.
 */
trait TransFuncTrait
{
    public static function getKeyTransFunc(string $func): string
    {
        $key = Str::of($func)
            ->after('get')
            ->snake()
            ->replace('_', '.')
            ->toString();
        /** @var string $transKey */
        $transKey = app(GetTransKeyAction::class)->execute(static::class);

        $key = $transKey.'.'.$key;
        $key = Str::of($key)->replace('.cluster.pages.', '.')->toString();
        $key = Str::of($key)->replace('::edit_', '::')->toString();

        return $key;
    }

    public static function transFunc(string $func): string
    {
        $key = static::getKeyTransFunc($func);
        $trans = static::resolveTransFuncValue($key);

        return static::formatTransFuncResult($key, $trans);
    }

    /**
     * @return string|array<int|string, mixed>|Translator|null
     */
    protected static function resolveTransFuncValue(string $key): string|array|Translator|null
    {
        try {
            /** @var array<string, mixed>|Translator|string $trans */
            $trans = trans($key);
        } catch (\TypeError $e) {
            /*
            dddx([
                'e' => $e,
                'key' => $key,
            ]);
            */
            return 'fix:'.$key;

            // return null;
        }

        if ($key !== $trans) {
            return $trans;
        }

        $group = Str::of($key)->before('.')->toString();
        $item = Str::of($key)->after($group.'.')->toString();
        /** @var array<string, mixed>|Translator|string $group_arr */
        $group_arr = trans($group);
        if (! is_array($group_arr)) {
            return $trans;
        }

        $transValue = Arr::get($group_arr, $item);
        if (is_string($transValue) || is_numeric($transValue)) {
            return is_string($transValue) ? $transValue : (string) $transValue;
        }

        if (is_array($transValue)) {
            return $transValue;
        }

        return $trans;
    }

    /**
     * @param  string|array<int|string, mixed>|Translator|null  $trans
     */
    protected static function formatTransFuncResult(string $key, string|array|Translator|null $trans): string
    {
        if (is_numeric($trans)) {
            return strval($trans);
        }

        if (is_array($trans)) {
            $first = current($trans);
            if (is_string($first) || is_numeric($first)) {
                return is_string($first) ? $first : ((string) $first);
            }
        }

        if (is_string($trans)) {
            if ($trans === $key) {
                return static::persistGeneratedTransFuncLabel($key);
            }

            return $trans;
        }

        if ($trans === null) {
            return static::persistGeneratedTransFuncLabel($key);
        }

        return 'fix:'.$key;
    }

    protected static function persistGeneratedTransFuncLabel(string $key): string
    {
        $newTrans = Str::of($key)
            ->between('::', '.')
            ->replace('_', ' ')
            ->toString();
        app(SaveTransAction::class)->execute($key, $newTrans);

        return $newTrans;
    }
}
