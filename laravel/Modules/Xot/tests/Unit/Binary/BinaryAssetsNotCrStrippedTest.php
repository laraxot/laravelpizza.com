<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Binary;

use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

use function Safe\fclose;
use function Safe\fopen;
use function Safe\fread;

/**
 * I binari del repository non devono mai essere alterati dai filtri di git.
 *
 * Difetto (story 5.178, corretto solo sul worktree e mai committato; chiuso da 5.241):
 * `laravel/.gitattributes` dichiarava `* text=auto eol=lf`. L'attributo `eol` abilita
 * la conversione CRLF -> LF anche sui file che piu in giu hanno `text` esplicitamente
 * `unset` (`*.png binary` = `-diff -merge -text`), quindi il clean filter cancellava il
 * byte 0x0D dalla firma PNG: `89504e470d0a1a0a` -> `89504e470a1a0a`. Tutti i PNG del
 * repository diventavano non decodificabili (fra cui il logo Filament), ma
 * `git status` restava "pulito" perche il filtro veniva riapplicato in fase di check.
 *
 * I tre test coprono i tre livelli in cui il difetto si manifesta:
 * 1. worktree: nessun file su disco con firma PNG troncata;
 * 2. attributi: i filtri non cambiano il contenuto dei binari;
 * 3. indice: i blob committati hanno la firma standard (il checkout di un clone pulito).
 */
#[Group('binary')]
final class BinaryAssetsNotCrStrippedTest extends TestCase
{
    private static function pngSignature(): string
    {
        return "\x89PNG\r\n\x1a\n";
    }

    private static function pngLead(): string
    {
        return "\x89PNG";
    }

    /**
     * @return list<string>
     */
    private static function binaryExtensions(): array
    {
        return [
            'png',
            'jpg',
            'jpeg',
            'gif',
            'webp',
            'ico',
            'svg',
            'psd',
            'pdf',
            'zip',
            'woff',
            'woff2',
            'ttf',
            'eot',
            'otf',
            'mp4',
            'phar',
            'db',
            'sqlite',
        ];
    }

    public function test_png_signature_on_disk(): void
    {
        $repo = $this->repoRoot();
        $files = $this->trackedBinaryFiles($repo);
        Assert::assertNotEmpty($files, 'nessun file binario tracciato: scansione vacua');

        $checked = 0;
        foreach ($files as $file) {
            if (! str_ends_with($file, '.png')) {
                continue;
            }

            $path = $repo.'/'.$file;
            if (! is_file($path)) {
                continue;
            }

            $head = $this->readHead($path, 8);
            $checked++;

            // Solo i file che dichiarano di essere PNG: gli 8 byte devono includere il CR.
            if (! str_starts_with($head, self::pngLead())) {
                continue;
            }

            Assert::assertSame(
                self::pngSignature(),
                $head,
                $file.': firma PNG senza CR (89504e470a1a0a) — il file non e decodificabile dai browser'
            );
        }

        Assert::assertGreaterThan(0, $checked, 'nessun PNG esistente da controllare');
    }

    public function test_git_filters_do_not_alter_binaries(): void
    {
        $repo = $this->repoRoot();
        $files = $this->trackedBinaryFiles($repo);

        $existing = [];
        foreach ($files as $file) {
            if (is_file($repo.'/'.$file)) {
                $existing[] = $file;
            }
        }

        Assert::assertNotEmpty($existing, 'nessun file binario esistente: scansione vacua');

        $withFilters = $this->hashObjects($repo, $existing, false);
        $withoutFilters = $this->hashObjects($repo, $existing, true);

        Assert::assertSame(
            $withoutFilters,
            $withFilters,
            'i filtri git modificano il contenuto dei binari: gli attributi reintroducono la corruzione (vedi story 5.241)'
        );
    }

    public function test_png_signature_in_git_index(): void
    {
        $repo = $this->repoRoot();
        $files = $this->trackedBinaryFiles($repo);

        $pathspec = [];
        $shaToPath = [];
        foreach ($files as $file) {
            if (str_ends_with($file, '.png')) {
                $pathspec[] = $file;
            }
        }

        $process = new Process(['git', 'ls-files', '-s', '-z', '--', ...$pathspec], $repo);
        $process->run();
        Assert::assertTrue($process->isSuccessful(), 'git ls-files fallito: '.$process->getErrorOutput());

        foreach (explode("\0", $process->getOutput()) as $record) {
            if (trim($record) === '') {
                continue;
            }

            [$meta, $path] = explode("\t", $record, 2);
            $fields = explode(' ', $meta);
            if (count($fields) < 2) {
                continue;
            }

            $sha = $fields[1];
            $shaToPath[$sha] = $path;
        }

        Assert::assertNotEmpty($shaToPath, 'nessun PNG tracciato: scansione vacua');

        $contents = $this->catFileBatch($repo, array_keys($shaToPath));

        foreach ($contents as $sha => $content) {
            $path = $shaToPath[$sha] ?? '?';
            if (! str_starts_with($content, self::pngLead())) {
                continue;
            }

            Assert::assertSame(
                self::pngSignature(),
                substr($content, 0, 8),
                $path.': il blob committato ha la firma PNG senza CR — clone e deploy servono un PNG rotto'
            );
        }
    }

    /**
     * Root del monorepo (directory che contiene sia `.git` che `laravel/`).
     *
     * Ogni `Modules/<Mod>` ha un `.git` proprio, disconnesso dalla root
     * (repo nested per modulo). Il primo `.git` risalendo da `__DIR__` e'
     * quindi quello di `Modules/Xot`, non quello del monorepo: senza il
     * controllo su `laravel/` i pathspec `laravel/**\/*.ext` usati piu' sotto
     * non troverebbero mai nulla (scansione vacua silenziosa).
     */
    private function repoRoot(): string
    {
        $dir = __DIR__;
        for ($i = 0; $i < 8; $i++) {
            if (is_dir($dir.'/.git') && is_dir($dir.'/laravel')) {
                return $dir;
            }

            $dir = dirname($dir);
        }

        Assert::markTestSkipped('non sembra un checkout git: analisi dei filtri git non applicabile');
    }

    /**
     * File tracciati sotto `laravel/` con estensione dichiarata binaria.
     *
     * @return list<string>
     */
    private function trackedBinaryFiles(string $repo): array
    {
        $args = ['git', 'ls-files', '-z', '--'];
        foreach (self::binaryExtensions() as $extension) {
            $args[] = 'laravel/**/*.'.$extension;
        }

        $process = new Process($args, $repo);
        $process->run();
        Assert::assertTrue($process->isSuccessful(), 'git ls-files fallito: '.$process->getErrorOutput());

        $files = [];
        foreach (explode("\0", $process->getOutput()) as $record) {
            $record = trim($record);
            if ($record === '' || ! str_starts_with($record, 'laravel/')) {
                continue;
            }

            if (str_contains($record, '/vendor/') || str_contains($record, '/node_modules/')) {
                continue;
            }

            $files[] = $record;
        }

        sort($files);

        return array_values(array_unique($files));
    }

    /**
     * @param  list<string>  $files
     * @return list<string>
     */
    private function hashObjects(string $repo, array $files, bool $noFilters): array
    {
        $args = ['git', 'hash-object'];
        if ($noFilters) {
            $args[] = '--no-filters';
        }

        $args[] = '--stdin-paths';

        $process = new Process($args, $repo);
        $process->setInput(implode("\n", $files)."\n");
        $process->run();
        Assert::assertTrue($process->isSuccessful(), 'git hash-object fallito: '.$process->getErrorOutput());

        $hashes = [];
        foreach (explode("\n", $process->getOutput()) as $line) {
            $line = trim($line);
            if ($line !== '') {
                $hashes[] = $line;
            }
        }

        return $hashes;
    }

    /**
     * Contenuto dei blob richiesti a `git cat-file --batch` (un solo processo).
     *
     * @param  list<string>  $shas
     * @return array<string, string>
     */
    private function catFileBatch(string $repo, array $shas): array
    {
        $process = new Process(['git', 'cat-file', '--batch'], $repo);
        $process->setInput(implode("\n", $shas)."\n");
        $process->run();
        Assert::assertTrue($process->isSuccessful(), 'git cat-file fallito: '.$process->getErrorOutput());

        $output = $process->getOutput();
        $contents = [];
        $offset = 0;
        $length = strlen($output);

        while ($offset < $length) {
            $eol = strpos($output, "\n", $offset);
            if ($eol === false) {
                break;
            }

            $header = substr($output, $offset, $eol - $offset);
            $offset = $eol + 1;

            $fields = explode(' ', $header);
            if (count($fields) < 3 || $fields[1] !== 'blob') {
                continue;
            }

            $sha = $fields[0];
            $size = (int) $fields[2];
            $contents[$sha] = substr($output, $offset, $size);
            $offset += $size + 1;
        }

        return $contents;
    }

    /**
     * @param  int<1, max>  $length
     */
    private function readHead(string $path, int $length): string
    {
        $handle = fopen($path, 'rb');

        $head = fread($handle, $length);
        fclose($handle);

        return $head;
    }
}

