<?php

declare(strict_types=1);

namespace Modules\Cms\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Modules\Cms\Models\Conf;
use Modules\Cms\Models\Menu;
use Modules\Cms\Models\Module;
use Modules\Cms\Models\Page;
use Modules\Cms\Models\PageContent;
use Modules\Cms\Models\Section;

/**
 * Seeder per creare grandi quantità di dati per il modulo Cms.
 */
class CmsMassSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Esegue il seeding del database.
     */
    public function run(): void
    {
        $this->command->info('🚀 Inizializzazione seeding di massa per modulo Cms...');

        $startTime = microtime(true);

        try {
            // 1. Creazione moduli CMS
            $this->createCmsModules();

            // 2. Creazione sezioni
            $this->createSections();

            // 3. Creazione pagine
            $this->createPages();

            // 4. Creazione contenuti delle pagine
            $this->createPageContents();

            // 5. Creazione menu
            $this->createMenus();

            // 6. Creazione configurazioni
            $this->createConfigurations();

            $endTime = microtime(true);
            $executionTime = round($endTime - $startTime, 2);

            $this->command->info("🎉 Seeding modulo Cms completato in {$executionTime} secondi!");
            $this->displaySummary();
        } catch (\Exception $e) {
            $this->command->error('❌ Errore durante il seeding: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Crea moduli CMS.
     */
    private function createCmsModules(): void
    {
        $this->command->info('🔧 Creazione moduli CMS...');

        // Module is a Sushi model and doesn't support factories
        // Data is loaded dynamically from NwModule::getByStatus(1)
        $modules = Module::all();

        $this->command->info('✅ Loaded '.$modules->count().' CMS modules');
    }

    /**
     * Crea sezioni.
     */
    private function createSections(): void
    {
        $this->command->info('📑 Creazione sezioni...');

        // Crea 100 sezioni
        /** @phpstan-ignore-next-line */
        $sections = Section::factory(100)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
        /** @var Collection<int, Section> $sections */
        $sectionCount = is_object($sections) && method_exists($sections, 'count') ? $sections->count() : 0;
        $this->command->info('✅ Create '.$sectionCount.' sezioni');
    }

    /**
     * Crea pagine.
     */
    private function createPages(): void
    {
        $this->command->info('📄 Creazione pagine...');

        // Crea 500 pagine
        /** @phpstan-ignore-next-line */
        $pages = Page::factory(500)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
        /** @var Collection<int, Page> $pages */
        $pageCount = is_object($pages) && method_exists($pages, 'count') ? $pages->count() : 0;
        $this->command->info('✅ Create '.$pageCount.' pagine');
    }

    /**
     * Crea contenuti delle pagine.
     */
    private function createPageContents(): void
    {
        $this->command->info('📝 Creazione contenuti delle pagine...');

        // Crea 1000 contenuti di pagina
        /** @phpstan-ignore-next-line */
        $contents = PageContent::factory(1000)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
        /** @var Collection<int, PageContent> $contents */
        $contentCount = is_object($contents) && method_exists($contents, 'count') ? $contents->count() : 0;
        $this->command->info('✅ Creati '.$contentCount.' contenuti di pagina');
    }

    /**
     * Crea menu.
     */
    private function createMenus(): void
    {
        $this->command->info('🍽️ Creazione menu...');

        // Crea 50 menu
        /** @phpstan-ignore-next-line */
        $menus = Menu::factory(50)->create([
            'created_at' => Carbon::now()->subDays(rand(1, 365)),
        ]);
        /** @var Collection<int, Menu> $menus */
        $menuCount = is_object($menus) && method_exists($menus, 'count') ? $menus->count() : 0;
        $this->command->info('✅ Creati '.$menuCount.' menu');
    }

    /**
     * Crea configurazioni.
     */
    private function createConfigurations(): void
    {
        $this->command->info('⚙️ Creazione configurazioni...');

        // Conf è un modello Sushi che ottiene i dati da TenantService::getConfigNames()
        // Non supporta factories, i dati sono caricati dinamicamente
        $configs = Conf::all();

        $this->command->info('✅ Caricati '.$configs->count().' configurazioni da Sushi');
    }

    /**
     * Mostra un riassunto dei dati creati.
     */
    private function displaySummary(): void
    {
        $this->command->info('📊 RIASSUNTO DATI CREATI PER MODULO CMS:');
        $this->command->info('┌─────────────────────────────────────┐');

        try {
            // Conta moduli
            $totalModules = Module::count();

            $this->command->info('│ 🔧 Moduli totali:             '.
            str_pad((string) $totalModules, 6, ' ', STR_PAD_LEFT).
                ' │');

            // Conta sezioni
            $totalSections = Section::count();

            $this->command->info('│ 📑 Sezioni totali:            '.
            str_pad((string) $totalSections, 6, ' ', STR_PAD_LEFT).
                ' │');

            // Conta pagine
            $totalPages = Page::count();

            $this->command->info('│ 📄 Pagine totali:             '.
            str_pad((string) $totalPages, 6, ' ', STR_PAD_LEFT).
                ' │');

            // Conta contenuti
            $totalContents = PageContent::count();

            $this->command->info('│ 📝 Contenuti totali:          '.
            str_pad((string) $totalContents, 6, ' ', STR_PAD_LEFT).
                ' │');

            // Conta menu
            $totalMenus = Menu::count();

            $this->command->info('│ 🍽️ Menu totali:               '.
            str_pad((string) $totalMenus, 6, ' ', STR_PAD_LEFT).
                ' │');

            // Conta configurazioni
            try {
                $totalConfigs = Conf::count();
            } catch (\Exception $e) {
                $totalConfigs = 0;
            }

            $this->command->info('│ ⚙️ Configurazioni totali:     '.
            str_pad((string) $totalConfigs, 6, ' ', STR_PAD_LEFT).
                ' │');
        } catch (\Exception $e) {
            $this->command->info('│ ❌ Errore nel conteggio: '.$e->getMessage());
        }

        $this->command->info('└─────────────────────────────────────┘');
        $this->command->info('');
    }
}
