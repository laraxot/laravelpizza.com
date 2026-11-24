<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiKnowledgeEntryResource\Pages;

use Modules\AI\Filament\Resources\AiKnowledgeEntryResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;

class ListAiKnowledgeEntries extends XotBaseListRecords
{
    protected static string $resource = AiKnowledgeEntryResource::class;
}
