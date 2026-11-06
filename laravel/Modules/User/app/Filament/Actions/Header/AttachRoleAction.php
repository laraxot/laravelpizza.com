<?php

declare(strict_types=1);
/**
 * @see https://coderflex.com/blog/create-advanced-filters-with-filament
 */

namespace Modules\User\Filament\Actions\Header;

use Closure;
use Filament\Actions\AttachAction;
use Filament\Forms\Components\Select;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Modules\User\Models\Role;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Actions\XotBaseAttachAction;

final class AttachRoleAction extends XotBaseAttachAction
{
    protected function setUp(): void
    {
        $xotData = XotData::make();
        parent::setUp();
        $this->translateLabel()
            ->icon('heroicon-o-link')
            ->iconButton()
            // Opzioni e lettura del valore ricevuto: senza super-admin per chi non lo e'.
            ->recordSelectOptionsQuery(static fn (Builder $query): Builder => Role::restrictAssignableBy($query, Auth::user()))
            // Il form e' controllato dal client: l'id inviato si rivalida sul server, non ci si fida delle opzioni mostrate.
            ->recordSelect(static fn (Select $select): Select => $select->rule(
                static fn (): Closure => static function (string $attribute, mixed $value): void {
                    self::assertAssignable($value);
                }
            ))
            ->schema(static function (AttachAction $action) use ($xotData): array {
                return [
                    $action->getRecordSelect(),
                    Select::make('team_id')->options($xotData->getTeamClass()::get()->pluck('name', 'id')),
                ];
            });
    }

    private static function assertAssignable(mixed $roleId): void
    {
        $isAssignable = (is_int($roleId) || is_string($roleId))
            && Role::restrictAssignableBy(Role::query(), Auth::user())->whereKey($roleId)->exists();

        if (! $isAssignable) {
            throw new AuthorizationException();
        }
    }

    public static function getDefaultName(): string
    {
        return 'attachRole';
    }
}
