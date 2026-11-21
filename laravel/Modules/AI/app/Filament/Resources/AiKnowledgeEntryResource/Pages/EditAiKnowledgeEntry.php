<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiKnowledgeEntryResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\AI\Filament\Resources\AiKnowledgeEntryResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditAiKnowledgeEntry extends XotBaseEditRecord
{
    protected static string $resource = AiKnowledgeEntryResource::class;

    /**
     * @return array<string, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            'delete' => DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        /** @var string */
        return $this->getResource()::getUrl('index');
    }
}
