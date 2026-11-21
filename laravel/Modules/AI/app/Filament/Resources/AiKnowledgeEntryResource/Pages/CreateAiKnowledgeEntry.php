<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiKnowledgeEntryResource\Pages;

use Modules\AI\Filament\Resources\AiKnowledgeEntryResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateAiKnowledgeEntry extends XotBaseCreateRecord
{
    protected static string $resource = AiKnowledgeEntryResource::class;

    protected function getRedirectUrl(): string
    {
        /** @var string */
        return $this->getResource()::getUrl('index');
    }
}
