<?php
/**
* ---.
*/
declare(strict_types=1);

namespace App;

class Application extends \Illuminate\Foundation\Application
{

    public function publicPath($path = ''): string
    {
        $tmp = $this->basePath.'/../public_html/'.$path;
        $tmp = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $tmp);
        $realPath = \realpath($tmp);
        if ($realPath === false) {
            $baseRealPath = \realpath($this->basePath.'/../public_html/');
            if ($baseRealPath === false) {
                return $this->basePath.'/../public_html/'.$path;
            }

            return $baseRealPath.'/'.$path;
        }

        return $realPath;
    }
}
