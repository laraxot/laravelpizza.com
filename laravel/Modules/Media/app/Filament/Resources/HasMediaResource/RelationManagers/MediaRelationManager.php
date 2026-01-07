<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\HasMediaResource\RelationManagers;

use Override;
use Modules\Media\Filament\Resources\HasMediaResource\Actions\AddAttachmentAction;
use Modules\Xot\Filament\Actions\XotBaseAction;
use Modules\Xot\Filament\Actions\XotBaseActionGroup;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class MediaRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'media';

    protected static ?string $inverseRelationship = 'model';

    /**
     * @return array<string, XotBaseAction|XotBaseActionGroup>
     */
    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            'add_attachment' => AddAttachmentAction::make(),
        ];
    }
}
