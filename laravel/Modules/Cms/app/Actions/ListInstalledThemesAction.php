<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * Temi installabili: le cartelle di `Themes/` che hanno `resources/views`.
 *
 * `Themes/public` e i file sciolti non sono temi. Serve alla SettingPage di Cms: un tema si
 * sceglie tra quelli che esistono, perche' un nome inventato farebbe fallire il boot.
 */
final class ListInstalledThemesAction
{
    use QueueableAction;

    /**
     * @return array<string, string> nome => nome
     */
    public function execute(): array
    {
        $root = base_path('Themes');
        if (! File::isDirectory($root)) {
            return [];
        }

        $themes = [];
        foreach (File::directories($root) as $directory) {
            if (! is_string($directory)) {
                continue;
            }

            if (! File::isDirectory($directory.'/resources/views')) {
                continue;
            }
            $name = basename($directory);
            $themes[$name] = $name;
        }

        return $themes;
    }
}
