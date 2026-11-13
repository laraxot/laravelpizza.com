<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Illuminate\Support\Facades\File;

use function Safe\preg_split;

/**
 * Aggiunge a un `.gitignore` le righe di un link di asset, se mancano.
 *
 * `public_html/assets/<modulo>` e `public_html/themes/<Tema>` sono symlink relativi creati in ogni
 * installazione (xot:module-link, xot:theme-link): non si committano. Per ogni nome servono due righe,
 * perche' per git un symlink e' un file e il pattern con la barra finale vale solo per le cartelle:
 * - `<nome>/` copre una cartella reale (vecchia copia degli asset);
 * - `<nome>` copre il symlink.
 * Il file tiene anche la cartella nel repository (git non versiona cartelle vuote).
 */
class EnsureGitignoreEntriesAction
{
    /**
     * @return list<string> righe aggiunte
     */
    public function execute(string $gitignorePath, string $name, string $header = ''): array
    {
        $content = File::exists($gitignorePath) ? File::get($gitignorePath) : ($header !== '' ? rtrim($header)."\n" : '');
        // Safe\preg_split e' tipizzato come list generica: il pattern \R produce solo stringhe.
        /** @var list<string> $rawLines */
        $rawLines = preg_split('/\R/', $content);
        $lines = array_map('trim', $rawLines);

        $added = [];
        foreach ([$name.'/', $name] as $entry) {
            if (! \in_array($entry, $lines, true)) {
                $added[] = $entry;
            }
        }
        if ($added === []) {
            return [];
        }

        if ($content !== '' && ! str_ends_with($content, "\n")) {
            $content .= "\n";
        }
        File::ensureDirectoryExists(\dirname($gitignorePath));
        File::put($gitignorePath, $content.implode("\n", $added)."\n");

        return $added;
    }
}
