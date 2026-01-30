<?php

declare(strict_types=1);

namespace Modules\DbForge\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Modules\Xot\Helpers\ResourceFormSchemaGenerator;

class GenerateResourceFormSchemaCommand extends Command
{
    protected $signature = 'xot:generate-resource-form-schema {--module=} {--resource=}';

    protected $description = 'Genera gli schemi dei form per le risorse Filament';

    public function handle(): int
    {
        $moduleOption = $this->option('module');
        $resourceOption = $this->option('resource');

        $module = is_string($moduleOption) ? $moduleOption : '';
        $resource = is_string($resourceOption) ? $resourceOption : '';

        try {
            if ($module && $resource) {
                // Generazione per una risorsa specifica
                $fullClassName = "Modules\\{$module}\\Filament\\Resources\\{$resource}Resource";

                if (! class_exists($fullClassName)) {
                    $this->error("La risorsa {$fullClassName} non esiste");

                    return Command::FAILURE;
                }

                /** @var class-string $fullClassName */
                $result = ResourceFormSchemaGenerator::generateFormSchema($fullClassName);

                if ($result) {
                    $this->info("Schema del form generato con successo per {$fullClassName}");
                } else {
                    $this->warn("Schema del form già esistente per {$fullClassName}");
                }
            } elseif ($module) {
                // Per ora, questo caso non è supportato da ResourceFormSchemaGenerator
                $this->error('Generazione per modulo specifico non ancora supportata. Usa --resource insieme a --module');

                return Command::FAILURE;
            } else {
                // Generazione per tutte le risorse
                $results = ResourceFormSchemaGenerator::generateForAllResources();

                $this->info('Risultati generazione schema form:');
                $this->info('Risorse aggiornate: '.count($results['updated']));

                foreach ($results['updated'] as $resource) {
                    $this->line("  ✓ {$resource}");
                }

                if (! empty($results['skipped'])) {
                    $this->warn('Risorse saltate: '.count($results['skipped']));
                    foreach ($results['skipped'] as $skipped) {
                        $this->line("  - {$skipped}");
                    }
                }
            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            $this->error('Errore durante la generazione: '.$e->getMessage());

            return Command::FAILURE;
        }
    }
}
