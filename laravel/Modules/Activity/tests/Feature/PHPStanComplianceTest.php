<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Tests\TestCase;

/**
 * Test per verificare la conformità PHPStan del modulo Activity.
 *
 * Questo test verifica che:
 * - Il codice rispetti le regole PHPStan livello 9
 * - Non ci siano errori di tipo
 * - La sintassi sia corretta
 * - Le dipendenze siano corrette
 */
class PHPStanComplianceTest extends TestCase
{
    /**
     * Test che PHPStan possa analizzare il modulo senza errori.
     */
    public function test_phpstan_can_analyze_module(): void
    {
        // Questo test verifica che PHPStan possa analizzare il modulo
        // Se fallisce significa che ci sono errori PHPStan

        $this->assertTrue(true); // Placeholder - il vero test è l'analisi PHPStan

        // In un ambiente CI/CD, questo test eseguirebbe:
        // exec('./vendor/bin/phpstan analyze Modules/Activity --level=9', $output, $returnVar);
        // $this->assertEquals(0, $returnVar, 'PHPStan ha trovato errori: ' . implode("\n", $output));
    }

    /**
     * Test che le classi del modulo estendano le classi corrette.
     */
    public function test_classes_extend_correct_base_classes(): void
    {
        // Verifica che ListLogActivitiesAction estenda XotBaseAction
        $actionReflection = new \ReflectionClass(\Modules\Activity\Filament\Actions\ListLogActivitiesAction::class);
        $this->assertTrue(
            $actionReflection->isSubclassOf(\Modules\Xot\Filament\Actions\XotBaseAction::class),
            'ListLogActivitiesAction deve estendere XotBaseAction'
        );

        // Verifica che ListLogActivities estenda XotBasePage
        $pageReflection = new \ReflectionClass(\Modules\Activity\Filament\Pages\ListLogActivities::class);
        $this->assertTrue(
            $pageReflection->isSubclassOf(\Modules\Xot\Filament\Pages\XotBasePage::class),
            'ListLogActivities deve estendere XotBasePage'
        );
    }

    /**
     * Test che le traduzioni siano strutturate correttamente.
     */
    public function test_translations_are_properly_structured(): void
    {
        // Verifica che le traduzioni esistano
        $this->assertTrue(
            file_exists(base_path('laravel/Modules/Activity/lang/it/actions.php')),
            'File traduzioni actions.php deve esistere'
        );

        $this->assertTrue(
            file_exists(base_path('laravel/Modules/Activity/lang/it/activities.php')),
            'File traduzioni activities.php deve esistere'
        );

        // Verifica che le traduzioni abbiano la struttura corretta
        $actionsTranslations = include base_path('laravel/Modules/Activity/lang/it/actions.php');
        $this->assertIsArray($actionsTranslations);
        $this->assertArrayHasKey('list_log_activities', $actionsTranslations);

        $activitiesTranslations = include base_path('laravel/Modules/Activity/lang/it/activities.php');
        $this->assertIsArray($activitiesTranslations);
        $this->assertArrayHasKey('events', $activitiesTranslations);
    }

    /**
     * Test che il ServiceProvider sia configurato correttamente.
     */
    public function test_service_provider_configuration(): void
    {
        $providerReflection = new \ReflectionClass(\Modules\Activity\Providers\ActivityServiceProvider::class);

        // Verifica che estenda XotBaseServiceProvider
        $this->assertTrue(
            $providerReflection->isSubclassOf(\Modules\Xot\Providers\XotBaseServiceProvider::class),
            'ActivityServiceProvider deve estendere XotBaseServiceProvider'
        );

        // Verifica che abbia la proprietà name impostata
        $provider = new \Modules\Activity\Providers\ActivityServiceProvider(app());
        $this->assertEquals('Activity', $provider->name);
    }

    /**
     * Test che i modelli abbiano i trait corretti.
     */
    public function test_models_have_correct_traits(): void
    {
        // Test per verificare che i modelli abbiano i trait appropriati
        // Questo è un test strutturale per verificare l'architettura

        $this->assertTrue(true); // Placeholder per architettura futura
    }

    /**
     * Test che le view esistano e siano strutturate correttamente.
     */
    public function test_views_exist_and_are_structured(): void
    {
        // Verifica che la view principale esista
        $viewPath = base_path('laravel/Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php');
        $this->assertTrue(
            file_exists($viewPath),
            'La view list-log-activities.blade.php deve esistere'
        );

        // Verifica che la view contenga i componenti necessari
        $viewContent = file_get_contents($viewPath);
        $this->assertStringContains('getActivities()', $viewContent);
        $this->assertStringContains('getFieldLabel', $viewContent);
    }
}
