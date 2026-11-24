<?php

declare(strict_types=1);

namespace Modules\AI\Tests\Unit\A2ui;

use Modules\AI\Actions\A2ui\BuildA2uiSurfaceAction;
use Modules\AI\Neuron\Tools\RenderSurfaceTool;
use Modules\AI\Tests\TestCase;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

it('trasforma un albero valido in una superficie A2UI sul catalogo del pannello', function (): void {
    $tree = [['id' => 'root', 'component' => 'Text', 'text' => '#### Ciao']];

    $output = (new RenderSurfaceTool)(json_encode($tree));
    $payload = json_decode((string) $output, true);

    expect($output->isError())->toBeFalse()
        ->and(data_get($payload, 'a2ui.0.version'))->toBe('1.0')
        ->and(data_get($payload, 'a2ui.0.createSurface.catalogId'))->toBe(BuildA2uiSurfaceAction::PANEL_CATALOG)
        ->and(data_get($payload, 'a2ui.0.createSurface.surfaceId'))->toStartWith('generated-')
        ->and(data_get($payload, 'a2ui.0.createSurface.components'))->toBe($tree);
});

it('restituisce al modello gli errori da correggere', function (): void {
    $output = (new RenderSurfaceTool)('[{"id":"root","component":"Stat","label":"X"}]');

    expect($output->isError())->toBeTrue()
        ->and((string) $output)->toContain('richiama render_surface')
        ->toContain('root: ');
});

it('spiega un JSON non valido o un oggetto al posto dell\'array', function (): void {
    expect((string) (new RenderSurfaceTool)('[{"id":'))->toContain('non è un array JSON valido')
        ->and((string) (new RenderSurfaceTool)('{"id":"root"}'))->toContain('serve un array');
});
