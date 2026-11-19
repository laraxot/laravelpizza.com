<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources;

use Filament\Widgets\Widget;
use Modules\AI\Filament\Resources\AiKnowledgeEntryResource\Pages;
use Modules\AI\Models\AiKnowledgeEntry;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Base di conoscenza dell'assistente: qui si scrivono e si correggono le risposte ufficiali.
 */
class AiKnowledgeEntryResource extends XotBaseResource
{
    protected static ?string $model = AiKnowledgeEntry::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-book-open';

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
            'index' => Pages\ListAiKnowledgeEntries::route('/'),
            'create' => Pages\CreateAiKnowledgeEntry::route('/create'),
            'edit' => Pages\EditAiKnowledgeEntry::route('/{record}/edit'),
        ]);
    }
}
