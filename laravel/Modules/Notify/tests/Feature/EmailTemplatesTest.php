<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Tests\TestCase;

uses(TestCase::class);

test('html template contains optional function', function (): void {
    // Percorso del file
    $filePath = base_path('Modules/Notify/resources/views/emails/html.blade.php');

    // Verifico che il file esiste
    $this->assertTrue(File::exists($filePath), 'Il file html.blade.php non esiste');

    // Leggo il contenuto del file
    $content = File::get($filePath);

    // Verifico che il template supporti subject e body_html
    $this->assertStringContainsString('subject', $content, 'Il template html.blade.php non gestisce subject');
    $this->assertStringContainsString('body_html', $content, 'Il template html.blade.php non gestisce body_html');

    // Preferito: optional($email_data)->subject / body_html
    // Accettiamo anche fallback su $subject se presente.
    $hasEmailData = str_contains($content, 'email_data');
    $hasOptional = str_contains($content, 'optional(');
    $hasSubjectVar = str_contains($content, '$subject');

    $this->assertTrue($hasEmailData || $hasSubjectVar, 'Il template html.blade.php non gestisce subject via $email_data o $subject');
    $this->assertTrue($hasOptional, 'Il template html.blade.php non utilizza optional() per gestire dati email');
});

test('sunny sample template exists', function (): void {
    // Percorso del file (nel repo è sotto emails/samples)
    $filePath = base_path('Modules/Notify/resources/views/emails/samples/sunny.blade.php');

    // Verifico che il file esiste
    $this->assertTrue(File::exists($filePath), 'Il file sunny.blade.php non esiste');

    // Leggo il contenuto del file
    $content = File::get($filePath);

    // Smoke: è un sample che estende un template
    $this->assertStringContainsString('@extends', $content, 'Il template sunny sample non estende un template');
});

test('ark sample template exists', function (): void {
    // Percorso del file (nel repo è sotto emails/samples)
    $filePath = base_path('Modules/Notify/resources/views/emails/samples/ark.blade.php');

    // Verifico che il file esiste
    $this->assertTrue(File::exists($filePath), 'Il file ark.blade.php non esiste');

    // Leggo il contenuto del file
    $content = File::get($filePath);

    // Smoke: è un sample che estende un template
    $this->assertStringContainsString('@extends', $content, 'Il template ark sample non estende un template');
});
