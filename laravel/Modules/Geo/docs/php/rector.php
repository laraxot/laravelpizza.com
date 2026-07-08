<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

/**
 * Configurazione Rector per l'analisi statica e la trasformazione automatica del codice
 *
 * Perché: Rector è uno strumento essenziale per mantenere la qualità del codice e facilitare
 * l'aggiornamento automatico a nuove versioni di PHP e alle best practices più recenti.
 *
 */
return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/',
    ])
    ->withSkip([
        __DIR__.'/vendor',
    ])
    // Imposta la compatibilità con la versione PHP corrente
    ->withPhpSets()
    ->withRules([
        // Regole di trasformazione, attualmente commentate
        // AddVoidReturnTypeWhereNoReturnRector::class,
    ]);

