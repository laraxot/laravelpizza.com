<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Exports;

/**
 * Resource fake: espone il contratto `getXlsFields()` con formato misto
 * (chiave intera => percorso, chiave stringa => percorso con label esplicita).
 */
class ResourceWithXlsFieldsStub
{
    /**
     * @param  array<array-key, mixed>  $data
     * @return array<int|string, string>
     */
    public static function getXlsFields(array $data): array
    {
        return [
            'id',
            'matr',
            'ratings_by_id.52.pivot.value' => 'Obiettivo A',
        ];
    }
}
