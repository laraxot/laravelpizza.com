<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Seo\Actions\Robots\BuildRobotsTxtAction;
use Modules\Seo\Actions\Sitemap\BuildSitemapAction;

// Alla radice, senza prefisso di lingua: i crawler li cercano solo li'.
// Array e non solo la classe: il gruppo del provider antepone `$moduleNamespace` alle azioni scritte come stringa.
Route::get('/sitemap.xml', [BuildSitemapAction::class, '__invoke'])->name('seo.sitemap');
Route::get('/robots.txt', [BuildRobotsTxtAction::class, '__invoke'])->name('seo.robots');
