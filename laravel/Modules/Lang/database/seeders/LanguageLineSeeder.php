<?php

declare(strict_types=1);

namespace Modules\Lang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Lang\Models\LanguageLine;

/**
 * LanguageLine — override DB per traduzioni (spatie/laravel-translation-loader).
 * Chiavi reali di framework, idempotente su (group, key, locale).
 */
class LanguageLineSeeder extends Seeder
{
    /** @var list<array{group: string, key: string, locale: string, text: array<string, string>}> */
    private const array ENTRIES = [
        [
            'group' => 'auth',
            'key' => 'failed',
            'locale' => 'it',
            'text' => ['it' => 'Credenziali non valide.'],
        ],
        [
            'group' => 'auth',
            'key' => 'failed',
            'locale' => 'en',
            'text' => ['en' => 'These credentials do not match our records.'],
        ],
        [
            'group' => 'pagination',
            'key' => 'next',
            'locale' => 'it',
            'text' => ['it' => 'Successivo &raquo;'],
        ],
        [
            'group' => 'pagination',
            'key' => 'previous',
            'locale' => 'it',
            'text' => ['it' => '&laquo; Precedente'],
        ],
    ];

    public function run(): void
    {
        foreach (self::ENTRIES as $entry) {
            LanguageLine::query()->firstOrCreate(
                [
                    'group' => $entry['group'],
                    'key' => $entry['key'],
                    'locale' => $entry['locale'],
                ],
                [
                    'text' => $entry['text'],
                ],
            );
        }
    }
}
