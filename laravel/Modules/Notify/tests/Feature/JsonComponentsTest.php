<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Notify\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

uses(TestCase::class);
test('components json is valid and contains expected components', function (): void {
    // Percorso del file
    $filePath = base_path('Modules/Notify/app/Console/Commands/_components.json');

    // Verifico che il file esiste
    expect(File::exists($filePath))->toBeTrue('Il file _components.json non esiste');

    // Leggo il contenuto del file
    $content = File::get($filePath);

    // Decodifico il JSON (Safe\json_decode lancia se il JSON non e' valido)
    $json = json_decode($content, true);

    // Verifico che il JSON è una lista di componenti
    Assert::assertIsArray($json, 'Il file _components.json non contiene un array di componenti');

    // Verifico che c'e' un componente per ogni comando della cartella
    $commandFiles = File::glob(dirname($filePath).'/*.php');
    expect($json)->toHaveCount(count($commandFiles));

    // Verifico che ogni componente ha name, class e ns
    foreach ($json as $component) {
        expect($component)->toBeArray()->toHaveKeys(['name', 'class', 'ns']);
    }

    // Verifico i nomi specifici dei componenti
    $names = array_column($json, 'name');
    expect($names)->toContain('send-mail-command', 'telegram-webhook');

    // Verifico le classi specifiche dei componenti
    $classes = array_column($json, 'class');
    expect($classes)->toContain('SendMailCommand', 'TelegramWebhook');
});
