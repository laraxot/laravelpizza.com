<?php

declare(strict_types=1);

namespace Modules\AI\Filament\Resources\AiActionProposalResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use Modules\AI\Actions\CancelAiActionProposalAction;
use Modules\AI\Actions\ConfirmAiActionProposalAction;
use Modules\AI\Models\AiActionProposal;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class AiActionProposalsTable extends XotBaseResourceTable
{
    /**
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        $actions = parent::getTableActions();

        $actions['confirm'] = Action::make('confirm')
            ->label(\trans_string('ai::action_proposal.actions.confirm'))
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->visible(
                static fn (AiActionProposal $record): bool => $record->status->canBeConfirmed()
            )
            ->action(function (AiActionProposal $record): void {
                app(ConfirmAiActionProposalAction::class)->execute($record, (int) Auth::id());
            });

        $actions['cancel'] = Action::make('cancel')
            ->label(\trans_string('ai::action_proposal.actions.cancel'))
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->requiresConfirmation()
            ->visible(
                static fn (AiActionProposal $record): bool => $record->status->canBeCancelled()
            )
            ->action(function (AiActionProposal $record): void {
                app(CancelAiActionProposalAction::class)->execute($record);
            });

        return $actions;
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id')->sortable()->searchable(),
            'thread.public_id' => TextColumn::make('thread.public_id')
                ->limit(12),
            'type' => TextColumn::make('type')
                ->badge()
                ->searchable(),
            // badge(): etichetta, colore e icona arrivano dall'enum (HasLabel/HasColor/HasIcon).
            'status' => TextColumn::make('status')
                ->badge()
                ->sortable(),
            'preview' => TextColumn::make('preview')
                ->limit(50)
                ->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')
                ->dateTime('d/m/Y H:i')
                ->sortable(),
        ];
    }
}
