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
        $xot = XotData::make();
        if (Str::startsWith($path, 'https://')) {
            return $path;
        }

        if (Str::startsWith($path, 'http://')) {
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

        $ns_after0 = Str::before($ns_after, '/');
        $ns_after1 = Str::after($ns_after, '/');
        $ns_after =
            str_replace('.', '/', is_string($ns_after0) ? $ns_after0 : ((string) $ns_after0)).'/'.$ns_after1;

        if (Str::startsWith($ns_after, '/')) {
            $ns_after = Str::after($ns_after, '/');
        }

        if (\in_array($ns, ['pub_theme', 'adm_theme'], false)) {
            // Assicuriamoci che $theme sia una stringa
            $theme = $xot->{$ns};
            Assert::string($theme, 'Il tema deve essere una stringa');

            // Costruiamo i percorsi
            $themeResourcePath = 'Themes/'.$theme.'/resources/'.$ns_after;
            $filename_from = app(FixPathAction::class)->execute(base_path($themeResourcePath));

            $themeAssetPath = 'themes/'.$theme.'/'.$ns_after;
            $asset = $themeAssetPath;
            $filename_to = app(FixPathAction::class)->execute(public_path($asset));
            $asset = Str::replace(url(''), '', asset($asset));

            if (! File::exists($filename_to)) {
                if (! File::exists(\dirname($filename_to))) {
                    File::makeDirectory(\dirname($filename_to), 0o755, true, true);
                }

                try {
                    File::copy($filename_from, $filename_to);
                } catch (Exception $e) {
                    throw new Exception(
                        'message:['.
                        $e->getMessage().
                            ']
                        public_path ['.
                            public_path().
                            ']
                        path ['.
                            $path.
                            ']
                        file from ['.
                            $filename_from.
                            ']
                        file to ['.
                            $filename_to.
                            ']',
                        $e->getCode(),
                        $e,
                    );
                }
            }

            Assert::string($asset, '['.__LINE__.']['.class_basename(static::class).']');

            return $asset;
        }

        $module_path = app(GetModulePathAction::class)->execute($ns);

        if (Str::endsWith($module_path, '/')) {
            $module_path = Str::beforeLast($module_path, '/');
        }

        $filename_from = app(FixPathAction::class)->execute($module_path.'/resources/'.$ns_after);
        $asset = 'assets/'.$ns.'/'.$ns_after;
        $filename_to = app(FixPathAction::class)->execute(public_path($asset));
        $asset = Str::replace(url(''), '', asset($asset));
        if (! File::exists($filename_from)) {
            if (isRunningTestBench()) {
                return $path;
            }
            throw new Exception('file ['.$filename_from.'] not Exists , path ['.$path.']');
        }

        // dddx(app()->environment());// local
        if (! File::exists($filename_to) || app()->environment() !== 'production') {
            if (! File::exists(\dirname($filename_to))) {
                File::makeDirectory(\dirname($filename_to), 0o755, true, true);
            }
            try {
                File::copy($filename_from, $filename_to);
            } catch (Exception $e) {
                throw new Exception(
                    'message:['.
                    $e->getMessage().
                        ']
                    public_path ['.
                        public_path().
                        ']
                    path ['.
                        $path.
                        ']
                    file from ['.
                        $filename_from.
                        ']
                    file to ['.
                        $filename_to.
                        ']',
                    $e->getCode(),
                    $e,
                );
            }
        }

        Assert::string($asset, '['.__LINE__.']['.class_basename(static::class).']');

        return $asset;
    }
}
