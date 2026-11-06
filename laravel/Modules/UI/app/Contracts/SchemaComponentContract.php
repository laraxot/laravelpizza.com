<?php

declare(strict_types=1);

namespace Modules\UI\Contracts;

/**
 * Componente Filament riutilizzabile basato su schema.org.
 * Ogni implementazione espone la schema come array di campi Filament,
 * prefissabile da chi la include (Resource, Page, Volt component).
 */
interface SchemaComponentContract
{
    /**
     * @param  string|null  $prefix  prefixo punto-andato per i nomi campo (es. "author.name")
     * @return array<int, mixed> array di campi Filament
     */
    public static function make(?string $prefix = null): array;

    /**
     * Tipo schema.org (es. "Person", "Event").
     */
    public static function type(): string;
}
