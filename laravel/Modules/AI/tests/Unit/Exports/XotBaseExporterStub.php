<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Exports;

use Filament\Actions\Exports\Models\Export;
use Modules\Xot\Exports\XotBaseExporter;

/**
 * Exporter concreto di test: `getColumns()` non trova mai un ListRecords attivo
 * nel contesto del test, quindi si verifica `resolveColumns()` via reflection.
 */
class XotBaseExporterStub extends XotBaseExporter
{
    #[\Override]
    public static function getCompletedNotificationBody(Export $export): string
    {
        return 'done';
    }
}
