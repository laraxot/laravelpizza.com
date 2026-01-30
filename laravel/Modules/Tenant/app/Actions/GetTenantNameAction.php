<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

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
        $default = config('app.url');

        if (! \is_string($default)) {
            $default = 'localhost';
        }

        $default = Str::after($default, '//');

        $server_name = $this->getServerName($default);
        $server_name = Str::of($server_name)->replace('www.', '')->toString();

        /** @var Collection<int, string> $parts */
        $parts = collect(explode('.', $server_name))
            ->map(fn (string $part): string => Str::slug($part))
            ->reverse()
            ->values();

        // Prova il percorso completo
        $config_file = $this->buildConfigPath($parts);
        if (file_exists($config_file)) {
            return $parts->implode('/');
        }

        // Prova il percorso senza l'ultimo segmento se ci sono più di 2 parti
        if ($parts->count() > 2) {
            /** @var Collection<int, string> $shortened_parts */
            $shortened_parts = $parts->slice(0, -1);
            $config_file = $this->buildConfigPath($shortened_parts);
            if (file_exists($config_file)) {
                return $shortened_parts->implode('/');
            }
        }

        // Fallback al default
        $part = explode('.', $default);
        $inverted = array_reverse($part);
        $default_path = implode('/', $inverted);
        if ($default_path !== '' && file_exists(base_path('config/'.$default_path))) {
            return $default_path;
        }

        return 'localhost';
    }

    /**
     * Ottiene il nome del server con fallback al default.
     *
     * @param  string  $default  Il valore di default da usare
     * @return string Il nome del server
     */
    private function getServerName(string $default): string
    {
        if (
            isset($_SERVER['SERVER_NAME']) &&
                $_SERVER['SERVER_NAME'] !== '127.0.0.1' &&
                is_string($_SERVER['SERVER_NAME'])
        ) {
            return $_SERVER['SERVER_NAME'];
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
