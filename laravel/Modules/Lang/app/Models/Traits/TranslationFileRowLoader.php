<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Modules\Lang\Actions\GetAllTranslationAction;
use Modules\Lang\Models\TranslationFile;

use function Safe\json_encode;

/**
 * Caricamento delle righe Sushi per {@see TranslationFile}.
 *
 * `getRows()` (contratto Sushi) resta nel modello; questo trait ospita
 * i metodi di appoggio che leggono i file di traduzione dal filesystem.
 *
 * @phpstan-require-extends TranslationFile
 */
trait TranslationFileRowLoader
{
    /**
     * Carica i dati di traduzione con error handling robusto.
     *
     *
     * @return array<int, array<string, mixed>>
     *
     * @throws \Throwable
     */
    private function loadTranslationDataWithErrorHandling(): array
    {
        $files = app(GetAllTranslationAction::class)->execute();

        $result = Arr::map($files, $this->enrichTranslationRow(...));

        /** @var array<int, array<string, mixed>> $result */
        return $result;
    }

    /**
     * Aggiunge id/name/content alla riga restituita da GetAllTranslationAction.
     *
     * `path` e' opzionale: una riga senza path produce `content` vuoto
     * invece di far fallire l'intero caricamento.
     *
     * @param  array{key: string, path?: string}  $item
     * @return array<string, mixed>
     */
    private function enrichTranslationRow(array $item): array
    {
        $path = $item['path'] ?? '';

        return [
            ...$item,
            'id' => $item['key'],
            'name' => basename($path, '.php'),
            'content' => File::exists($path) ? $this->loadFileContent($path) : '',
        ];
    }

    /**
     * Carica il contenuto di un file di traduzione con fallback.
     */
    private function loadFileContent(string $path): string
    {
        try {
            $content = File::getRequire($path);

            return json_encode($content) ?: '';
        } catch (\Throwable $e) {
            Log::debug('Failed to load translation file', [
                'path' => $path,
                'error' => $e->getMessage(),
            ]);

            return '';
        }
    }

    private function isRunningIdeHelper(): bool
    {
        if (defined('PHPSTAN_RUNNING') || config('app.phpstan_running') === true) {
            return true;
        }

        $argv = $_SERVER['argv'] ?? [];

        return is_array($argv) && in_array('ide-helper:models', $argv, true);
    }
}
