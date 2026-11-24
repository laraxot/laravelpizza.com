<?php

declare(strict_types=1);

namespace Modules\AI\Actions\A2ui;

use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

use function Safe\json_encode;

/**
 * Messaggi A2UI 1.0 per il browser: una `createSurface` con i componenti inline, sul catalogo del pannello.
 * Il risultato del tool e' JSON con la chiave `a2ui`: il client lo disegna invece di mostrarlo come testo.
 *
 * @see https://a2ui.org/specification/v1_0/
 * @see Modules/AI/docs/agents.md#interfacce-generate-a2ui
 */
final class BuildA2uiSurfaceAction
{
    use QueueableAction;

    public const string VERSION = '1.0';

    /** Catalogo base piu' Stat, Chart e DataTable: deve coincidere con `resources/js/a2ui/panel-catalog.js`. */
    public const string PANEL_CATALOG = 'urn:laraxot:a2ui:panel';

    /**
     * @param  list<array<string, mixed>>  $components  albero gia' controllato da ValidateA2uiComponentsAction
     * @return list<array<string, mixed>>
     *
     * @see Modules/AI/docs/agents.md#interfacce-generate-a2ui
     */
    public function execute(array $components, string $prefix = 'generated'): array
    {
        return [
            ['version' => self::VERSION, 'createSurface' => [
                'surfaceId' => $prefix.'-'.Str::lower((string) Str::ulid()),
                'catalogId' => self::PANEL_CATALOG,
                'components' => $components,
            ]],
        ];
    }

    /** @param  list<array<string, mixed>>  $messages */
    public static function toToolResult(array $messages): string
    {
        return json_encode(['a2ui' => $messages], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
