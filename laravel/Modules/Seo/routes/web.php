<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Seo\Actions\IndexNow\ServeIndexNowKeyAction;
use Modules\Seo\Actions\Robots\BuildRobotsTxtAction;
use Modules\Seo\Actions\Sitemap\BuildSitemapAction;

// Alla radice, senza prefisso di lingua: i crawler li cercano solo li'.
// Array e non solo la classe: il gruppo del provider antepone `$moduleNamespace` alle azioni scritte come stringa.
Route::get('/sitemap.xml', [BuildSitemapAction::class, '__invoke'])->name('seo.sitemap');
Route::get('/robots.txt', [BuildRobotsTxtAction::class, '__invoke'])->name('seo.robots');

// File di verifica IndexNow (`/{chiave}.txt`): 404 per ogni chiave che non e' quella configurata.
// Dopo robots.txt: le rotte si confrontano in ordine di registrazione. @see Modules/Seo/docs/adr/search-engine-presence.md
Route::get('/{key}.txt', [ServeIndexNowKeyAction::class, '__invoke'])
    ->where('key', '[A-Za-z0-9-]{8,128}')
    ->name('seo.indexnow.key');
