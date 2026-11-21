<?php

declare(strict_types=1);

/**
 * Contratto Filament 5.x layout: le Blade Cms head/foot devono contenere
 * le direttive filamentStyles / filamentScripts (Configuring your layout).
 *
 * @see https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 * @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
 *
 * Le direttive stanno dentro `@if ($panelAssets)`: un sito pubblico senza componenti Filament
 * le spegne con `:panel-assets="false"` (meno CSS/JS su telefono). L'ordine resta quello di Filament.
 */

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

test('cms head blade contains @filamentStyles before theme vite css', function (): void {
    $path = module_path('Cms', 'resources/views/components/head.blade.php');
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString('@filamentStyles', $blade);
    Assert::assertMatchesRegularExpression('/@if \(\$panelAssets\)[\s\S]*@filamentStyles\s*\n\s*@endif\s*\n\s*@vite\(\[\'resources\/css\/app\.css\'\]/', $blade);
});

test('cms foot blade contains notifications then @filamentScripts then theme vite js', function (): void {
    $path = module_path('Cms', 'resources/views/components/foot.blade.php');
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString("@livewire('notifications')", $blade);
    // Nessun wrapp auth attorno alle notifications (contratto Filament layout).
    Assert::assertDoesNotMatchRegularExpression('/@auth\s*\n\s*@livewire\(\'notifications\'\)/', $blade);
    Assert::assertStringContainsString('@filamentScripts', $blade);
    Assert::assertMatchesRegularExpression("/@if \\(\\\$panelAssets\\)\\s*\\n\\s*@livewire\\('notifications'\\)\\s*\\n\\s*\\n\\s*@filamentScripts\\s*\\n@endif\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
});
