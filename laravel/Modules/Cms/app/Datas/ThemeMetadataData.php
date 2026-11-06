<?php

declare(strict_types=1);

namespace Modules\Cms\Datas;

use Spatie\LaravelData\Data;

/**
 * Value Object representing compiled theme metadata.
 * Should encapsulate brand colors, spacing scales, and breakpoints derived from design tokens.
 */
class ThemeMetadataData extends Data
{
    public function __construct(
        public string $primaryColorHex, // e.g., "#3B82F6"
        public string $secondaryColorHex,
        /** @var array<string, string> */
        public array $spacingUnits = ['sm' => '1rem', 'md' => '2rem', 'lg' => '4rem'],
        /** @var array<string, string> */
        public array $breakpoints = [
            'sm' => '640px',
            'md' => '768px',
            'lg' => '1024px',
        ],
    ) {
    }

    /**
     * Retrieves the spacing unit for a given scale key.
     *
     * @throws \InvalidArgumentException if the key does not exist
     */
    public function getSpacing(string $key): string
    {
        if (! isset($this->spacingUnits[$key])) {
            throw new \InvalidArgumentException("Invalid spacing unit key: {$key}");
        }

        return $this->spacingUnits[$key];
    }
}
