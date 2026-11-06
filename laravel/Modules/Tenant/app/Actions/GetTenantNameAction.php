<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Safe\Exceptions\FilesystemException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\realpath;

/**
 * Action per ottenere il nome del tenant basato sul server name.
 */
class GetTenantNameAction
{
    use QueueableAction;

    /**
     * Esegue l'action per ottenere il nome del tenant.
     *
     * @return string Il nome del tenant
     */
    public function execute(): string
    {
        $default = $this->resolveDefaultHost();

        /** @var Collection<int, string> $parts */
        $parts = $this->buildServerParts($default);

        return $this->resolveFromParts($parts)
            ?? $this->resolveFromDefaultHost($default)
            ?? 'localhost';
    }

    private function resolveDefaultHost(): string
    {
        $default = config('app.url');

        if (! \is_string($default)) {
            $default = 'localhost';
        }

        return Str::after($default, '//');
    }

    /**
     * @return Collection<int, string>
     */
    private function buildServerParts(string $default): Collection
    {
        $serverName = Str::of($this->getServerName($default))->replace('www.', '')->toString();

        return collect(explode('.', $serverName))
            ->map(static fn (string $part): string => Str::slug($part))
            ->reverse()
            ->values();
    }

    /**
     * @param  Collection<int, string>  $parts
     */
    private function resolveFromParts(Collection $parts): ?string
    {
        $path = $this->buildConfigPath($parts);
        if (file_exists($path)) {
            return $this->tenantNameFromPath($path);
        }

        if ($parts->count() <= 2) {
            return null;
        }

        /** @var Collection<int, string> $shortenedParts */
        $shortenedParts = $parts->slice(0, -1);
        $shortenedPath = $this->buildConfigPath($shortenedParts);

        if (file_exists($shortenedPath)) {
            return $this->tenantNameFromPath($shortenedPath);
        }

        return null;
    }

    private function resolveFromDefaultHost(string $default): ?string
    {
        $defaultPath = implode('/', array_reverse(explode('.', $default)));
        $path = base_path('config/'.$defaultPath);

        if ($defaultPath === '' || ! file_exists($path)) {
            return null;
        }

        return $this->tenantNameFromPath($path);
    }

    /**
     * Un host può essere un symlink verso la config già caricata da Laravel.
     * La chiave di config usa il path reale (`local.fixcity`), non l'alias (`eu.fixcity`).
     */
    private function tenantNameFromPath(string $path): string
    {
        try {
            $real = realpath($path);
            $configRoot = realpath(config_path());
        } catch (FilesystemException) {
            return $this->logicalTenantName($path);
        }

        $prefix = $configRoot.DIRECTORY_SEPARATOR;
        if (! str_starts_with($real, $prefix)) {
            return $this->logicalTenantName($path);
        }

        return str_replace(DIRECTORY_SEPARATOR, '/', substr($real, strlen($prefix)));
    }

    private function logicalTenantName(string $path): string
    {
        $relative = ltrim(substr($path, strlen(config_path())), DIRECTORY_SEPARATOR);

        return str_replace(DIRECTORY_SEPARATOR, '/', $relative);
    }

    /**
     * Durante LoadConfiguration le facade non sono ancora disponibili — usare getenv.
     *
     * @param  string  $default  Il valore di default da usare
     */
    private function getServerName(string $default): string
    {
        $serverName = getenv('SERVER_NAME');
        if ((! is_string($serverName) || $serverName === '') && isset($_SERVER['SERVER_NAME']) && is_string($_SERVER['SERVER_NAME'])) {
            $serverName = $_SERVER['SERVER_NAME'];
        }

        if (is_string($serverName) && $serverName !== '' && $serverName !== '127.0.0.1') {
            return $serverName;
        }

        return $default;
    }

    /**
     * Costruisce il percorso di configurazione.
     *
     * @param  Collection<int, string>  $parts  Le parti del percorso
     * @return string Il percorso completo
     */
    private function buildConfigPath(Collection $parts): string
    {
        return config_path($parts->implode(DIRECTORY_SEPARATOR));
    }
}
