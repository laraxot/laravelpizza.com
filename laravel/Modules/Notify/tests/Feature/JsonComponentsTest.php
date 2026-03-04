<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Tests\TestCase;

uses(TestCase::class);

test('components json is valid and contains expected components', function (): void {
    // Percorso del file
    $filePath = base_path('Modules/Notify/app/Console/Commands/_components.json');

    // Verifico che il file esiste
    expect(File::exists($filePath))->toBeTrue('Il file _components.json non esiste');

    // Leggo il contenuto del file
    $content = File::get($filePath);

    // Decodifico il JSON
    $json = json_decode($content, true);

    // Verifico che il JSON è valido
    expect($json)->not->toBeNull('Il file _components.json non contiene JSON valido: '.json_last_error_msg());

    // Verifico che ci sono 3 componenti
    expect($json)->toHaveCount(3, 'Il file _components.json non contiene i 3 componenti attesi');

    // Verifico che ci sono i componenti SendMailCommand, TelegramWebhook e AnalyzeTranslationFiles
    foreach (range(0, 2) as $index) {
        expect($json[$index])->toHaveKey('name');
        expect($json[$index])->toHaveKey('class');
        expect($json[$index])->toHaveKey('ns');
    }

    // Verifico i nomi specifici dei componenti
    $names = array_column($json, 'name');
    expect($names)->toContain('send-mail-command');
    expect($names)->toContain('telegram-webhook');
    expect($names)->toContain('analyze-translation-files');

    // Verifico le classi specifiche dei componenti
    $classes = array_column($json, 'class');
    expect($classes)->toContain('SendMailCommand');
    expect($classes)->toContain('TelegramWebhook');
    expect($classes)->toContain('AnalyzeTranslationFiles');
});
