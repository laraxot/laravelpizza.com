<?php

declare(strict_types=1);

namespace Modules\Seo\Actions\Robots;

use Illuminate\Http\Response;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/**
 * robots.txt: chiude la scansione delle aree riservate in ogni lingua e indica la sitemap.
 *
 * Il `Disallow` non toglie dall'indice una pagina gia' nota e non vale per le copie con la lingua in maiuscolo: l'esclusione vera
 * e' il `meta robots noindex` della pagina. Qui si evita solo di far scansionare aree che non hanno nulla da indicizzare.
 * Le stesse pagine restano fuori da `BuildSitemapAction` (`auth.*`, pagine dietro `auth`).
 */
final class BuildRobotsTxtAction
{
    /**
     * Segmenti dopo la lingua: pagine Folio riservate dei temi e del modulo User.
     *
     * @var list<string>
     */
    public const array PRIVATE_SEGMENTS = ['auth', 'area-personale', 'dashboard', 'notifications', 'profile'];

    /** Risposta HTTP della rotta `/robots.txt` (invokable: `route:cache` non ammette closure). */
    public function __invoke(): Response
    {
        return response($this->execute(), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    public function execute(): string
    {
        $lines = ['User-agent: *'];
        foreach (array_keys(LaravelLocalization::getSupportedLocales()) as $locale) {
            foreach (self::PRIVATE_SEGMENTS as $segment) {
                $lines[] = 'Disallow: /'.$locale.'/'.$segment;
            }
        }
        // I pannelli Filament stanno sotto `/{modulo}/admin`.
        array_push($lines, 'Disallow: /admin', 'Disallow: /*/admin', '', 'Sitemap: '.url('/sitemap.xml'));

        return implode("\n", $lines)."\n";
    }
}
