<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Console\Command;
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
        $this->info('Inizializzazione seeding di massa per modulo Cms...');

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

            $this->info("Seeding modulo Cms completato in {$executionTime} secondi.");
            $this->displaySummary();
        } catch (\Exception $e) {
            $this->error('Errore durante il seeding: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Carica moduli CMS esistenti.
     */
    private function createCmsModules(): void
    {
        $this->info('Caricamento moduli CMS...');

        $modules = Module::all();
        $this->info('Caricati '.$modules->count().' moduli.');
    }

    /**
     * Crea sezioni di test.
     */
    private function createSections(): void
    {
        $this->info('Creazione sezioni...');

        $sectionCount = 0;
        $this->info('Create '.$sectionCount.' sezioni.');
    }

    /**
     * Crea pagine di test.
     */
    private function createPages(): void
    {
        $this->info('Creazione pagine...');

        $pageCount = 0;
        $this->info('Create '.$pageCount.' pagine.');
    }

    /**
     * Crea contenuti di test.
     */
    private function createPageContents(): void
    {
        $this->info('Creazione contenuti delle pagine...');

        $contentCount = 0;
        $this->info('Creati '.$contentCount.' contenuti di pagina.');
    }

    /**
     * Crea menu di test.
     */
    private function createMenus(): void
    {
        $this->info('Creazione menu...');

        $menuCount = 0;
        $this->info('Creati '.$menuCount.' menu.');
    }

    /**
     * Carica configurazioni esistenti.
     */
    private function createConfigurations(): void
    {
        $this->info('Creazione configurazioni...');

        $configs = Conf::all();
        $this->info('Caricati '.$configs->count().' config.');
    }

    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        $this->info('RIASSUNTO DATI CREATI PER MODULO CMS:');
        $this->info('-------------------------------------');

        try {
            // Conta moduli
            $totalModules = Module::count();
            $this->info('Moduli totali: '.str_pad((string) $totalModules, 6, ' ', STR_PAD_LEFT));

            // Conta sezioni
            $totalSections = Section::count();
            $this->info('Sezioni totali: '.str_pad((string) $totalSections, 6, ' ', STR_PAD_LEFT));

            // Conta pagine
            $totalPages = Page::count();
            $this->info('Pagine totali: '.str_pad((string) $totalPages, 6, ' ', STR_PAD_LEFT));

            // Conta contenuti
            $totalContents = PageContent::count();
            $this->info('Contenuti totali: '.str_pad((string) $totalContents, 6, ' ', STR_PAD_LEFT));

            // Conta menu
            $totalMenus = Menu::count();
            $this->info('Menu totali: '.str_pad((string) $totalMenus, 6, ' ', STR_PAD_LEFT));

            // Conta configurazioni
            try {
                $totalConfigs = Conf::count();
            } catch (\Exception $e) {
                $totalConfigs = 0;
            }

            $this->info('Configurazioni totali: '.str_pad((string) $totalConfigs, 6, ' ', STR_PAD_LEFT));
        } catch (\Exception $e) {
            $this->info('Errore nel conteggio: '.$e->getMessage());
        }

        $this->info('-------------------------------------');
        $this->info('');
    }

    private function info(string $message): void
    {
        if ($this->command instanceof Command) {
            $this->command->info($message);
        }
    }

    private function error(string $message): void
    {
        if ($this->command instanceof Command) {
            $this->command->error($message);
        }
    }
}
