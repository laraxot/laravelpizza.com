<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Testing;

use Safe\Exceptions\FilesystemException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\glob;

/**
 * Risolve il file SQLite condiviso usato dalla suite di test e dal comando `xot:build-test-sqlite`.
 *
 * Vive in `app/` e non in `tests/`: il codice applicativo non deve dipendere dalla
 * suite di test per sapere dove si trova il database di test.
 */
class ResolveSharedSqlitePathAction
{
    use QueueableAction;

    /**
     * Ordine: `xot.testing.sqlite_file`, poi l'unico `*.sqlite` in `database/`, altrimenti `test_data.sqlite`.
     */
    public function execute(): string
    {
        $configured = config('xot.testing.sqlite_file');

        if (is_string($configured) && $configured !== '') {
            return database_path($configured);
        }

        try {
            /** @var list<string> $found */
            $found = glob(database_path('*.sqlite'));
        } catch (FilesystemException) {
            $found = [];
        }

        if (count($found) === 1) {
            return $found[0];
        }

        return database_path('test_data.sqlite');
    }
}
