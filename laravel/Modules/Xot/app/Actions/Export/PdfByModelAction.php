<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Export;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Trans\GetTransKeyByModelClassAction;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PdfByModelAction
{
    use QueueableAction;

    public function execute(
        Model $model,
        string $filename = 'my_doc.pdf',
        string $disk = 'cache',
        string $out = 'download',
    ): string|BinaryFileResponse {
        /**
         * @var non-falsy-string&view-string
         */
        $view_name = app(GetViewByModelClassAction::class)->execute($model::class, '.show.pdf');

        $view_params = [
            'view' => $view_name,
            'row' => $model,
            'transKey' => app(GetTransKeyByModelClassAction::class)->execute($model::class, '.fields'),
        ];
        $view = view($view_name, $view_params);

        $html = $view->render();

        return app(PdfByHtmlAction::class)->execute($html, $filename, $disk, $out);
    }
}
