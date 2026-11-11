<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Feature;

use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

/**
 * Theme Management Business Logic: specifica non implementata.
 *
 * Il corpo originale (20 test) esercita `Modules\Notify\Models\Theme` su una tabella `themes`
 * con colonne spacing, border_radius, shadows, breakpoints, utilities, transitions,
 * animations, components, changelog, metadata, settings e archived_at. In Notify quella
 * tabella non esiste: nessuna migration crea `themes` (la migration
 * `2020_01_01_000007_create_notify_themes_table` crea `notify_themes`, modello `NotifyTheme`)
 * e il model `Theme` dichiara solo name, description, colors, fonts, version, is_active.
 * Nessun codice di produzione usa `Theme`.
 *
 * Quando il tema design token di Notify sara' implementato (migration + colonne nel model),
 * ripristinare il corpo da git: `git -C Modules/Notify show 13f2cb04f:tests/Feature/ThemeManagementBusinessLogicTest.php`.
 *
 * @see Modules/Notify/docs/stories/phpstan-test-wave-notify-b.story.md
 */
it('theme management business logic')->skip('themes table and Theme design token columns not implemented');
