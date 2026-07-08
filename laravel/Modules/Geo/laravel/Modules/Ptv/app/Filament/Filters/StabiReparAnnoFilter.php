<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Filters;

use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;
use Modules\Sigma\Models\Repart;
use Modules\Xot\Datas\XotData;

class StabiReparAnnoFilter extends SelectFilter
{
    public static function getDefaultName(): ?string
    {
        return 'stabi_repar_anno';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $profile = XotData::make()->getProfileModel();
        $team_class = XotData::make()->getTeamClass();

        // Type narrowing: $team_class is already string from getTeamClass() return type
        if (! class_exists($team_class)) {
            return;
        }

        /** @var class-string<Model> $teamClass */
        $teamClass = $team_class;
        $teamInstance = app($teamClass);

        if (! ($teamInstance instanceof Model)) {
            return;
        }

        $team_table = $teamInstance->getTable();
        $user = Auth::user();
        if ($user === null || ! is_object($user)) {
            return;
        }

        if (! method_exists($user, 'teams')) {
            return;
        }

        $teamsRelation = $user->teams();
        if (! ($teamsRelation instanceof BelongsToMany)) {
            return;
        }

        $teams_opts = $teamsRelation->pluck($team_table.'.name', $team_table.'.id');
        // $this->label('Filter By Category');

        // $this->placeholder('Select a category to filter');

        // $this->relationship('category', 'name');
        $this->schema([
            Select::make('anno')
                ->options([
                    '2023' => '2023',
                ])
                ->reactive(),

            Select::make('stabi')
                ->label('stabi')
                ->options($teams_opts),
            Select::make('repar')
                ->label('repar')
                ->options(function (callable $get, callable $set) {
                    $stabi = $get('stabi');

                    return Repart::where('ente', 90)
                        ->where('repar', '!=', 0)
                        ->where('stabi', $stabi)
                        ->get()
                        ->mapWithKeys(function ($item) {
                            $key = $item->repar;
                            $label = $item->repar.'] '.$item->dest1;

                            return [$key => $label];
                        })
                        ->toArray();
                }),

        ])
            ->columns(4);

        $this->query(fn (Builder $query, array $data): Builder => $query->where($data));

        $this->searchable();
    }
}
