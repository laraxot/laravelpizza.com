<?php

declare(strict_types=1);

namespace Modules\Ptv\Actions\Pdf;

use Exception;
use Modules\Ptv\Models\Contracts\SchedaContract;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Spatie\QueueableAction\QueueableAction;

class MakePdfByRecord
{
    use QueueableAction;

    /**
     * Undocumented function.
     */
    public function execute(SchedaContract $record, string $out = 'show'): mixed
    {
        $view = app(GetViewByModelClassAction::class)->execute($record::class, '.show.pdf');

        $valutatore = method_exists($record, 'valutatore') ? $record->valutatore : null;
        $nomeDiri = null;

        if (is_object($valutatore) && isset($valutatore->nome_diri)) {
            $nomeDiri = is_string($valutatore->nome_diri) ? $valutatore->nome_diri : null;
        }

        $view_params = [
            'view' => $view,
            'row' => $record,
            // 'title' => 'Progressione anno '.$record->anno,
            'firma' => $nomeDiri,
        ];
        if (! view()->exists($view)) {
            $msg = 'View ['.$view.'] not found.';
            throw new Exception($msg);
        }

        return view($view, $view_params);
    }
}
