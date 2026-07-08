<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources\OrganizzativaResource\Pages;

use Filament\Actions\DeleteAction;
use Modules\Performance\Filament\Resources\OrganizzativaResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

use function Safe\ini_set;

class EditOrganizzativa extends XotBaseEditRecord
{
    protected static string $resource = OrganizzativaResource::class;

    public function mount(int|string $record): void
    {
        ini_set('max_execution_time', '3600');

        parent::mount($record);
    }
}
