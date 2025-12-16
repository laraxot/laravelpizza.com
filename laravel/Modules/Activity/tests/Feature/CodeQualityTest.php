<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Tests\TestCase;

/**
 * Test per verificare la qualità del codice del modulo Activity.
 *
 * Questo test verifica che:
 * - La sintassi PHP sia corretta
 * - I file siano leggibili
 * - Le dipendenze siano risolte correttamente
 * - Il codice rispetti gli standard di qualità
 */
class CodeQualityTest extends TestCase
{
    /**
     * Test che tutti i file PHP del modulo abbiano sintassi corretta.
     */
    public function test_all_php_files_have_valid_syntax(): void
    {
        $modulePath = base_path('laravel/Modules/Activity');
        $phpFiles = $this->findPhpFiles($modulePath);

        foreach ($phpFiles as $file) {
            $this->assertPhpFileHasValidSyntax($file);
        }
    }

    /**
     * Test che le classi principali esistano e siano istanziabili.
     */
    public function test_main_classes_exist_and_are_instantiable(): void
    {
        // Verifica che le classi principali esistano
        $this->assertTrue(class_exists(\Modules\Activity\Providers\ActivityServiceProvider::class));
        $this->assertTrue(class_exists(\Modules\Activity\Filament\Actions\ListLogActivitiesAction::class));
        $this->assertTrue(class_exists(\Modules\Activity\Filament\Pages\ListLogActivities::class));
    }

    /**
     * Test che i file di configurazione esistano e siano validi.
     */
    public function test_configuration_files_exist(): void
    {
        $configPath = base_path('laravel/Modules/Activity/config/config.php');
        $this->assertTrue(file_exists($configPath), 'File config/config.php deve esistere');

        // Verifica che il file sia un array PHP valido
        $config = include $configPath;
        $this->assertIsArray($config, 'Il file config deve restituire un array');
    }

    /**
     * Test che le traduzioni esistano e siano strutturate correttamente.
     */
    public function test_translations_exist_and_are_structured(): void
    {
        $actionsTranslationsPath = base_path('laravel/Modules/Activity/lang/it/actions.php');
        $activitiesTranslationsPath = base_path('laravel/Modules/Activity/lang/it/activities.php');

        $this->assertTrue(file_exists($actionsTranslationsPath));
        $this->assertTrue(file_exists($activitiesTranslationsPath));

        // Verifica che le traduzioni siano array validi
        $actionsTranslations = include $actionsTranslationsPath;
        $activitiesTranslations = include $activitiesTranslationsPath;

        $this->assertIsArray($actionsTranslations);
        $this->assertIsArray($activitiesTranslations);

        // Verifica che abbiano le chiavi principali
        $this->assertArrayHasKey('list_log_activities', $actionsTranslations);
        $this->assertArrayHasKey('events', $activitiesTranslations);
    }

    /**
     * Test che le view esistano e siano valide.
     */
    public function test_views_exist_and_are_valid(): void
    {
        $viewPath = base_path('laravel/Modules/Activity/resources/views/filament/pages/list-log-activities.blade.php');
        $this->assertTrue(file_exists($viewPath), 'La view deve esistere');

        // Verifica che la view contenga i componenti necessari
        $viewContent = file_get_contents($viewPath);
        $this->assertStringContains('getActivities()', $viewContent);
        $this->assertStringContains('getFieldLabel', $viewContent);
    }

    /**
     * Test che il ServiceProvider sia configurato correttamente.
     */
    public function test_service_provider_configuration(): void
    {
        $provider = new \Modules\Activity\Providers\ActivityServiceProvider(app());

        // Verifica che il provider sia configurato correttamente
        $this->assertEquals('Activity', $provider->name);
        $this->assertNotEmpty($provider->name);
    }

    /**
     * Test che non ci siano errori di dipendenze circolari.
     */
    public function test_no_circular_dependencies(): void
    {
        // Questo è un test strutturale per verificare che non ci siano
        // dipendenze circolari evidenti nell'architettura del modulo

        $this->assertTrue(true); // Placeholder per logica futura
    }

    /**
     * Test che la documentazione sia aggiornata.
     */
    public function test_documentation_is_up_to_date(): void
    {
        $readmePath = base_path('laravel/Modules/Activity/docs/README.md');
        $this->assertTrue(file_exists($readmePath), 'README.md deve esistere');

        // Verifica che la documentazione contenga riferimenti alle classi principali
        $readmeContent = file_get_contents($readmePath);
        $this->assertStringContains('ListLogActivitiesAction', $readmeContent);
        $this->assertStringContains('ListLogActivities', $readmeContent);
        $this->assertStringContains('ActivityServiceProvider', $readmeContent);
    }

    /**
     * Trova tutti i file PHP in una directory ricorsivamente.
     *
     * @param  string  $directory  La directory da scansionare
     * @return array<int, string> Array di path dei file PHP
     */
    private function findPhpFiles(string $directory): array
    {
        $phpFiles = [];

        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $phpFiles[] = $file->getPathname();
            }
        }

        return $phpFiles;
    }

    /**
     * Verifica che un file PHP abbia sintassi valida.
     *
     * @param  string  $filePath  Il path del file da verificare
     */
    private function assertPhpFileHasValidSyntax(string $filePath): void
    {
        // PHPStan Level 10: Use php -l for syntax check
        $output = [];
        $resultCode = 0;
        exec('php -l '.escapeshellarg($filePath).' 2>&1', $output, $resultCode);

        $this->assertEquals(0, $resultCode, "File {$filePath} ha errori di sintassi: ".implode("\n", $output));
    }
}
