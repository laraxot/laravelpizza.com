<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Team;

use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use InvalidArgumentException;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\User\Contracts\HasTeamsContract;
use Modules\User\Contracts\TeamContract;
use Modules\User\Events\TeamSwitched;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Webmozart\Assert\Assert;

/**
 * Chrome user-menu: switch del team corrente.
 *
 * Sostituisce `Modules\User\Http\Livewire\Team\Change`.
 */
class TeamChangeWidget extends XotBaseWidget
{
    protected static bool $isDiscovered = false;

    protected string $view = 'user::filament.widgets.team.change';

    /** @var list<array{id: int|string, name: string}> */
    public array $teams = [];

    public UserContract $user;

    public function mount(): void
    {
        $authUser = Filament::auth()->user();
        Assert::notNull($authUser, '['.__LINE__.']['.class_basename($this).']');

        if (! $authUser instanceof UserContract || ! $authUser instanceof HasTeamsContract) {
            throw new InvalidArgumentException(__('user::team_change_widget.mount.invalid_user'));
        }

        $this->user = $authUser;
        $teams = [];
        foreach ($authUser->allTeams() as $team) {
            Assert::isInstanceOf($team, TeamContract::class);
            $id = $team->getKey();
            if (! is_int($id) && ! is_string($id)) {
                continue;
            }
            Assert::stringNotEmpty($team->name);
            $teams[] = [
                'id' => $id,
                'name' => $team->name,
            ];
        }
        $this->teams = $teams;
    }

    /**
     * Aggiorna il team corrente dell'utente autenticato.
     *
     * Il parametro e' `int|string`, non solo `int`: il docblock di
     * `Modules\User\Models\Team` dichiara `@property string $id` (UUID), ma sulla
     * connessione `user` di questo ambiente la colonna reale e' un intero
     * auto-increment (verificato a runtime, non a memoria — drift schema/docblock
     * pre-esistente, fuori scope da correggere qui). Stesso tipo di
     * `Model::getKey(): int|string` e coerente con l'array `$teams` popolato in
     * `mount()`. Il binding Livewire da `wire:click="switchTeam('...')"` (vista,
     * valore quotato) arriva sempre come stringa: essendo l'unione compatibile,
     * nessuna coercizione silenziosa e' necessaria in nessuno dei due scenari di PK.
     */
    public function switchTeam(int|string $teamId): RedirectResponse|Redirector
    {
        $teamClass = XotData::make()->getTeamClass();
        $team = $teamClass::firstWhere(['id' => $teamId]);

        if (! $team instanceof TeamContract || ! $this->user->switchTeam($team)) {
            abort(403);
        }

        TeamSwitched::dispatch($team, $this->user);

        Notification::make()
            ->title(__('user::team_change_widget.switched.title'))
            ->success()
            ->send();

        $path = config('filament.path', '/admin');
        Assert::string($path);

        return redirect($path, 303);
    }

    public function render(): View
    {
        /** @var view-string $viewName */
        $viewName = 'user::filament.widgets.team.change';

        if ($this->teams === []) {
            $viewName = 'ui::livewire.empty';
        }

        return view($viewName, [
            'teams' => $this->teams,
        ]);
    }
}
