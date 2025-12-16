<?php

declare(strict_types=1);

namespace Modules\Xot\Contracts;

use Throwable;

/**
 * Contratto per i formattatori di errori.
 * Definisce l'interfaccia standard per la formattazione degli errori nel sistema.
 */
interface ErrorFormatterContract
{
    /**
     * Costruttore che accetta l'eccezione da formattare.
     */
    public function __construct(Throwable $exception);

    /**
     * Formatta l'eccezione in un array strutturato.
     *
     * @return array<string, mixed>
     */
    public function format(): array;
}
