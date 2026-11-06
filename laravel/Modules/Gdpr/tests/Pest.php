<?php

declare(strict_types=1);

/*
 * Bootstrap Pest — modulo Gdpr.
 * Il binding a \Modules\Gdpr\Tests\TestCase e' fatto solo qui sotto: i file test NON devono
 * dichiarare uses(TestCase::class) (altrimenti Pest\Exceptions\TestCaseAlreadyInUse).
 * Per estendere si usa l'API idiomatica di Pest — `pest()->extend(...)`, in fondo
 * a questo file — senza nessuna annotazione di soppressione: con
 * `pestphp/pest-plugin-phpstan 5.2.0` installato, `method.internalClass` non
 * viene piu' segnalato. Misurato il 2026-08-25 su tutti i bootstrap dei moduli:
 * `phpstan analyse Modules/<Modulo>/tests/Pest.php` = 0 errori.
 * Se ricomparisse, verificare che il plugin sia ancora caricato da
 * `phpstan/extension-installer`, non reintrodurre il divieto.
 * Vedi story XOT-5.41 e ROOT-17.6.
 */
require_once __DIR__.'/PestHelpers.php';
require_once __DIR__.'/PestStubs.php';

pest()->extend(Modules\Gdpr\Tests\TestCase::class)->in(__DIR__.'/Unit', __DIR__.'/Feature');
