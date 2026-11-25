<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Traits;

use Illuminate\Support\Str;
use Modules\Xot\Actions\GetTransKeyAction;

/**
 * Translation key resolver — no trans()/transFunc() to avoid trait collisions in table pages.
 */
trait TransKeyTrait
{
    public static function getKeyTrans(string $key): string
    {
        /** @var string $transKey */
        $transKey = app(GetTransKeyAction::class)->execute(static::class);

        $key = $transKey.'.'.$key;
        $key = Str::of($key)->replace('.cluster.pages.', '.')->toString();
        if (Str::startsWith($key, 'edit_')) {
            $key = Str::after($key, 'edit_');
        }
        if (Str::endsWith($key, '_widget')) {
            $key = Str::beforeLast($key, '_widget');
        }

        return $key;
    }
}
