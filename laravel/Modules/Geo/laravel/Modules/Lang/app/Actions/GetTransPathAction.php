<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Str;
use Modules\Xot\Actions\Module\GetModulePathByGeneratorAction;
use Spatie\QueueableAction\QueueableAction;

class GetTransPathAction
{
    use QueueableAction;

    /**
     * Restituisce il path completo del file di traduzione dato un key.
     */
    public function execute(string $key): string
    {
        $ns = Str::of($key)->before('::')->toString();
        $item = Str::of($key)->after('::')->toString();
        $piece = explode('.', $item);
        $lang = app()->getLocale();
        try {
            $langPath = app(GetModulePathByGeneratorAction::class)->execute($ns, 'lang');
        } catch (\Throwable $e) {
            $langPath = base_path('Modules/'.$ns.'/lang');
        }
        $fileName = $piece[0] ?? '';

        return $langPath.'/'.$lang.'/'.$fileName.'.php';
    }
}
