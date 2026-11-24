<?php

declare(strict_types=1);

/**
 * Contratto Filament 5.x layout: le Blade Cms head/foot devono contenere
 * le direttive filamentStyles / filamentScripts (Configuring your layout).
<<<<<<< .merge_file_KN37he
 *
 * Le direttive stanno dentro `@if ($panelAssets)`: un sito pubblico senza componenti Filament
 * le spegne con `:panel-assets="false"` (meno CSS/JS su telefono). L'ordine resta quello di Filament.
 *
 * @see https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 * @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
=======
<<<<<<< HEAD
 *
 * @see https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 * @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
 *
 * Le direttive stanno dentro `@if ($panelAssets)`: un sito pubblico senza componenti Filament
 * le spegne con `:panel-assets="false"` (meno CSS/JS su telefono). L'ordine resta quello di Filament.
=======
 * Le direttive sono sempre emesse dal contratto del front office. L'ordine resta quello di Filament.
 *
 * @see https://filamentphp.com/docs/5.x/introduction/installation#configuring-your-layout
 * @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md
>>>>>>> laraxot/dev
>>>>>>> .merge_file_tpKcEw
 */

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

<<<<<<< .merge_file_KN37he
=======
<<<<<<< HEAD
test('cms head blade contains @filamentStyles before theme vite css', function (): void {
    $path = module_path('Cms', 'resources/views/components/head.blade.php');
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString('@filamentStyles', $blade);
    Assert::assertMatchesRegularExpression('/@if \(\$panelAssets\)[\s\S]*@filamentStyles\s*\n\s*@endif\s*\n\s*@vite\(\[\'resources\/css\/app\.css\'\]/', $blade);
});

test('cms foot blade contains notifications then @filamentScripts then theme vite js', function (): void {
    $path = module_path('Cms', 'resources/views/components/foot.blade.php');
=======
>>>>>>> .merge_file_tpKcEw
// This is a pure Blade contract test; it does not boot the Laravel application.
/** @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md */
test('cms head blade contains @filamentStyles before theme vite css', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/head.blade.php';
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString('@filamentStyles', $blade);
<<<<<<< .merge_file_KN37he
    Assert::assertMatchesRegularExpression('/@if \(\$panelAssets\)[\s\S]*@filamentStyles\s*\n\s*@endif\s*\n\s*@vite\(\[\$stylesheet\]/', $blade);
    // Il foglio di stile è una prop del componente (default `resources/css/app.css`) e le pagine aggiungono tag con @push('head').
    Assert::assertStringContainsString('@stack(\'head\')', $blade);
=======
    Assert::assertMatchesRegularExpression('/@filamentStyles\s*\n\s*@vite\(\[\'resources\/css\/app\.css\'\]/', $blade);
>>>>>>> .merge_file_tpKcEw
});

/** @see Modules/Cms/docs/bmad/filament-layout-styles-scripts.md */
test('cms foot blade contains notifications then @filamentScripts then theme vite js', function (): void {
    $path = dirname(__DIR__, 3).'/resources/views/components/foot.blade.php';
<<<<<<< .merge_file_KN37he
=======
>>>>>>> laraxot/dev
>>>>>>> .merge_file_tpKcEw
    Assert::assertFileExists($path);
    $blade = file_get_contents($path);
    Assert::assertStringContainsString("@livewire('notifications')", $blade);
    // Nessun wrapp auth attorno alle notifications (contratto Filament layout).
    Assert::assertDoesNotMatchRegularExpression('/@auth\s*\n\s*@livewire\(\'notifications\'\)/', $blade);
    Assert::assertStringContainsString('@filamentScripts', $blade);
<<<<<<< .merge_file_KN37he
    Assert::assertMatchesRegularExpression("/@if \\(\\\$panelAssets\\)\\s*\\n\\s*@livewire\\('notifications'\\)\\s*\\n\\s*\\n\\s*@filamentScripts\\s*\\n@endif\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
=======
<<<<<<< HEAD
    Assert::assertMatchesRegularExpression("/@if \\(\\\$panelAssets\\)\\s*\\n\\s*@livewire\\('notifications'\\)\\s*\\n\\s*\\n\\s*@filamentScripts\\s*\\n@endif\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
=======
    Assert::assertMatchesRegularExpression("/@livewire\\('notifications'\\)\\s*\\n\\s*\\n@filamentScripts\\s*\\n@vite\\(\\['resources\\/js\\/app\\.js'\\]/", $blade);
>>>>>>> laraxot/dev
>>>>>>> .merge_file_tpKcEw
});
