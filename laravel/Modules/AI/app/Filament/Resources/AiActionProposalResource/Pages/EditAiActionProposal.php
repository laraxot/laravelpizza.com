<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiActionProposalResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Modules\AI\Filament\Resources\AiActionProposalResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditAiActionProposal extends XotBaseEditRecord
{
    protected static string $resource = AiActionProposalResource::class;

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
