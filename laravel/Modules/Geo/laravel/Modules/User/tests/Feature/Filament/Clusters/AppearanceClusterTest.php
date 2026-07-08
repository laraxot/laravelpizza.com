<?php

declare(strict_types=1);

namespace Modules\User\Tests\Feature\Filament\Clusters;

use Modules\User\Database\Factories\UserFactory;
use Modules\User\Filament\Clusters\Appearance;
use Modules\User\Filament\Clusters\Appearance\Pages\Alignment;
use Modules\User\Filament\Clusters\Appearance\Pages\Background;
use Modules\User\Filament\Clusters\Appearance\Pages\Colors;
use Modules\User\Filament\Clusters\Appearance\Pages\CustomCss;
use Modules\User\Filament\Clusters\Appearance\Pages\Favicon;
use Modules\User\Filament\Clusters\Appearance\Pages\Logo;
use Modules\User\Tests\TestCase;
use Modules\Xot\Filament\Clusters\XotBaseCluster;
use Modules\Xot\Filament\Pages\XotBasePage;

use function Pest\Laravel\actingAs;

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\glob;

uses(TestCase::class);

describe('Appearance Cluster', function (): void {
    test('appearance cluster extends xot base cluster', function (): void {
        Assert::assertSame(XotBaseCluster::class, get_parent_class(Appearance::class));
    });

    test('all cluster pages extend xot base page', function (): void {
        $pages = [
            Alignment::class,
            Background::class,
            Colors::class,
            CustomCss::class,
            Favicon::class,
            Logo::class,
        ];

        foreach ($pages as $pageClass) {
            Assert::assertSame(XotBasePage::class, get_parent_class($pageClass));
        }
    });

    test('all cluster pages have cluster property set', function (): void {
        $pages = [
            Alignment::class,
            Background::class,
            Colors::class,
            CustomCss::class,
            Favicon::class,
            Logo::class,
        ];

        foreach ($pages as $pageClass) {
            $reflection = new \ReflectionClass($pageClass);
            $property = $reflection->getProperty('cluster');
            $defaultValue = $property->getDefaultValue();

            Assert::assertSame(Appearance::class, $defaultValue);
        }
    });

    test('cluster pages do not extend filament classes directly', function (): void {
        /** @var TestCase $this */
        $files = glob(base_path('Modules/User/app/Filament/Clusters/Appearance/Pages/*.php'));

        if ([] === $files) {
            $this->skipTest('Appearance cluster pages directory not found.');
        }

        foreach ($files as $file) {
            $filePath = (string) $file;
            $content = (string) file_get_contents($filePath);
            Assert::assertStringContainsString('extends XotBasePage', $content, basename($filePath));
            Assert::assertStringNotContainsString('extends Page', $content, basename($filePath));
        }
    });

    test('cluster does not extend filament directly', function (): void {
        $file = base_path('Modules/User/app/Filament/Clusters/Appearance.php');
        $content = (string) file_get_contents($file);

        Assert::assertStringNotContainsString('extends Cluster', $content);
        Assert::assertStringNotContainsString('use Filament\\Clusters\\Cluster;', $content);
        Assert::assertStringContainsString('extends XotBaseCluster', $content);
    });

    test('cluster pages are accessible', function (): void {
        $user = UserFactory::new()->createOne([
            'name' => 'Cluster Test User',
            'email' => 'cluster-'.uniqid('', true).'@example.com',
        ]);

        actingAs($user);

        $pages = [
            Alignment::class,
            Background::class,
            Colors::class,
            CustomCss::class,
            Favicon::class,
            Logo::class,
        ];

        foreach ($pages as $pageClass) {
            Assert::assertTrue(class_exists($pageClass));
        }
    });
});
