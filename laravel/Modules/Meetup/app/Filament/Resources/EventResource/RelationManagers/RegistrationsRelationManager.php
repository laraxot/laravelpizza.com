<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources\EventResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Meetup\Actions\Event\ExportEventRegistrationsAction;
use Modules\Meetup\Actions\Event\UnregisterAttendeeFromEventAction;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\EventUser;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;
use Override;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Webmozart\Assert\Assert;

/**
 * PRD FR-4: l'organizzatore vede chi si e' iscritto, puo' annullare un'iscrizione e scaricare l'elenco in CSV.
 * Righe della pivot `event_user` con l'utente caricato a parte (vive su un altro database: niente join).
 */
class RegistrationsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'registrations';

    #[Override]
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->heading((string) __('meetup::registration.plural_label'))
            ->modifyQueryUsing(static fn (Builder $query): Builder => $query->with('user'))
            ->defaultSort('created_at', 'desc');
    }

    /**
     * @return array<string, Column>
     */
    #[Override]
    public function getTableColumns(): array
    {
        return [
            // Utente cancellato o di un altro tenant: la riga resta, con un trattino al posto del nome.
            'user.name' => TextColumn::make('user.name')->placeholder('—'),
            'user.email' => TextColumn::make('user.email')->copyable()->placeholder('—'),
            'status' => TextColumn::make('status')
                ->badge()
                ->formatStateUsing(static fn (string $state): string => (string) __('meetup::registration.fields.status.options.'.$state)),
            'created_at' => TextColumn::make('created_at')->dateTime('d/m/Y H:i')->sortable(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[Override]
    public function getTableHeaderActions(): array
    {
        return [
            'export_csv' => Action::make('export_csv')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(fn (): StreamedResponse => app(ExportEventRegistrationsAction::class)->execute($this->getEvent())),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[Override]
    public function getTableActions(): array
    {
        return [
            'cancel_registration' => Action::make('cancel_registration')
                ->icon('heroicon-o-user-minus')
                ->color('danger')
                ->iconButton()
                ->requiresConfirmation()
                ->action(function (Model $record): void {
                    Assert::isInstanceOf($record, EventUser::class);
                    app(UnregisterAttendeeFromEventAction::class)->execute($this->getEvent(), (string) $record->user_id);
                    Notification::make()->success()->title(static::trans('actions.cancel_registration.notification'))->send();
                }),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[Override]
    public function getTableBulkActions(): array
    {
        return [];
    }

    private function getEvent(): Event
    {
        $event = $this->getOwnerRecord();
        Assert::isInstanceOf($event, Event::class);

        return $event;
    }
}
