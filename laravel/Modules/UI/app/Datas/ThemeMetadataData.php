<?php

declare(strict_types=1);

namespace Modules\UI\Datas;

use Spatie\LaravelData\Data;

/**
 * Metadati tema compilati: colori brand, scale spaziatura, breakpoint da design token.
 */
class ThemeMetadataData extends Data
{
    /**
     * @param  array<string, string>  $spacingUnits
     * @param  array<string, string>  $breakpoints
     */
    public function __construct(
        public readonly string $primaryColorHex,
        public readonly string $secondaryColorHex,
        public readonly array $spacingUnits = ['sm' => '1rem', 'md' => '2rem', 'lg' => '4rem'],
        public readonly array $breakpoints = [
            'sm' => '640px',
            'md' => '768px',
            'lg' => '1024px',
        ],
    ) {}

    /**
     * @throws \InvalidArgumentException se la chiave non esiste
     */
    public function getSpacing(string $key): string
    {
        if (! isset($this->spacingUnits[$key])) {
            throw new \InvalidArgumentException("Invalid spacing unit key: {$key}");
        }

        return $this->spacingUnits[$key];
    }
}
