<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction as QueueableActionTrait;
use Throwable;
use Webmozart\Assert\Assert;

use function Safe\getmypid;

class AssetAction
{
    use QueueableActionTrait;

    private XotData $xot;

    /**
     * Gestisce i percorsi degli asset, copiandoli nella directory pubblica se necessario.
     *
     * @param  string  $path  Il percorso dell'asset
     * @return string Il percorso pubblico dell'asset
     *
     * @throws Exception Se il file sorgente non esiste o non può essere copiato
     */
    public function execute(string $path): string
    {
        $this->xot = XotData::make();

        if (Str::startsWith($path, ['https://', 'http://'])) {
            return $path;
        }

        if (File::exists(public_path($path))) {
            return $path;
        }

        $ns = Str::before($path, '::');
        $ns_after = Str::after($path, '::');

        if ($ns === $path) {
            $ns = inAdmin() ? 'adm_theme' : 'pub_theme';
        }

        $ns_after = $this->normalizeNsAfter($ns_after);

        if (\in_array($ns, ['pub_theme', 'adm_theme'], false)) {
            return $this->resolveThemeAsset($ns, $ns_after);
        }

        return $this->resolveModuleAsset($path, $ns, $ns_after);
    }

    /**
     * Normalizes the given path segment.
     */
    private function normalizeNsAfter(string $ns_after): string
    {
        $ns_after0 = Str::before($ns_after, '/');
        $ns_after1 = Str::after($ns_after, '/');
        $ns_after = str_replace('.', '/', $ns_after0).'/'.$ns_after1;

        if (Str::startsWith($ns_after, '/')) {
            return Str::after($ns_after, '/');
        }

        return $ns_after;
    }

    /**
     * Resolves the path for a theme asset.
     */
    private function resolveThemeAsset(string $ns, string $ns_after): string
    {
        $theme = $this->xot->{$ns};
        Assert::string($theme, 'Il tema deve essere una stringa');

        $themeResourcePath = 'Themes/'.$theme.'/resources/'.$ns_after;
        $filename_from = app(FixPathAction::class)->execute(base_path($themeResourcePath));

        $themeAssetPath = 'themes/'.$theme.'/'.$ns_after;
        $filename_to = app(FixPathAction::class)->execute(public_path($themeAssetPath));

        $this->copyAsset($filename_from, $filename_to, $themeAssetPath);

        $asset = Str::replace(url(''), '', asset($themeAssetPath));
        Assert::string($asset, '['.__LINE__.']['.class_basename(static::class).']');

        return $asset;
    }

    /**
     * Resolves the path for a module asset.
     */
    private function resolveModuleAsset(string $originalPath, string $ns, string $ns_after): string
    {
        $module_path = app(GetModulePathAction::class)->execute($ns);

        if (Str::endsWith($module_path, '/')) {
            $module_path = Str::beforeLast($module_path, '/');
        }

        $filename_from = app(FixPathAction::class)->execute($module_path.'/resources/'.$ns_after);

        if (! File::exists($filename_from)) {
            if (isRunningTestBench()) {
                return $originalPath;
            }
            throw new Exception('file ['.$filename_from.'] not Exists , path ['.$originalPath.']');
        }

        $assetPath = 'assets/'.$ns.'/'.$ns_after;
        $filename_to = app(FixPathAction::class)->execute(public_path($assetPath));

        $forceCopy = app()->environment() !== 'production';
        $this->copyAsset($filename_from, $filename_to, $assetPath, $forceCopy);

        $asset = Str::replace(url(''), '', asset($assetPath));
        Assert::string($asset, '['.__LINE__.']['.class_basename(static::class).']');

        return $asset;
    }

    /**
     * Copies an asset file if it doesn't exist or if forced.
     *
     * In APP_ENV=local the caller forces a copy on every request so assets
     * refresh without a rebuild. PHP-FPM runs as www-data: if the dest was
     * written by another user, copy fails and MetatagData must not fall back
     * to asset('module::img/x.png') (404). If the dest already exists and is
     * readable, serve it instead. Story Xot/5.180.
     *
     * Forced does not mean blind: an up-to-date dest is left alone, and a stale
     * one is swapped atomically. See copyAtomically().
     */
    private function copyAsset(string $from, string $to, string $path, bool $force = false): void
    {
        $destinationExists = File::exists($to);

        if ($destinationExists && ! $force) {
            return;
        }

        if ($destinationExists && ! File::isWritable($to)) {
            return;
        }

        if ($destinationExists && $this->isUpToDate($from, $to)) {
            return;
        }

        $this->ensureDirectoryExists(\dirname($to));

        try {
            $copied = $this->copyAtomically($from, $to);
        } catch (Throwable $e) {
            $this->handleCopyFailure($e, $path, $from, $to);

            return;
        }

        if ($copied) {
            return;
        }

        $this->handleCopyFailure(
            new Exception('Unable to copy asset file'),
            $path,
            $from,
            $to,
        );
    }

    /**
     * Same size and a dest not older than the source: nothing to refresh.
     */
    private function isUpToDate(string $source, string $destination): bool
    {
        return File::size($source) === File::size($destination)
            && File::lastModified($destination) >= File::lastModified($source);
    }

    /**
     * Copy to a temp file in the dest directory, then rename() over the dest.
     *
     * copy() truncates the dest before writing it. The dest is a public file that
     * the web server may be streaming to a browser while another request refreshes
     * it: the browser gets an empty or partial image (the panel logo vanished,
     * 2026-09-29). rename() is atomic on the same filesystem: readers see the old
     * file or the new one, never a truncated one.
     */
    private function copyAtomically(string $source, string $destination): bool
    {
        $temporary = $destination.'.'.getmypid().'.tmp';

        try {
            return File::copy($source, $temporary) && File::move($temporary, $destination);
        } finally {
            if (File::exists($temporary)) {
                File::delete($temporary);
            }
        }
    }

    /**
     * If the public dest is already readable, keep serving it.
     * Otherwise rethrow so the caller can fail loudly.
     */
    private function handleCopyFailure(Throwable $e, string $path, string $from, string $to): void
    {
        if (File::exists($to) && File::isReadable($to)) {
            return;
        }

        $exception = $e instanceof Exception
            ? $e
            : new Exception($e->getMessage(), (int) $e->getCode(), $e);

        $this->throwCopyException($exception, $path, $from, $to);
    }

    /**
     * Ensures the given directory exists.
     */
    private function ensureDirectoryExists(string $directory): void
    {
        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0o755, true, true);
        }
    }

    /**
     * Throws a formatted exception for a file copy error.
     */
    private function throwCopyException(Exception $e, string $path, string $from, string $to): void
    {
        throw new Exception('message:['.$e->getMessage().']
            public_path ['.public_path().']
            path ['.$path.']
            file from ['.$from.']
            file to ['.$to.']', $e->getCode(), $e, );
    }
}
