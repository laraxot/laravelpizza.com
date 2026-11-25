<?php

declare(strict_types=1);

/**
 * Contratto Filament 5.x layout: le Blade Cms head/foot devono contenere
 * le direttive filamentStyles / filamentScripts (Configuring your layout).
 *
 * Le direttive stanno dentro `@if ($panelAssets)`: un sito pubblico senza componenti Filament
 * le spegne con `:panel-assets="false"` (meno CSS/JS su telefono). L'ordine resta quello di Filament.
 * Test puro sul testo delle Blade: non avvia l'applicazione Laravel (nessun `uses(TestCase::class)`).
 *
 * @see https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 * @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
 */

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/** @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md */
test('cms head blade contains @filamentStyles before theme vite css', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/head.blade.php';
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString('@filamentStyles', $blade);
    Assert::assertMatchesRegularExpression('/@if \(\$panelAssets\)[\s\S]*@filamentStyles\s*\n\s*@endif\s*\n\s*@vite\(\[\$stylesheet\]/', $blade);
    // Il foglio di stile è una prop del componente (default `resources/css/app.css`) e le pagine aggiungono tag con @push('head').
    Assert::assertStringContainsString('@stack(\'head\')', $blade);
});

/** @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md */
test('cms foot blade contains notifications then @filamentScripts then theme vite js', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/foot.blade.php';
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString("@livewire('notifications')", $blade);
    // Nessun wrapp auth attorno alle notifications (contratto Filament layout).
    Assert::assertDoesNotMatchRegularExpression('/@auth\s*\n\s*@livewire\(\'notifications\'\)/', $blade);
    Assert::assertStringContainsString('@filamentScripts', $blade);
    Assert::assertMatchesRegularExpression("/@if \\(\\\$panelAssets\\)\\s*\\n\\s*@livewire\\('notifications'\\)\\s*\\n\\s*\\n\\s*@filamentScripts\\s*\\n@endif\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
});
