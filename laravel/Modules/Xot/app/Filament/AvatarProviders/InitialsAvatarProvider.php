<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts\AvatarProvider;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use function Safe\preg_replace;

/**
 * Avatar predefinito dei pannelli Filament, generato in locale (DCP-139, DCP-137).
 *
 * Il provider di Filament (`UiAvatarsProvider`) carica l'immagine da `ui-avatars.com` a ogni pagina del back office: un servizio terzo riceve l'indirizzo
 * IP e le iniziali di chi amministra, e una CSP con `img-src 'self'` lo bloccherebbe. Qui le iniziali (al massimo due) diventano un SVG incorporato
 * (`data:`), senza nessuna richiesta di rete e senza trasferire dati personali a terzi.
 */
final class InitialsAvatarProvider implements AvatarProvider
{
    public function get(Model|Authenticatable $record): string
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="64" height="64">'
            .'<rect width="64" height="64" fill="#09090b"/>'
            .'<text x="32" y="32" dy=".35em" text-anchor="middle" fill="#ffffff" font-family="system-ui, sans-serif" font-size="26" font-weight="600">'
            .htmlspecialchars($this->initials($record), ENT_XML1 | ENT_QUOTES, 'UTF-8')
            .'</text></svg>';

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    private function initials(Model|Authenticatable $record): string
    {
        $initials = str(Filament::getNameForDefaultAvatar($record))
            ->squish()
            ->explode(' ')
            // inizio con una lettera o una cifra: "[SYSTEM] Admin" non deve dare "[" come iniziale
            ->map(static fn (string $segment): string => mb_substr(preg_replace('/^[^\p{L}\p{N}]+/u', '', $segment), 0, 1))
            ->filter()
            ->take(2)
            ->join('');

        return mb_strtoupper($initials);
    }
}
