<?php

declare(strict_types=1);

/*
 * Helper dei test del modulo Gdpr (gdprGet(), gdprPost(), createGdprConsent(), ...).
 * Pest legge solo laravel/tests/Pest.php, che include questo file: qui NON va legato il TestCase
 * (ne' uses()->in() ne' pest()->extend()), che ogni file di test dichiara da se' con
 * uses(\Modules\Gdpr\Tests\TestCase::class). Vedi laravel/tests/Pest.php e QA-01.
 */
require_once __DIR__.'/PestHelpers.php';
require_once __DIR__.'/PestStubs.php';
