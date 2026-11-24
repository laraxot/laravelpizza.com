<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\File;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Datas\XotData;
use Spatie\QueueableAction\QueueableAction as QueueableActionTrait;
use Webmozart\Assert\Assert;

/**
 * @see docs/contracts/asset-action.md
<<<<<<< .merge_file_PxABts
 *
=======
>>>>>>> .merge_file_1Ix97z
 * @contract docs/contracts/asset-action.md
 */
class AssetAction
{
    use QueueableActionTrait;

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

        if (\in_array($ns, ['pub_theme', 'adm_theme'], true)) {
            return $this->resolveThemeAsset($ns, $ns_after);
        }

        return $this->resolveModuleAsset($path, $ns, $ns_after);
    }

    /**
     * Normalizza il segmento dopo `::`: i punti del primo segmento diventano `/` e lo slash iniziale viene tolto.
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
     * Risolve l'URL di un asset del tema pubblico (`pub_theme`) o amministrativo (`adm_theme`).
     *
     * @param  'pub_theme'|'adm_theme'  $ns
     */
    private function resolveThemeAsset(string $ns, string $ns_after): string
    {
        $xot = XotData::make();
        $theme = $ns === 'adm_theme' ? $xot->adm_theme : $xot->pub_theme;
        Assert::string($theme, 'Il tema deve essere una stringa');

        return $this->publicUrl('themes/'.$theme.'/'.$ns_after);
    }

    /**
     * Risolve l'URL di un asset di modulo (`modulo::percorso`).
     */
    private function resolveModuleAsset(string $originalPath, string $ns, string $ns_after): string
    {
        $module_path = app(GetModulePathAction::class)->execute($ns);

        if (Str::endsWith($module_path, '/')) {
            $module_path = Str::beforeLast($module_path, '/');
        }

        // Asset statici del modulo in Modules/<Modulo>/public: serviti dal symlink
        // public_html/assets/<modulo> -> ../../laravel/Modules/<Modulo>/public
        // (deploy.sh / xot:module-link). Niente copia.
        $filename_public = app(FixPathAction::class)->execute($module_path.'/public/'.$ns_after);
        // Ripiego storico: file solo in resources/ — l'URL resta comunque assets/<modulo>
        // (il symlink punta a public/, quindi va spostato lì per essere servito).
        $filename_from = app(FixPathAction::class)->execute($module_path.'/resources/'.$ns_after);

        if (File::exists($filename_public) || File::exists($filename_from)) {
            // Link e URL sempre minuscoli (su Linux assets/Xot ≠ assets/xot).
            return $this->publicUrl('assets/'.Str::lower($ns).'/'.$ns_after);
        }

        if (isRunningTestBench()) {
            return $originalPath;
        }

        throw new Exception('file ['.$filename_public.'] not Exists , path ['.$originalPath.']');
    }

    /**
     * Nessuna copia: public_html/assets/<modulo> e public_html/themes/<Tema> sono symlink
     * (deploy.sh / xot:module-link, xot:theme-link) verso la cartella `public` del modulo/tema, quindi
     * l'URL è servito direttamente da lì. La vecchia copia a ogni richiesta scriveva attraverso il symlink
     * e falliva con «Failed to open stream» quando il link mancava o era rotto.
     */
    private function publicUrl(string $assetPath): string
    {
        $asset = Str::replace(url(''), '', asset($assetPath));
        Assert::string($asset, '['.__LINE__.']['.class_basename(static::class).']');

        return $asset;
    }
}
