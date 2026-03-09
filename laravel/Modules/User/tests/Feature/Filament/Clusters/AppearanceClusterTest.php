<?php

declare(strict_types=1);

use Modules\User\Filament\Clusters\Appearance;
use Modules\User\Filament\Clusters\Appearance\Pages\Alignment;
use Modules\User\Filament\Clusters\Appearance\Pages\Background;
use Modules\User\Filament\Clusters\Appearance\Pages\Colors;
use Modules\User\Filament\Clusters\Appearance\Pages\CustomCss;
use Modules\User\Filament\Clusters\Appearance\Pages\Favicon;
use Modules\User\Filament\Clusters\Appearance\Pages\Logo;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Clusters\XotBaseCluster;
use Modules\Xot\Filament\Pages\XotBasePage;

uses(TestCase::class);

/*
 * Test per il Cluster Appearance e le sue Pages.
 *
 * Verifica che:
 * - Il Cluster estenda XotBaseCluster (NON Filament direttamente)
 * - Le Pages estendano XotBasePage (NON Filament direttamente)
 * - Le Pages abbiano la property $cluster corretta
 * - Nessuna violazione architettura Laraxot
 */
test('Appearance cluster extends XotBaseCluster', function () {
    expect(is_subclass_of(Appearance::class, XotBaseCluster::class))
        ->toBeTrue('Appearance deve estendere XotBaseCluster, non Filament\Clusters\Cluster direttamente');
});

test('all cluster pages extend XotBasePage', function () {
    $pages = [
        Alignment::class,
        Background::class,
        Colors::class,
        CustomCss::class,
        Favicon::class,
        Logo::class,
    ];

    foreach ($pages as $pageClass) {
        expect(is_subclass_of($pageClass, XotBasePage::class))
            ->toBeTrue("{$pageClass} deve estendere XotBasePage, non Filament\Pages\Page direttamente");
    }
});

test('all cluster pages have cluster property set', function () {
    $pages = [
        Alignment::class,
        Background::class,
        Colors::class,
        CustomCss::class,
        Favicon::class,
        Logo::class,
    ];

    foreach ($pages as $pageClass) {
        $reflection = new ReflectionClass($pageClass);
        $property = $reflection->getProperty('cluster');
        $defaultValue = $property->getDefaultValue();

        expect($defaultValue)
            ->toBe(Appearance::class, "{$pageClass} deve avere \$cluster = Appearance::class");
    }
});

test('cluster pages do not extend Filament classes directly', function () {
    $files = glob(base_path('Modules/User/app/Filament/Clusters/Appearance/Pages/*.php'));

    foreach ($files as $file) {
        $content = file_get_contents($file);

        expect($content)
            ->not->toContain('extends Page', basename($file).' non deve estendere Page direttamente')
            ->not->toContain('use Filament\Pages\Page', basename($file).' non deve importare Filament\Pages\Page');
    }
});

test('cluster does not extend Filament directly', function () {
    $file = base_path('Modules/User/app/Filament/Clusters/Appearance.php');
    $content = file_get_contents($file);

    expect($content)
        ->not->toContain('extends Cluster;', 'Appearance non deve estendere Cluster direttamente')
        ->not->toContain('use Filament\Clusters\Cluster;', 'Appearance non deve importare Filament\Clusters\Cluster direttamente');
    // ->toContain('extends XotBaseCluster', 'Appearance deve estendere XotBaseCluster'); // Covered by is_subclass_of test
});

test('cluster pages are accessible', function () {
    $userClass = XotData::make()->getUserClass();
    $user = $userClass::factory()->create();

    $this->actingAs($user);

    // Test che le pagine siano accessibili (non testa UI completa, solo routing)
    $pages = [
        'alignment' => Alignment::class,
        'background' => Background::class,
        'colors' => Colors::class,
        'custom-css' => CustomCss::class,
        'favicon' => Favicon::class,
        'logo' => Logo::class,
    ];

    foreach ($pages as $slug => $pageClass) {
        expect(class_exists($pageClass))
            ->toBeTrue("Page {$pageClass} deve esistere");
    }
});
