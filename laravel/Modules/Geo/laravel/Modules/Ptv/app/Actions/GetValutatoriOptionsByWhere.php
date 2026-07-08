<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Spatie\QueueableAction\QueueableAction;

class GetValutatoriOptionsByWhere
{
    use QueueableAction;

    /**
     * @param  array<string, mixed>  $where
     * @return array<string, string>
     */
    public function execute(string $name, array $where): array
    {
        $user = Auth::user();
        if ($user === null || ! is_object($user)) {
            return [];
        }

        // Type narrowing: ensure user has teams() method
        if (! method_exists($user, 'teams')) {
            return [];
        }

        $teamsRelation = $user->teams();
        if (! ($teamsRelation instanceof BelongsToMany)) {
            return [];
        }

        $teams = $teamsRelation->get();
        if (! ($teams instanceof Collection)) {
            return [];
        }

        // Extract stabi IDs from teams - assuming teams have a 'stabi' property or use 'id'
        $stabis = $teams->pluck('stabi')->filter()->toArray();
        if (empty($stabis)) {
            // Fallback: try to get IDs if stabi is not available
            $stabis = $teams->modelKeys();
        }

        $stabiDiriClass = "\Modules\\".$name."\Models\StabiDirigente";
        if (! class_exists($stabiDiriClass)) {
            return [];
        }

        /** @var class-string<Model> $modelClass */
        $modelClass = $stabiDiriClass;

        /** @var Builder<Model> $query */
        $query = $modelClass::query()
            ->whereIn('stabi', $stabis)
            ->where($where)
            ->whereRaw('valutatore_id = id');

        $valutatori = $query->get();
        if (! ($valutatori instanceof Collection)) {
            return [];
        }

        /** @var array<string, string> $result */
        $result = [];

        foreach ($valutatori as $v) {
            if (! is_object($v)) {
                continue;
            }

            $valutatoreId = isset($v->valutatore_id) ? (is_string($v->valutatore_id) || is_int($v->valutatore_id) ? (string) $v->valutatore_id : '') : '';
            $nomeDiri = isset($v->nome_diri) && is_string($v->nome_diri) ? $v->nome_diri : '';
            $nomeDiriPlus = isset($v->nome_diri_plus) && is_string($v->nome_diri_plus) ? $v->nome_diri_plus : '';
            $annoValue = isset($v->anno) ? (is_string($v->anno) || is_int($v->anno) ? (string) $v->anno : '') : '';

            if ($valutatoreId !== '') {
                $result[$valutatoreId] = $valutatoreId.'] '.$nomeDiri.'  '.$nomeDiriPlus.' ['.$annoValue.']';
            }
        }

        return $result;
    }
}
