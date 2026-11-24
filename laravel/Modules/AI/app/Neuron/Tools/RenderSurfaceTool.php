<?php

declare(strict_types=1);

namespace Modules\AI\Neuron\Tools;

use Modules\AI\Actions\A2ui\BuildA2uiSurfaceAction;
use Modules\AI\Actions\A2ui\ValidateA2uiComponentsAction;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolOutput;
use NeuronAI\Tools\ToolProperty;
use Safe\Exceptions\JsonException;

use function Safe\json_decode;

/**
 * Il modello compone un'interfaccia A2UI (KPI, grafici, tabelle) e il browser la disegna.
 * Un albero non valido torna al modello come errore con l'elenco dei problemi, e il modello riprova.
 * Non cambia dati: non serve approvazione. Aggiungere GUIDE alle istruzioni dell'agente.
 *
 * @see Modules/AI/docs/agents.md#interfacce-generate-a2ui
 */
final class RenderSurfaceTool extends Tool
{
    public const string NAME = 'render_surface';

    public const string GUIDE = <<<'TEXT'
    Interfacce visive (render_surface):
    - Quando i dati sono numeri da confrontare o elenchi con piu' colonne, mostrali con render_surface e
      poi scrivi solo una o due frasi con quello che emerge, senza ripetere i numeri.
    - Non inventare dati: usa solo quelli restituiti dagli altri tool. Se render_surface restituisce un errore, correggi e richiamalo.
    - components e' un array JSON piatto. Ogni componente ha un "id" unico e un tipo in "component".
      Il componente con id "root" e' la radice; i contenitori indicano i figli per id; ogni componente ha un solo genitore.
    - Componenti:
      - Column {children: [id]}, Row {children: [id], justify?: "start"|"spaceBetween"|"spaceEvenly", align?: "start"|"center"|"stretch"};
        un figlio di una Row puo' avere "weight": 1 per dividere lo spazio.
      - Card {child: id}, Tabs {tabs: [{title, child: id}]}, Divider {}.
      - Text {text, variant?: "body"|"caption"}: Markdown, per un titolo "#### Titolo".
      - Stat {label, value, caption?, trend?}: un numero grande (KPI); trend come "+12%" o "-3".
      - Chart {title, type: "bar"|"line"|"area"|"pie"|"doughnut", labels: [string], datasets: [{label, data: [numero]}], unit?}:
        un numero per ogni etichetta; pie e doughnut con un solo dataset.
      - DataTable {title?, columns: [string], rows: [[testo o numero]]}: una cella per colonna.
    - Esempio: [{"id":"root","component":"Column","children":["kpis","chart"]},
      {"id":"kpis","component":"Row","children":["k1","k2"]},
      {"id":"k1","component":"Stat","label":"Domande","value":42,"weight":1},
      {"id":"k2","component":"Stat","label":"Senza risposta","value":5,"weight":1},
      {"id":"chart","component":"Chart","title":"Domande per giorno","type":"bar","labels":["lun","mar"],"datasets":[{"label":"Domande","data":[12,8]}]}]
    TEXT;

    public function __construct()
    {
        $this->name = self::NAME;
        $this->description = "Mostra all'utente un'interfaccia A2UI composta da te (KPI, grafici, tabelle): una lista piatta di componenti che si riferiscono tra loro per id, a partire da quello con id \"root\".";
    }

    protected function properties(): array
    {
        return [
            new ToolProperty('components', PropertyType::STRING, 'La lista dei componenti, come array JSON.', required: true),
        ];
    }

    /** @see Modules/AI/docs/agents.md#interfacce-generate-a2ui */
    public function __invoke(string $components): ToolOutput
    {
        try {
            $decoded = json_decode($components, true);
            $problem = is_array($decoded) ? 'è un oggetto, serve un array' : 'non è un array';
        } catch (JsonException $exception) {
            $decoded = null;
            $problem = $exception->getMessage();
        }

        if (! is_array($decoded) || ! array_is_list($decoded)) {

            return ToolOutput::error(sprintf(
                "components non è un array JSON valido (%s). Passa solo l'array, da [ a ], senza testo intorno e senza virgole finali. Correggilo e richiama render_surface.",
                $problem,
            ));
        }

        $errors = app(ValidateA2uiComponentsAction::class)->execute($decoded);
        if ($errors !== []) {
            return ToolOutput::error("L'interfaccia non è valida. Correggila e richiama render_surface.\n- ".implode("\n- ", $errors));
        }

        /** @var list<array<string, mixed>> $decoded */
        return ToolOutput::text(BuildA2uiSurfaceAction::toToolResult(app(BuildA2uiSurfaceAction::class)->execute($decoded)));
    }
}
