<?php

declare(strict_types=1);

namespace Modules\AI\Actions\A2ui;

use Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\QueueableAction\QueueableAction;

/**
 * Controlla un albero di componenti A2UI 1.0 scritto dal modello prima che arrivi al browser.
 * Gli errori tornano al modello come risultato del tool, cosi' corregge l'albero e riprova.
 *
 * Componenti ammessi: layout e testo del catalogo base, piu' Stat, Chart e DataTable del catalogo
 * del pannello (`resources/js/a2ui/panel-catalog.js`). Pattern da datomatic/laravelday-2026 (MIT).
 *
 * @see Modules/AI/docs/agents.md#interfacce-generate-a2ui
 */
final class ValidateA2uiComponentsAction
{
    use QueueableAction;

    public const array COMPONENTS = ['Text', 'Row', 'Column', 'List', 'Card', 'Tabs', 'Divider', 'Stat', 'Chart', 'DataTable'];

    public const array CHART_TYPES = ['bar', 'line', 'area', 'pie', 'doughnut'];

    /** Il browser valida i componenti personalizzati in modo stretto: una proprieta' in piu' romperebbe la superficie. */
    public const array CUSTOM_PROPERTIES = [
        'Stat' => ['label', 'value', 'caption', 'trend'],
        'Chart' => ['title', 'type', 'labels', 'datasets', 'unit'],
        'DataTable' => ['title', 'columns', 'rows'],
    ];

    /**
     * @param  array<int|string, mixed>  $components
     * @return list<string> vuota se l'albero e' valido
     *
     * @see Modules/AI/docs/agents.md#interfacce-generate-a2ui
     */
    public function execute(array $components): array
    {
        $list = Validator::make(['components' => $components], [
            'components' => ['required', 'list'],
            'components.*' => ['array'],
            'components.*.id' => ['required', 'string', 'distinct'],
            'components.*.component' => ['required', Rule::in(self::COMPONENTS)],
        ], [
            'components.*.component.in' => ':attribute deve essere uno di: '.implode(', ', self::COMPONENTS).'.',
        ]);

        if ($list->fails()) {
            return array_values($list->errors()->all());
        }

        /** @var Collection<string, array<string, mixed>> $byId */
        $byId = collect($components)->keyBy('id');

        $errors = $byId->has('root') ? [] : ['Manca il componente con id "root".'];
        foreach ($byId as $id => $component) {
            array_push($errors, ...$this->componentErrors($id, $component));
        }

        return [...$errors, ...$this->treeErrors($byId)];
    }

    /**
     * @param  array<string, mixed>  $component
     * @return list<string>
     */
    private function componentErrors(string $id, array $component): array
    {
        // Gia' controllato da Rule::in(self::COMPONENTS) nella validazione della lista.
        $type = is_string($component['component'] ?? null) ? $component['component'] : '';
        $custom = self::CUSTOM_PROPERTIES[$type] ?? null;

        if ($custom !== null) {
            $unknown = array_diff(array_keys($component), ['id', 'component', 'weight', ...$custom]);
            if ($unknown !== []) {
                return ["{$id}: proprietà non previste: ".implode(', ', $unknown).'.'];
            }
        }

        $messages = Validator::make($component, $this->rules($type, $component), [
            'type.in' => 'type deve essere uno di: '.implode(', ', self::CHART_TYPES).'.',
        ])->errors()->all();

        return array_values(array_map(static fn (string $error): string => "{$id}: {$error}", $messages));
    }

    /**
     * @param  array<string, mixed>  $component
     * @return array<string, mixed>
     */
    private function rules(string $type, array $component): array
    {
        $ids = ['required', 'list', 'min:1'];

        return match ($type) {
            'Text' => ['text' => ['required', 'string'], 'variant' => [Rule::in(['body', 'caption'])]],
            'Row', 'Column', 'List' => ['children' => $ids, 'children.*' => ['string']],
            'Card' => ['child' => ['required', 'string']],
            'Tabs' => ['tabs' => $ids, 'tabs.*.title' => ['required', 'string'], 'tabs.*.child' => ['required', 'string']],
            'Stat' => ['label' => ['required', 'string'], 'value' => ['required', $this->textOrNumber()], 'caption' => ['string'], 'trend' => ['string']],
            'Chart' => [
                'title' => ['required', 'string'],
                'type' => ['required', Rule::in(self::CHART_TYPES)],
                'labels' => $ids,
                'labels.*' => ['string'],
                'datasets' => $ids,
                'datasets.*.label' => ['required', 'string'],
                // un valore per ogni etichetta
                'datasets.*.data' => ['required', 'list', 'size:'.count((array) ($component['labels'] ?? []))],
                'datasets.*.data.*' => ['numeric'],
                'unit' => ['string'],
            ],
            'DataTable' => [
                'title' => ['string'],
                'columns' => $ids,
                'columns.*' => ['string'],
                'rows' => ['present', 'list'],
                // una cella per ogni colonna
                'rows.*' => ['list', 'size:'.count((array) ($component['columns'] ?? []))],
                'rows.*.*' => [$this->textOrNumber()],
            ],
            default => [],
        };
    }

    /**
     * Ogni figlio deve esistere e avere un solo genitore: niente cicli, niente doppi render.
     *
     * @param  Collection<string, array<string, mixed>>  $components
     * @return list<string>
     */
    private function treeErrors(Collection $components): array
    {
        $errors = [];
        $parents = [];

        foreach ($components as $id => $component) {
            foreach ($this->children($component) as $child) {
                if (! $components->has($child)) {
                    $errors[] = "{$id}: il figlio \"{$child}\" non esiste.";
                } elseif ($child === 'root' || isset($parents[$child])) {
                    $errors[] = "{$id}: \"{$child}\" ha già un genitore.";
                }

                $parents[$child] = $id;
            }
        }

        return $errors;
    }

    /**
     * @param  array<string, mixed>  $component
     * @return list<string>
     */
    private function children(array $component): array
    {
        $children = match ($component['component']) {
            'Row', 'Column', 'List' => $component['children'] ?? [],
            'Card' => [$component['child'] ?? null],
            'Tabs' => array_column((array) ($component['tabs'] ?? []), 'child'),
            default => [],
        };

        return array_values(array_filter((array) $children, 'is_string'));
    }

    private function textOrNumber(): Closure
    {
        return static function (string $attribute, mixed $value, Closure $fail): void {
            if (! is_string($value) && ! is_int($value) && ! is_float($value)) {
                $fail("{$attribute} deve essere un testo o un numero.");
            }
        };
    }
}
