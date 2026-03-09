<?php

declare(strict_types=1);

namespace Modules\Notify\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Notify\Models\NotificationLog;

use function Safe\base64_decode;

class NotificationTrackingController extends Controller
{
    /**
     * Traccia l'apertura di una notifica.
     */
    public function trackOpen(Request $request, string $id): Response
    {
        $log = NotificationLog::find($id);

        if ($log) {
            $log->markAsOpened();
        }

        // Restituisce un'immagine trasparente 1x1
        return response()->make(
            base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'),
            200,
            ['Content-Type' => 'image/gif']
        );
    }

    /**
     * Traccia il click su un link in una notifica.
     */
    public function trackClick(Request $request, string $id): RedirectResponse
    {
        $log = NotificationLog::find($id);
        /** @var mixed $urlParam */
        $urlParam = $request->get('url', '');
        $url = is_string($urlParam) ? $urlParam : '';

        if ($log) {
            $log->markAsClicked();

            // Aggiorna i metadati con il link cliccato
            $data = $log->data;
            $metadata = is_array($data) ? $data : [];
            $clickedLinks = isset($metadata['clicked_links']) && is_array($metadata['clicked_links'])
                ? $metadata['clicked_links']
                : [];

            if ($url !== '') {
                $clickedLinks[$url] = now()->toIso8601String();
            }

            /** @var array<string, mixed> $metadata */
            $metadata['clicked_links'] = $clickedLinks;
            $log->update(['data' => $metadata]);
        }

        // Redirect all'URL originale
        return redirect()->away((string) $url);
    }
}
