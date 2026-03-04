<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

/**
 * Class FilemanagerData - Gestisce la configurazione del file manager per il framework Laraxot.
 * Utilizzato esclusivamente nell'ambito dell'architettura Filament-first.
 */
class FilemanagerData extends Data
{
    /**
     * @param  string  $disk  Disco di storage predefinito
     * @param  array  $disks  Dischi di storage disponibili
     * @param  array  $allowed_ext  Estensioni file consentite
     * @param  int  $max_size  Dimensione massima file in MB
     * @param  string  $route_prefix  Prefisso per le rotte del file manager
     * @param  bool  $enable_crop  Abilita il crop delle immagini
     */
    public function __construct(
        public readonly string $disk = 'public',
        public readonly array $disks = ['public'],
        public readonly array $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'zip'],
        public readonly int $max_size = 10,
        public readonly string $route_prefix = 'filemanager',
        public readonly bool $enable_crop = true,
    ) {}

    /**
     * Create a new instance of FilemanagerData with default values.
     */
    public static function make(): static
    {
        return new static;
    }
}
