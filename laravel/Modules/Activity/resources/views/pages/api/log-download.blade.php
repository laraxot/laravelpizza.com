<?php

declare(strict_types=1);
use Illuminate\Http\Request;
use Modules\Activity\Actions\Log\AuthorizeLogAccessAction;
use Modules\Activity\Actions\Log\DownloadLogFileAction;
use Modules\Activity\Exceptions\InvalidLogFileException;

use function Laravel\Folio\render;

/*
 * Download di un file di log scelto nella pagina Log: GET /api/log-download?file=<percorso relativo a storage/logs>.
 *
 * Pagina Folio + Action al posto di un Controller (regola "No Controllers"). Folio monta `pages/api` su `/api` con il
 * middleware `web`, quindi vale il login della sessione del pannello. Nessun middleware `auth` di Laravel: per un utente
 * non autenticato si risponde 403 invece di reindirizzare a una rotta di login che qui potrebbe non esistere.
 *
 * Risposte: 403 se non autorizzato, 404 se il file non e' valido (fuori da storage/logs, non .log, inesistente),
 * altrimenti il file in streaming (BinaryFileResponse, letto a blocchi dal disco).
 */
render(function (Request $request) {
    abort_unless(app(AuthorizeLogAccessAction::class)->execute($request->user()), 403);

    $file = $request->query('file');
    if (! is_string($file) || $file === '') {
        abort(404);
    }

    try {
        return app(DownloadLogFileAction::class)->execute($file);
    } catch (InvalidLogFileException) {
        abort(404);
    }
});
?>
