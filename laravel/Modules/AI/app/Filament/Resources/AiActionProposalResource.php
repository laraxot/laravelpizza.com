<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources;

use Filament\Widgets\Widget;
use Modules\AI\Filament\Resources\AiActionProposalResource\Pages;
use Modules\AI\Models\AiActionProposal;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AiActionProposalResource extends XotBaseResource
{
    protected static ?string $model = AiActionProposal::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-sparkles';

    /**
     * @return array<class-string<Widget>>
     */
    public static function getHeaderWidgets(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return array_merge(parent::getPages(), [
            'index' => Pages\ListAiActionProposals::route('/'),
            'create' => Pages\CreateAiActionProposal::route('/create'),
            'view' => Pages\ViewAiActionProposal::route('/{record}'),
            'edit' => Pages\EditAiActionProposal::route('/{record}/edit'),
        ]);
    }
}
