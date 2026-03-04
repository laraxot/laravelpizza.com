<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class AssetAction
{
    use QueueableAction;

    private XotData $xot;

    /**
     * Gestisce i percorsi degli asset, copiandoli nella directory pubblica se necessario.
     *
     * @param  string  $path  Il percorso dell'asset
     * @return string Il percorso pubblico dell'asset
     *
     * @throws \Exception Se il file sorgente non esiste o non può essere copiato
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
            throw new \Exception('file ['.$filename_from.'] not Exists , path ['.$originalPath.']');
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
     */
    private function copyAsset(string $from, string $to, string $path, bool $force = false): void
    {
        if (! File::exists($to) || $force) {
            $this->ensureDirectoryExists(\dirname($to));

            try {
                File::copy($from, $to);
            } catch (\Exception $e) {
                $this->throwCopyException($e, $path, $from, $to);
            }
        }
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
    private function throwCopyException(\Exception $e, string $path, string $from, string $to): void
    {
        throw new \Exception('message:['.$e->getMessage().']
            public_path ['.public_path().']
            path ['.$path.']
            file from ['.$from.']
            file to ['.$to.']', $e->getCode(), $e, );
    }
}
