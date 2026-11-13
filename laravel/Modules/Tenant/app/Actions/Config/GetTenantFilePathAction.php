<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Actions\GetTenantNameAction;
use Spatie\QueueableAction\QueueableAction;

class GetTenantFilePathAction
{
    use QueueableAction;

    public function execute(string $filename): string
    {
        $normalizedFilename = str_replace('\\', '/', $filename);
        if (str_starts_with($normalizedFilename, '/') || str_contains($filename, "\0") || in_array('..', explode('/', $normalizedFilename), true)) {
            throw new InvalidArgumentException('Tenant filename must be a relative path without traversal segments.');
        }

        $tenantName = app(GetTenantNameAction::class)->execute();
        $path = base_path('config/'.$tenantName.'/'.$filename);

        // I contenuti JSON (Sushi: pagine, sezioni, menu...) sono dati del sito, versionati in config/<tenant>.
        // Durante i test ogni Model::create() scriverebbe un file li' dentro e lo finirebbe in git: si usa
        // una copia usa-e-getta sotto storage. Le altre config del tenant (database.php, xra.php...) restano reali.
        if (app()->runningUnitTests() && str_starts_with($normalizedFilename, 'database/content/')) {
            $sourcePath = $path;
            self::prepareTestingContent($tenantName);
            $path = storage_path('framework/testing/tenant-content/'.$tenantName.'/'.$filename);

            // Seed the isolated store lazily so read-only tests exercise the same
            // versioned content as production without ever writing back to config/.
            if (is_dir($sourcePath) && ! is_dir($path)) {
                File::copyDirectory($sourcePath, $path);
            } elseif (is_file($sourcePath) && ! is_file($path)) {
                File::ensureDirectoryExists(dirname($path));
                File::copy($sourcePath, $path);
            }
        }

        return str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
    }

    /** @var array<string, true> tenant gia' copiati in questo processo di test */
    private static array $preparedTestingTenants = [];

    /**
     * La copia usa-e-getta dei contenuti va riempita: senza, nei test non esisteva nessuna pagina CMS (privacy, note legali,
     * area personale, conferma...) e 210 test Fixcity rispondevano 404. Una volta per processo si riparte dai JSON versionati,
     * cosi' le scritture di un'esecuzione precedente non restano.
     */
    private static function prepareTestingContent(string $tenantName): void
    {
        if (isset(self::$preparedTestingTenants[$tenantName])) {
            return;
        }
        self::$preparedTestingTenants[$tenantName] = true;

        $source = base_path('config/'.$tenantName.'/database/content');
        $target = storage_path('framework/testing/tenant-content/'.$tenantName.'/database/content');
        File::deleteDirectory($target);
        if (File::isDirectory($source)) {
            File::copyDirectory($source, $target);
        }
    }
}
