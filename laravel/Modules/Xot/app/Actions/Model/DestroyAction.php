<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Spatie\QueueableAction\QueueableAction;

class DestroyAction
{
    use QueueableAction;

    public function execute(Model $model, array $_data, array $_rules): Model
    {
        // prende la chiave del modello

        // $id = $row->getKey();

        // nel mio caso nella pivot è la chiave 14 ma non nella tabella finale,
        // ma probabilmente è giusto perchè va disassociata se è many to many
        // ma forse il problema è che il modello è Keyword e non KeywordReport

        // DA FIXARE: se le tabelle pivot e tabella finale hanno id sfasati allora non CANCELLA giusto
        // e nemmeno EDIT lo fa giusto

        $res = $model->delete();
        if ($res) {
            Session::flash('status', 'eliminato');
        } else {
            Session::flash('status', 'NON eliminato');
        }

        return $model;
    }
}
