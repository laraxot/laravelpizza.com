<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Notify\Tests\TestCase;

use function Safe\json_decode;

uses(TestCase::class);

test('components json is valid and contains expected components', function (): void {
    // Percorso del file
    $filePath = base_path('Modules/Notify/app/Console/Commands/_components.json');

    // Verifico che il file esiste
    /** @phpstan-ignore method.internalClass */
    expect(File::exists($filePath))->toBeTrue('Il file _components.json non esiste');

    // Leggo il contenuto del file
    $content = File::get($filePath);

    // Decodifico il JSON
    /** @var array<int, array<string, string>> $json */
    $json = json_decode($content, true);

    // Verifico che il JSON è valido
    /** @phpstan-ignore method.internalClass */
    expect($json)->not->toBeNull('Il file _components.json non contiene JSON valido: '.json_last_error_msg());

    // Verifico che ci sono 2 componenti
    /** @phpstan-ignore method.internalClass */
    expect($json)->toHaveCount(2, 'Il file _components.json non contiene i 2 componenti attesi');

    // Verifico che ci sono i componenti SendMailCommand e TelegramWebhook
    /** @phpstan-ignore method.internalClass */
    expect($json[0])->toHaveKey('name', 'Il primo componente non ha una chiave "name"');
    /** @phpstan-ignore method.internalClass */
    expect($json[0])->toHaveKey('class', 'Il primo componente non ha una chiave "class"');
    /** @phpstan-ignore method.internalClass */
    expect($json[0])->toHaveKey('ns', 'Il primo componente non ha una chiave "ns"');

    /** @phpstan-ignore method.internalClass */
    expect($json[1])->toHaveKey('name', 'Il secondo componente non ha una chiave "name"');
    /** @phpstan-ignore method.internalClass */
    expect($json[1])->toHaveKey('class', 'Il secondo componente non ha una chiave "class"');
    /** @phpstan-ignore method.internalClass */
    expect($json[1])->toHaveKey('ns', 'Il secondo componente non ha una chiave "ns"');

    // Verifico i nomi specifici dei componenti
    $names = array_column($json, 'name');
    /** @phpstan-ignore method.internalClass */
    expect($names)->toContain('send-mail-command', 'Componente "send-mail-command" non trovato');
    /** @phpstan-ignore method.internalClass */
    expect($names)->toContain('telegram-webhook', 'Componente "telegram-webhook" non trovato');

    // Verifico le classi specifiche dei componenti
    $classes = array_column($json, 'class');
    /** @phpstan-ignore method.internalClass */
    expect($classes)->toContain('SendMailCommand', 'Classe "SendMailCommand" non trovata');
    /** @phpstan-ignore method.internalClass */
    expect($classes)->toContain('TelegramWebhook', 'Classe "TelegramWebhook" non trovata');
});
