<?php

declare(strict_types=1);

namespace Modules\Lang\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Lang\Models\Translation;

/**
 * Traduzioni UI base — chiavi da Modules/Predict/lang (SSoT file PHP, non inventate).
 */
class TranslationSeeder extends Seeder
{
    /** @var list<array{namespace: string, group: string, item: string, lang: string, value: string}> */
    private const ENTRIES = [
        [
            'namespace' => 'predict',
            'group' => 'fields',
            'item' => 'title.label',
            'lang' => 'it',
            'value' => 'Titolo',
        ],
        [
            'namespace' => 'predict',
            'group' => 'fields',
            'item' => 'title.label',
            'lang' => 'en',
            'value' => 'Title',
        ],
        [
            'namespace' => 'predict',
            'group' => 'fields',
            'item' => 'slug.label',
            'lang' => 'it',
            'value' => 'Slug',
        ],
        [
            'namespace' => 'predict',
            'group' => 'fields',
            'item' => 'slug.label',
            'lang' => 'en',
            'value' => 'Slug',
        ],
    ];

    public function run(): void
    {
        foreach (self::ENTRIES as $entry) {
            Translation::query()->firstOrCreate(
                [
                    'namespace' => $entry['namespace'],
                    'group' => $entry['group'],
                    'item' => $entry['item'],
                    'lang' => $entry['lang'],
                ],
                [
                    'key' => "{$entry['namespace']}::{$entry['group']}.{$entry['item']}",
                    'value' => $entry['value'],
                ],
            );
        }
    }
}
