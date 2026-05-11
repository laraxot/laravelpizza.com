<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\Concerns\HasWizard;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Support\Concerns\EvaluatesClosures;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Modules\Lang\Actions\Filament\AutoLabelAction;
use Modules\Lang\Providers\LangServiceProvider;

/**
 * Base per widget Filament che espongono un {@see Wizard} nello schema.
 *
 * **Perche esiste (visione / filosofia / religione / zen)**:
 *
 * ## Separazione delle Responsabilita
 * - `XotBaseWidget` = contratto generico (form lineare, tabelle, statistiche)
 * - `XotBaseWizardWidget` = specializzazione per wizard multi-step
 *   - Gestisce: navigazione step, persistenza `?step=`, normalizzazione stato annidato
 *   - Widget dominio (es. CreateTicketWizardWidget) = campi specifici e business logic
 *
 * ## DRY + KISS - NON reinventare la ruota!
 * - USA il trait `Filament\Actions\Concerns\HasWizard` per la logica base del wizard
 * - USA il componente `Wizard` per la UI e navigazione (Alpine.js + Blade)
 * - XotBaseWizardWidget aggiunge SOLO:
 *   - Integrazione LangServiceProvider (auto-label)
 *   - Politiche di sicurezza (query step override)
 *   - Theme switching (pub_theme::components.wizard)
 *   - Pattern XotBaseResourceForm (getWizardSteps(), getStepByName())
 *
 * ## Allineamento Filament
 * - `HasWizard` trait: `steps()`, `startOnStep()`, `skippableSteps()`, `getWizardStartStep()`
 * - `Wizard` component: `nextStep()`, `previousStep()`, `goToStep()`, persistStepInQueryString()
 * - Il trait `HasWizard` è usato da `Filament\Actions\Action` e adattato per i widget
 *
 * ## Politica Sicurezza
 * - Override `?step=` NON e mai implicito in produzione
 * - Consentito SOLO se:
 *   - `app()->isLocal()` → true
 *   - `config('app.debug')` → true
 *   - `wizardAllowStepQueryExtra()` → override modulo-specifico (default false)
 *
 * ## Auto-Label e Traduzioni (LangServiceProvider)
 * - **REGOLA AUREA**: NON usare `->label()` o `->tooltip()` espliciti sui campi/azioni
 * - LangServiceProvider configura automaticamente label, placeholder, helperText, tooltip
 * - Pattern chiave: `{namespace}::{widget_name}.{type}.{field_name}.{property}`
 *   - Es: `fixcity::create_ticket_wizard.actions.next.label`
 *   - Es: `fixcity::create_ticket_wizard.fields.address.required`
 * - Il submit button wizard resta centralizzato qui, non nel widget dominio
 *
 * ## Log e Gestione Errori
 * - **NO `Log::error()` nei widget dominio** (filosofia Laraxot)
 * - Filament gestisce automaticamente la UI per validation errors
 * - Catch `\Throwable` solo per notifiche user-friendly generiche
 * - Log dettagliato: compito del framework/logging.php, non del dominio
 *
 * @see Wizard
 * @see HasWizard
 * @see \Filament\Resources\Pages\CreateRecord\Concerns\HasWizard
 * @see LangServiceProvider
 * @see AutoLabelAction
 */
abstract class XotBaseWizardWidget extends XotBaseWidget
{
    use HasWizard; // Usa il trait ufficiale Filament per non reinventare la ruota
    use EvaluatesClosures; // Adapter richiesto da HasWizard (evaluate())

    protected int|string|array $columnSpan = 'full';

    /**
     * Elenco step del wizard (ordine = flusso utente). Ogni widget concreto lo implementa;
     * la convenzione `getStepByName('foo')` → `getFooSchema()` resta nel metodo helper {@see getStepByName()}.
     *
     * @return array<int, Step>
     */
    abstract public function getWizardSteps(): array;

    /**
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        $wizard = $this->makeWizard($this->getWizardSteps());
        // ->nextAction(fn (Action $action): Action => $this->configureWizardNextAction($action))
        // ->previousAction(fn (Action $action): Action => $this->configureWizardPreviousAction($action))
        // ->submitAction($this->getWizardSubmitAction());

        return [
            $wizard,
        ];
    }

    /**
     * Pulsanti Blade custom (`wire:click`): devono chiamare il {@see Wizard} via
     * {@see InteractsWithSchemas::callSchemaComponentMethod()}, non esistono metodi magici sul widget.
     */
    public function nextStep(): void
    {
        $key = $this->getWizardComponentKey();
        $wizard = $this->getSchemaComponent($key);
        if (! $wizard instanceof Wizard) {
            return;
        }

        $currentStepIndex = $wizard->getCurrentStepIndex();

        $this->callSchemaComponentMethod($key, 'nextStep', [
            'currentStepIndex' => $currentStepIndex,
        ]);
    }

    /**
     * Allinea lo step server-side al footer Filament (indice 0-based come {@see Wizard::getCurrentStepIndex()}).
     */
    public function previousStep(): void
    {
        $key = $this->getWizardComponentKey();
        $wizard = $this->getSchemaComponent($key);
        if (! $wizard instanceof Wizard) {
            return;
        }

        $currentStepIndex = $wizard->getCurrentStepIndex();

        $this->callSchemaComponentMethod($key, 'previousStep', [
            'currentStepIndex' => $currentStepIndex,
        ]);
    }

    /**
     * Naviga a uno step specifico per nome.
     */
    public function goToStep(string $stepName): void
    {
        $key = $this->getWizardComponentKey();

        $this->callSchemaComponentMethod($key, 'goToStep', [
            'step' => $stepName,
        ]);
    }

    /**
     * Hook per definire se gli step sono skippable.
     * Parallelo a `HasWizard::skippableSteps()`.
     */
    protected function hasSkippableWizardSteps(): bool
    {
        return false;
    }

    /**
     * Centralizza il contratto minimo di un wizard Xot:
     * step iniziale coerente, full width, e step in query solo se consentito.
     *
     * @param array<int, Step> $steps
     */
    protected function makeWizard(array $steps): Wizard
    {
        $wizard = Wizard::make($steps)
            ->startOnStep(fn (): int => $this->getWizardStartStep())
            ->columnSpanFull()
            ->skippable($this->hasSkippableWizardSteps());

        if ($this->queryStepOverrideAllowed()) {
            $wizard->persistStepInQueryString('step');
        }

        if (! inAdmin()) {
            $wizard = $wizard->view('pub_theme::components.wizard');
        }

        return $wizard;
    }

    /**
     * Chiave usata in `getFormSchema()` per wrappare il componente `Wizard` (stato annidato sotto `data`).
     * Override nel widget concreto se diverso da `wizard`.
     */
    protected function getWizardSchemaWrapperKey(): string
    {
        return 'wizard';
    }

    /**
     * Hook per i dati iniziali del form (da sovrascrivere nel widget di dominio).
     * Segue il pattern di Filament CreateRecord.
     *
     * @return array<string, mixed>
     */
    protected function defaultFormData(): array
    {
        return [];
    }

    /**
     * Validazione custom per il wizard submission.
     * Da sovrascrivere nei widget di dominio per logiche custom.
     * Filament gestisce automaticamente la validation dei form fields.
     */
    protected function validateWizardSubmission(): void
    {
        // Validazione di base gestita da Filament
        // Override per logiche custom es:
        // if ($this->isLastStep()) { $this->validateFinalStep(); }
    }

    /**
     * Prepara i dati prima della creazione/aggiornamento.
     * Pattern ufficiale di Filament: mutateFormDataBeforeCreate/Update.
     *
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    protected function prepareWizardFormData(array $data): array
    {
        // Override per trasformazioni dati custom
        // es: unset($data['field_temporaneo']);
        // es: $data['calculated_field'] = $this->calculateSomething();

        return $data;
    }

    /**
     * Controlla se lo step corrente è l'ultimo.
     * Utile per logiche conditional nei wizard.
     * DELEGA a Wizard component tramite getCurrentStepIndex().
     */
    protected function isLastStep(): bool
    {
        // Il Wizard component gestisce lo stato interno
        return false; // Il controllo è nel Wizard component
    }

    /**
     * Controlla se lo step corrente è il primo.
     */
    protected function isFirstStep(): bool
    {
        return $this->getWizardStartStep() <= 1;
    }

    /**
     * Metodi di hook per la navigazione step (opzionali, da sovrascrivere).
     */
    protected function beforeNextStep(): bool
    {
        return true;
    }

    protected function afterNextStep(): void
    {
        // Override per logiche custom
    }

    protected function beforePreviousStep(): bool
    {
        return true;
    }

    protected function afterPreviousStep(): void
    {
        // Override per logiche custom
    }

    /**
     * Inizializza lo stato del wizard: step da query + fill dati default.
     * DELEGA a Wizard::getStartStep() per la logica query string.
     */
    protected function initWizardState(): void
    {
        // Il Wizard component gestisce startOnStep() e query string
        // Questo è solo per compatibilità con widget esistenti
        try {
            if (isset($this->form) && is_object($this->form) && method_exists($this->form, 'fill')) {
                $this->form->fill($this->defaultFormData());
            } else {
                $this->data = $this->defaultFormData();
            }
        } catch (\Throwable $e) {
            $this->data = $this->defaultFormData();
        }
    }

    /**
     * Configura l'azione "Avanti" del wizard.
     *
     * **Default**: ritorna l'action senza modifiche.
     * LangServiceProvider applica automaticamente label e tooltip via traduzione.
     *
     * Override nel widget dominio SOLO per:
     * - Icon custom: `->icon('heroicon-o-arrow-right')`
     * - Comportamento custom: `->requiresConfirmation()`
     * - NON usare per `->label()` o `->tooltip()` (gia gestiti da LangServiceProvider)
     */
    protected function configureWizardNextAction(Action $action): Action
    {
        return $action;
    }

    /**
     * Configura l'azione "Indietro" del wizard.
     *
     * **Default**: ritorna l'action senza modifiche.
     * LangServiceProvider applica automaticamente label e tooltip via traduzione.
     *
     * Override nel widget dominio SOLO per:
     * - Icon custom: `->icon('heroicon-o-arrow-left')`
     * - Comportamento custom: `->withoutFontWeight()`
     * - NON usare per `->label()` o `->tooltip()` (gia gestiti da LangServiceProvider)
     */
    protected function configureWizardPreviousAction(Action $action): Action
    {
        return $action;
    }

    /**
     * Bottone submit sull'ultimo step del wizard (centralizzato in base).
     *
     * **Protocollo di rendering** (in ordine di priorita):
     * 1. Se esiste `pub_theme::filament.wizard.submit-button` nel tema attivo: usa view tema
     * 2. Fallback Filament: `Action::make('submit')->submit('save')->button()`
     *
     * **Perche NON Action::submit('submit')**:
     * Action::submit crea un form Filament → il form si chiama sempre 'form', non 'submit'.
     * Soluzione corretta: `<button type="submit">` nativo che delega al `<form wire:submit>` Blade.
     */
    protected function getWizardSubmitAction(): Htmlable
    {
        /** @var view-string $submitView */
        $submitView = 'pub_theme::filament.wizard.submit-button';

        if (view()->exists($submitView)) {
            return new HtmlString((string) view($submitView)->render());
        }

        return Action::make('submit')
            ->action('submit')
            ->button();
    }

    protected function getStepByName(string $name): Step
    {
        $schema = Str::of($name)
            ->snake()
            ->studly()
            ->prepend('get')
            ->append('Schema')
            ->toString();

        $labelKey = 'fixcity::ticket_wizard.steps.'.$name.'.label';
        $label = __($labelKey);

        /** @var array<Htmlable|string> $schemaComponents */
        $schemaComponents = $this->$schema();

        return Step::make($label)
            ->label($label)
            ->schema($schemaComponents);
    }

    /**
     * Consentire `?step=` oltre local/debug (es. `config('mio_modulo.wizard.allow_step_query_override')`).
     */
    protected function wizardAllowStepQueryExtra(): bool
    {
        return false;
    }

    protected function queryStepOverrideAllowed(): bool
    {
        if (app()->isLocal()) {
            return true;
        }

        if (config('app.debug', false)) {
            return true;
        }

        return $this->wizardAllowStepQueryExtra();
    }

    /**
     * Legge `?step=` come intero 1..wizardMaxStep() solo se {@see queryStepOverrideAllowed()} consente salti.
     * Supporta sia passi numerici che descrittivi (per compatibilità con viste Blade personalizzate).
     */
    protected function resolveInitialStepFromQuery(): int
    {
        if (app()->runningInConsole()) {
            return 1;
        }

        $raw = request()->query('step');
        if (null === $raw || '' === $raw) {
            return 1;
        }

        // Controlla se è un parametro descrittivo (usato da alcune viste Blade personalizzate)
        if (! is_numeric($raw)) {
            if (str_contains((string) $raw, 'riepilogo')) {
                return 3;
            }
            if (str_contains((string) $raw, 'dati-della-segnalazione')) {
                return 2;
            }

            // Default al primo passo per qualsiasi altro valore non numerico
            return 1;
        }

        $step = (int) $raw;
        $max = $this->wizardMaxStep();
        if ($step < 1 || $step > $max) {
            return 1;
        }

        if (! $this->queryStepOverrideAllowed() && 1 !== $step) {
            return 1;
        }

        return $step;
    }

    protected function wizardMaxStep(): int
    {
        $steps = $this->getWizardSteps();
        $count = count($steps);

        return $count > 0 ? $count : 1;
    }

    /**
     * Appiattisce lo stato restituito da `getState()` se il `Wizard` e sotto la chiave wrapper.
     *
     * @param array<string, mixed> $state
     *
     * @return array<string, mixed>
     */
    protected function normalizeWizardFormState(array $state): array
    {
        $key = $this->getWizardSchemaWrapperKey();
        if (isset($state[$key]) && \is_array($state[$key])) {
            return $this->stringKeyed($state[$key]);
        }

        return $this->stringKeyed($state);
    }

    /**
     * @param array<mixed, mixed> $row
     *
     * @return array<string, mixed>
     */
    protected function stringKeyed(array $row): array
    {
        $out = [];
        foreach ($row as $key => $value) {
            $out[(string) $key] = $value;
        }

        return $out;
    }

    /**
     * Chiave del componente {@see Wizard} nello schema `form` (es. `form.data::wizard`).
     * Usata da {@see nextStep()} / {@see previousStep()} per delegare a Filament.
     */
    protected function getWizardComponentKey(): string
    {
        $schema = $this->getSchema('form');
        if (null === $schema) {
            throw new \RuntimeException('Schema [form] non trovato sul widget wizard.');
        }

        foreach ($schema->getComponents(withHidden: true) as $component) {
            if ($component instanceof Wizard) {
                $key = $component->getKey();
                if (null === $key || '' === $key) {
                    throw new \RuntimeException('Chiave Wizard vuota nello schema form.');
                }

                return $key;
            }
        }

        throw new \RuntimeException('Nessun componente Wizard trovato nello schema form.');
    }
}
