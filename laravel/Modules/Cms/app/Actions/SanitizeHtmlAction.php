<?php

declare(strict_types=1);

namespace Modules\Cms\Actions;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\File;
use Spatie\QueueableAction\QueueableAction;

/**
 * HTML dei blocchi di testo delle pagine CMS (privacy, cookie, termini...) ripulito prima di stamparlo
 * con `{!! !!}`: restano titoli, paragrafi, elenchi, link, tabelle semplici; via script, stili inline,
 * iframe e attributi `on*`. Il testo lo scrive chi gestisce i contenuti dal pannello: e' fiducia
 * ragionevole, ma un errore o un account compromesso non deve poter iniettare script nel sito.
 */
final class SanitizeHtmlAction
{
    use QueueableAction;

    private ?HTMLPurifier $purifier = null;

    public function execute(string $html): string
    {
        if (trim($html) === '') {
            return '';
        }

        return $this->purifier()->purify($html);
    }

    private function purifier(): HTMLPurifier
    {
        if ($this->purifier !== null) {
            return $this->purifier;
        }

        $cache = storage_path('framework/cache/htmlpurifier');
        File::ensureDirectoryExists($cache);

        $config = HTMLPurifier_Config::createDefault();
        $config->set('Cache.SerializerPath', $cache);
        $config->set('HTML.Allowed', 'h2,h3,h4,p,br,strong,em,b,i,u,ul,ol,li,a[href|title|rel|target],blockquote,table,thead,tbody,tr,th,td,hr,code');
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.TargetNoopener', true);
        $config->set('HTML.TargetNoreferrer', true);
        $config->set('URI.AllowedSchemes', ['http' => true, 'https' => true, 'mailto' => true, 'tel' => true]);
        $config->set('AutoFormat.RemoveEmpty', true);

        return $this->purifier = new HTMLPurifier($config);
    }
}
