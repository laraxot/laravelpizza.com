<?php

declare(strict_types=1);

namespace Modules\Lang\Actions;

use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Spatie\QueueableAction\QueueableAction;
use SplFileInfo;

use function Safe\file_get_contents;
use function Safe\file_put_contents;
use function Safe\unlink;

/**
 * Toglie dai file di lingua le "traduzioni segnaposto": helper_text, placeholder, description, tooltip,
 * label, heading o hint uguali al nome del campo che li contiene. Le scriveva AutoLabelAction in locale e,
 * committate, comparivano in produzione sotto e dentro i campi ("route", "postal_code"). Elimina anche i
 * file `.php` senza nome. Riscrive solo i file di soli dati: un file che chiama funzioni o usa variabili
 * resterebbe "congelato" al valore calcolato qui, quindi non si tocca.
 */
class CleanPlaceholderTranslationsAction
{
    use QueueableAction;

    public const array PLACEHOLDER_TYPES = ['helper_text', 'placeholder', 'description', 'tooltip', 'label', 'heading', 'hint'];

    /**
     * @return array{files: list<string>, removed: int}
     */
    public function execute(string $directory, bool $dryRun = false): array
    {
        $files = [];
        $removed = 0;
        if (! is_dir($directory)) {
            return ['files' => [], 'removed' => 0];
        }

        /** @var iterable<SplFileInfo> $iterator */
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory, FilesystemIterator::SKIP_DOTS));
        foreach ($iterator as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }
            $path = $file->getPathname();
            if ($file->getFilename() === '.php') {
                $files[] = $path;
                if (! $dryRun) {
                    unlink($path);
                }

                continue;
            }
            $source = file_get_contents($path);
            if (! self::isPureData($source)) {
                continue;
            }
            $data = include $path;
            if (! \is_array($data)) {
                continue;
            }
            $count = 0;
            $cleaned = self::clean($data, null, $count);
            if ($count === 0) {
                continue;
            }
            $files[] = $path;
            $removed += $count;
            if (! $dryRun) {
                file_put_contents($path, "<?php\n\ndeclare(strict_types=1);\n\nreturn ".self::export($cleaned, 0).";\n");
            }
        }

        return ['files' => $files, 'removed' => $removed];
    }

    public static function isPureData(string $source): bool
    {
        $allowedStrings = ['strict_types', 'true', 'false', 'null'];
        $forbidden = [T_VARIABLE, T_FUNCTION, T_FN, T_NEW, T_STATIC, T_DOUBLE_COLON, T_NAME_QUALIFIED, T_NAME_FULLY_QUALIFIED, T_USE, T_REQUIRE, T_INCLUDE, T_REQUIRE_ONCE, T_INCLUDE_ONCE, T_ENCAPSED_AND_WHITESPACE, T_START_HEREDOC];
        foreach (token_get_all($source) as $token) {
            if (! \is_array($token)) {
                if (\in_array($token, ['.', '$', '?', ':', '+', '-', '*', '/'], true)) {
                    return false;
                }

                continue;
            }
            if (\in_array($token[0], $forbidden, true)) {
                return false;
            }
            if ($token[0] === T_STRING && ! \in_array(strtolower($token[1]), $allowedStrings, true)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  array<array-key, mixed>  $data
     * @return array<array-key, mixed>
     */
    private static function clean(array $data, int|string|null $parent, int &$removed): array
    {
        foreach ($data as $key => $value) {
            if (\is_array($value)) {
                $value = self::clean($value, $key, $removed);
                if ($value === []) {
                    unset($data[$key]);
                    $removed++;

                    continue;
                }
                $data[$key] = $value;

                continue;
            }
            if (\is_string($key) && \in_array($key, self::PLACEHOLDER_TYPES, true) && \is_string($value) && \is_string($parent) && $value === $parent) {
                unset($data[$key]);
                $removed++;
            }
        }

        return $data;
    }

    private static function export(mixed $value, int $level): string
    {
        if (! \is_array($value)) {
            return var_export($value, true);
        }
        if ($value === []) {
            return '[]';
        }
        $pad = str_repeat('    ', $level + 1);
        $isList = array_is_list($value);
        $lines = [];
        foreach ($value as $key => $item) {
            $lines[] = $pad.($isList ? '' : var_export($key, true).' => ').self::export($item, $level + 1).',';
        }

        return "[\n".implode("\n", $lines)."\n".str_repeat('    ', $level).']';
    }
}
