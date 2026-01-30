<?php

declare(strict_types=1);

use Tests\TestCase;
use Illuminate\Support\Facades\File;

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
    expect($json)->not->toBeNull('Il file _components.json non contiene JSON valido: ' . json_last_error_msg());

    // Verifico che ci sono 2 componenti
    expect($json)->toHaveCount(2, 'Il file _components.json non contiene i 2 componenti attesi');

    // Verifico che ci sono i componenti SendMailCommand e TelegramWebhook
    expect($json[0])->toHaveKey('name', 'Il primo componente non ha una chiave "name"');
    expect($json[0])->toHaveKey('class', 'Il primo componente non ha una chiave "class"');
    expect($json[0])->toHaveKey('ns', 'Il primo componente non ha una chiave "ns"');

    expect($json[1])->toHaveKey('name', 'Il secondo componente non ha una chiave "name"');
    expect($json[1])->toHaveKey('class', 'Il secondo componente non ha una chiave "class"');
    expect($json[1])->toHaveKey('ns', 'Il secondo componente non ha una chiave "ns"');

    // Verifico i nomi specifici dei componenti
    $names = array_column($json, 'name');
    expect($names)->toContain('send-mail-command', 'Componente "send-mail-command" non trovato');
    expect($names)->toContain('telegram-webhook', 'Componente "telegram-webhook" non trovato');

    // Verifico le classi specifiche dei componenti
    $classes = array_column($json, 'class');
    expect($classes)->toContain('SendMailCommand', 'Classe "SendMailCommand" non trovata');
    expect($classes)->toContain('TelegramWebhook', 'Classe "TelegramWebhook" non trovata');
});
