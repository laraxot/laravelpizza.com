<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Cms\Models\Conf;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Module;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;

/**
 * Seeder per creare dati di test per il modulo CMS.
 *
 * Usage: php artisan db:seed --class=Modules\\Cms\\Database\\Seeders\\CmsMassSeeder
 */
class CmsMassSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        $this->command->info('Inizializzazione seeding di massa per modulo Cms...');

        $startTime = microtime(true);

        try {
            $this->createCmsModules();
            $this->createSections();
            $this->createPages();
            $this->createPageContents();
            $this->createMenus();
            $this->createConfigurations();

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            $this->command->info("Seeding modulo Cms completato in {$executionTime} secondi.");
            $this->displaySummary();
        } catch (\Exception $e) {
            $this->command->error('Errore durante il seeding: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Carica moduli CMS esistenti.
     */
    private function createCmsModules(): void
    {
        $this->command->info('Caricamento moduli CMS...');

        $modules = Module::all();
        $this->command->info('Caricati '.$modules->count().' moduli.');
    }

    /**
     * Crea sezioni di test.
     */
    private function createSections(): void
    {
        $this->command->info('Creazione sezioni...');

        $sectionCount = 0;
        $this->command->info('Create '.$sectionCount.' sezioni.');
    }

    /**
     * Crea pagine di test.
     */
    private function createPages(): void
    {
        $this->command->info('Creazione pagine...');

        $pageCount = 0;
        $this->command->info('Create '.$pageCount.' pagine.');
    }

    /**
     * Crea contenuti di test.
     */
    private function createPageContents(): void
    {
        $this->command->info('Creazione contenuti delle pagine...');

        $contentCount = 0;
        $this->command->info('Creati '.$contentCount.' contenuti di pagina.');
    }

    /**
     * Crea menu di test.
     */
    private function createMenus(): void
    {
        $this->command->info('Creazione menu...');

        $menuCount = 0;
        $this->command->info('Creati '.$menuCount.' menu.');
    }

    /**
     * Carica configurazioni esistenti.
     */
    private function createConfigurations(): void
    {
        $this->command->info('Creazione configurazioni...');

        $configs = Conf::all();
        $this->command->info('Caricati '.$configs->count().' config.');
    }

    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        $this->command->info('RIASSUNTO DATI CREATI PER MODULO CMS:');
        $this->command->info('-------------------------------------');

        try {
            // Conta moduli
            $totalModules = Module::count();
            $this->command->info('Moduli totali: '.str_pad((string) $totalModules, 6, ' ', STR_PAD_LEFT));

            // Conta sezioni
            $totalSections = Section::count();
            $this->command->info('Sezioni totali: '.str_pad((string) $totalSections, 6, ' ', STR_PAD_LEFT));

            // Conta pagine
            $totalPages = Page::count();
            $this->command->info('Pagine totali: '.str_pad((string) $totalPages, 6, ' ', STR_PAD_LEFT));

            // Conta contenuti
            $totalContents = PageContent::count();
            $this->command->info('Contenuti totali: '.str_pad((string) $totalContents, 6, ' ', STR_PAD_LEFT));

            // Conta menu
            $totalMenus = Menu::count();
            $this->command->info('Menu totali: '.str_pad((string) $totalMenus, 6, ' ', STR_PAD_LEFT));

            // Conta configurazioni
            try {
                $totalConfigs = Conf::count();
            } catch (\Exception $e) {
                $totalConfigs = 0;
            }

            $this->command->info('Configurazioni totali: '.str_pad((string) $totalConfigs, 6, ' ', STR_PAD_LEFT));
        } catch (\Exception $e) {
            $this->command->info('Errore nel conteggio: '.$e->getMessage());
        }

        $this->command->info('-------------------------------------');
        $this->command->info('');
    }
}
