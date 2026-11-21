<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiActionProposalResource\Pages;

use Modules\AI\Filament\Resources\AiActionProposalResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateAiActionProposal extends XotBaseCreateRecord
{
    protected static string $resource = AiActionProposalResource::class;

    protected function getRedirectUrl(): string
    {
        /** @var string */
        return $this->getResource()::getUrl('index');
    }
}
