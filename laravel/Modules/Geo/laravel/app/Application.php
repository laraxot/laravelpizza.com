<?php

/**
 * ---.
 */
declare(strict_types=1);

namespace App;

use Safe\Exceptions\FilesystemException;

use function Safe\realpath;

class Application extends \Illuminate\Foundation\Application
{
    public function publicPath($path = ''): string
    {
        $publicRoot = $this->basePath.'/../public_html';
        $relativePath = ltrim((string) $path, '/\\');
        $candidate = $relativePath === '' ? $publicRoot : $publicRoot.'/'.$relativePath;

        // 1) Il path richiesto esiste: ritorna il percorso canonico.
        try {
            return realpath($candidate);
        } catch (FilesystemException) {
            // candidate non ancora presente sul filesystem
        }

        // 2) public_html esiste ma il segmento no: canonicalizza la root e appendi il segmento.
        try {
            $resolvedRoot = realpath($publicRoot);

            return $relativePath === '' ? $resolvedRoot : $resolvedRoot.'/'.$relativePath;
        } catch (FilesystemException) {
            // public_html non esiste: fallback al path normalizzato
        }

        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $candidate);
    }
}
