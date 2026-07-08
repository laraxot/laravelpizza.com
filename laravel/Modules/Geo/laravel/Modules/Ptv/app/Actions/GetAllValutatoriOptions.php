<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\QueueableAction\QueueableAction;

class GetAllValutatoriOptions
{
    use QueueableAction;

    /**
     * @return array<string, string>
     */
    public function execute(string $name, string|int|null $anno): array
    {
        $stabiDiriClass = "\Modules\\".$name."\Models\StabiDirigente";

        if (! class_exists($stabiDiriClass)) {
            return [];
        }

        /** @var class-string<Model> $modelClass */
        $modelClass = $stabiDiriClass;

        $query = $modelClass::query()
            ->where('anno', $anno)
            ->whereRaw('valutatore_id = id');

        $valutatori = $query->get();

        if (! ($valutatori instanceof Collection)) {
            return [];
        }

        /** @var array<string, string> $result */
        $result = [];

        foreach ($valutatori as $v) {
            if (! ($v instanceof Model)) {
                continue;
            }

            $valutatoreId = isset($v->valutatore_id) ? (is_string($v->valutatore_id) || is_int($v->valutatore_id) ? (string) $v->valutatore_id : '') : '';
            $nomeDiri = isset($v->nome_diri) && is_string($v->nome_diri) ? $v->nome_diri : '';
            $nomeDiriPlus = isset($v->nome_diri_plus) && is_string($v->nome_diri_plus) ? $v->nome_diri_plus : '';

            if ($valutatoreId !== '') {
                $result[$valutatoreId] = $valutatoreId.'] '.$nomeDiri.'  '.$nomeDiriPlus.' ';
            }
        }

        return $result;
    }
}
