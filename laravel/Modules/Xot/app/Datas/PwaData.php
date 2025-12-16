<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Spatie\LaravelData\Data;

/**
 * Class PwaData - Gestisce la configurazione PWA per il framework Laraxot.
 * Utilizzato esclusivamente nell'ambito dell'architettura Filament-first.
 */
class PwaData extends Data
{
    /**
     * @param  bool  $enable  Se il PWA è abilitato
     * @param  string  $name  Nome dell'applicazione
     * @param  string  $short_name  Nome breve dell'applicazione
     * @param  string  $description  Descrizione dell'applicazione
     * @param  string  $background_color  Colore di sfondo
     * @param  string  $theme_color  Colore del tema
     * @param  string  $icon_path  Percorso dell'icona
     * @param  array<string, string>  $splash  Configurazione splash screen
     */
    public function __construct(
        public readonly bool $enable = false,
        public readonly string $name = 'Laraxot App',
        public readonly string $short_name = 'Laraxot',
        public readonly string $description = 'Laraxot Framework Application',
        public readonly string $background_color = '#ffffff',
        public readonly string $theme_color = '#000000',
        public readonly string $icon_path = 'img/icons',
        public readonly array $splash = [
            '640x1136' => 'img/splash/splash-640x1136.png',
            '750x1334' => 'img/splash/splash-750x1334.png',
            '1242x2208' => 'img/splash/splash-1242x2208.png',
            '1125x2436' => 'img/splash/splash-1125x2436.png',
        ],
    ) {}

    /**
     * Create a new instance of PwaData with default values.
     */
    public static function make(): static
    {
        return new static;
    }
}
