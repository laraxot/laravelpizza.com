<?php

declare(strict_types=1);

namespace Modules\Seo\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Modules\Seo\Actions\Robots\BuildRobotsTxtAction;

/**
 * Scrive `robots.txt` come file vero nella document root.
 *
 * La configurazione nginx di serie di Laravel ha `location = /robots.txt` (solo file statico): senza il file la
 * richiesta ricade su Laravel tramite `error_page 404`, il contenuto della rotta `seo.robots` arriva giusto ma con
 * stato 404, e Google lo ignora (sitemap compresa). Lanciato da `deploy.sh` a ogni rilascio, con lo stesso contenuto
 * della rotta.
 */
final class WriteRobotsTxtCommand extends Command
{
    protected $signature = 'seo:robots
                            {--path= : Percorso del file (predefinito: public_path("robots.txt"))}
                            {--dry-run : Stampa il contenuto senza scrivere}';

    protected $description = 'Scrive robots.txt nella document root con lo stesso contenuto della rotta /robots.txt';

    public function handle(BuildRobotsTxtAction $action): int
    {
        $content = $action->execute();

        if ((bool) $this->option('dry-run')) {
            $this->line($content);

            return self::SUCCESS;
        }

        $option = $this->option('path');
        $path = \is_string($option) && $option !== '' ? $option : public_path('robots.txt');

        File::put($path, $content);
        $this->info('robots.txt scritto in '.$path);

        return self::SUCCESS;
    }
}
