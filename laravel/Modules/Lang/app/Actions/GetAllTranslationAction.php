<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use Illuminate\Support\Str;

use function Safe\glob;

use Spatie\QueueableAction\QueueableAction;

class GetAllTranslationAction
{
    use QueueableAction;

    /**
     * Restituisce il path completo del file di traduzione dato un key.
     *
     * @return list<array{key: string, path: string}>
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

        $result = [];
        foreach ($files as $file) {
            if (! is_string($file)) {
                continue;
            }

            $moduleLower = Str::of($file)
                ->between('Modules/', '/lang/')
                ->lower()
                ->toString();

            $result[] = [
                'key' => $moduleLower.'::'.basename($file, '.php'),
                'path' => $file,
            ];
        }

        return $result;
    }
}
