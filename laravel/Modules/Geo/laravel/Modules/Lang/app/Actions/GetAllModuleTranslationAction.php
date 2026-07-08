<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use function Safe\glob;

use Spatie\QueueableAction\QueueableAction;

class GetAllModuleTranslationAction
{
    use QueueableAction;

    /**
     * Restituisce il path completo del file di traduzione dato un key.
     *
     * @return array<int, array<string, mixed>>
     */
    public function execute(): array
    {
        $lang = session()->get('locale');
        if (is_string($lang) && in_array($lang, ['it', 'en'], strict: true)) {
            app()->setLocale($lang);
        }

        $lang = app()->getLocale();
        $path = base_path('Modules/*/lang/'.$lang.'/*.php');
        $files = glob($path);

        /** @var array<int, array<string, mixed>> $result */
        $result = Arr::map($files, function (string $file) {
            $fileStr = $file;
            $moduleLower = Str::of($fileStr)
                ->between('Modules/', '/lang/')
                ->lower()
                ->toString();

            return [
                'key' => $moduleLower.'::'.basename($fileStr, '.php'),
                'path' => $fileStr,
            ];
        });

        return $result;
    }
}
