<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction as QueueableActionTrait;
use Webmozart\Assert\Assert;

class AssetAction
{
    use QueueableActionTrait;

    private XotData $xot;

    /**
     * Risolve il percorso pubblico di un asset (servito dal symlink verso la cartella `public` del modulo/tema).
     *
     * @param  string  $path  Il percorso dell'asset
     * @return string Il percorso pubblico dell'asset
     *
     * @throws Exception Se l'asset del modulo non esiste né in `public/` né in `resources/`
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

        return $this->publicUrl('themes/'.$theme.'/'.$ns_after);
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
        $filename_public = app(FixPathAction::class)->execute($module_path.'/public/'.$ns_after);

        if (! File::exists($filename_public) && ! File::exists($filename_from)) {
            if (isRunningTestBench()) {
                return $originalPath;
            }
            throw new Exception('file ['.$filename_public.'] not Exists , path ['.$originalPath.']');
        }

        // public_html/assets/<modulo in minuscolo> -> ../../laravel/Modules/<Modulo>/public (deploy.sh, regola in CLAUDE.md):
        // il nome del link e' sempre minuscolo, quindi anche l'URL (su Linux `assets/Xot` e `assets/xot` sono cartelle diverse).
        return $this->publicUrl('assets/'.Str::lower($ns).'/'.$ns_after);
    }

    /**
     * Nothing is copied: public_html/assets/<module> and public_html/themes/<Theme> are symlinks
     * (created by deploy.sh) to the module/theme `public` folder, so the URL is
     * served straight from there. The old per-request copy wrote through the symlink and failed
     * with "Failed to open stream" whenever the link was missing or broken.
     */
    private function publicUrl(string $assetPath): string
    {
        $asset = Str::replace(url(''), '', asset($assetPath));
        Assert::string($asset, '['.__LINE__.']['.class_basename(static::class).']');

        return $asset;
    }
}
