<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Export;

use Illuminate\View\View;
use Spatie\QueueableAction\QueueableAction;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * @see docs/contracts/pdf-by-view-action.md
<<<<<<< .merge_file_C805S6
 *
=======
>>>>>>> .merge_file_ahnGjF
 * @contract docs/contracts/pdf-by-view-action.md
 */
class PdfByViewAction
{
    use QueueableAction;

    public function execute(
        View $view,
        string $filename = 'my_doc.pdf',
        string $disk = 'cache',
        string $out = 'download',
        string $orientation = 'L',
    ): string|BinaryFileResponse {
        $html = $view->render();

        return app(PdfByHtmlAction::class)->execute($html, $filename, $disk, $out, $orientation);
    }
}
