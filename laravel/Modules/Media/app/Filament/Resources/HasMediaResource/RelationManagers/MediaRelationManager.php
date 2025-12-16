<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources\HasMediaResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Modules\Media\Filament\Resources\HasMediaResource\Actions\AddAttachmentAction;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;

class MediaRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'media';

    protected static ?string $inverseRelationship = 'model';

    /**
     * @return array<string, Action|ActionGroup>
     */
    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            'add_attachment' => AddAttachmentAction::make(),
        ];
    }
}
