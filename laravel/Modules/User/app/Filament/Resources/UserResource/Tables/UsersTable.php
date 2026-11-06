<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ExportBulkAction;
use Illuminate\Support\Facades\Gate;
use Modules\User\Filament\Actions\ChangePasswordAction;
use Modules\User\Filament\Resources\UserResource;
use Modules\Xot\Contracts\UserContract;

class UsersTable extends BaseUsersTable
{
    protected static ?string $resource = UserResource::class;

    /**
     * Azioni condivise: la verifica email viene dalla base, quelle di gestione
     * password/disattivazione appartengono alla tabella utenti concreta.
     *
     * @return array<int|string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            ...parent::getTableActions(),
            'change_password' => ChangePasswordAction::make()
                ->iconButton(),
            'deactivate' => Action::make('deactivate')
                ->color('danger')
                ->icon('heroicon-o-trash')
                ->authorize('delete')
                ->requiresConfirmation()
                ->action(static function (UserContract $record): void {
                    // Cancella (soft delete), non disattiva: BaseUserPolicy::delete vieta se stessi e i super-admin.
                    Gate::authorize('delete', $record);

                    $record->delete();
                }),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
            'export' => ExportBulkAction::make(),
        ];
    }
}
