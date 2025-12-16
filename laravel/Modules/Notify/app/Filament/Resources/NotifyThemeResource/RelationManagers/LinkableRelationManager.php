<?php

declare(strict_types=1);

namespace Modules\Notify\Filament\Resources\NotifyThemeResource\RelationManagers;

use Override;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class LinkableRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'linkable';

    protected static null|string $recordTitleAttribute = 'id';

    #[Override]
    public function getFormSchema(): array
    {
        return [
            TextInput::make('id')->required()->maxLength(255),
        ];
    }
}
