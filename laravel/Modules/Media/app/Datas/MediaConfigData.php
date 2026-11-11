<?php

declare(strict_types=1);

namespace Modules\Media\Datas;

use Modules\Media\Filament\Pages\SettingPage;
use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/**
 * Impostazioni di Media del tenant corrente: `config/{tenant}/media.php`.
 *
 * Si modificano dalla SettingPage del modulo (solo super-admin). I default sono i valori che
 * prima erano scritti nel codice: nulla cambia finche' nessuno salva.
 *
 * @see SettingPage
 */
class MediaConfigData extends Data
{
    use MakesFromTenantConfig;

    public string $name = 'Media';

    /** Dimensione massima degli allegati delle Resource, in KB (prima 10240 in GetAttachmentsSchemaAction). */
    public int $attachment_max_size_kb = 10240;

    /**
     * Tipi MIME accettati per gli allegati (prima pdf, doc, docx in GetAttachmentsSchemaAction).
     *
     * @var list<string>
     */
    public array $attachment_mime_types = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    ];
}
