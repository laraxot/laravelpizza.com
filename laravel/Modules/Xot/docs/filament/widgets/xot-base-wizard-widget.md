# XotBaseWizardWidget

Classe astratta: `Modules\Xot\Filament\Widgets\XotBaseWizardWidget`  
Estende: [`XotBaseWidget`](./xot-base-widget.md)

## Scopo

Centralizza il comportamento comune ai widget il cui `getFormSchema()` contiene un [`Wizard`](https://filamentphp.com/docs/5.x/schemas/wizards) Filament v5, senza duplicare logica tra moduli.

La regola non è estetica: serve a tenere separati i widget-form generici dai widget con semantica multi-step, così policy, sicurezza e UX restano coerenti in tutto il repository.

## Quando usarla

- Il form principale è un **Wizard** (più `Step`), non un semplice elenco di campi.
- Il widget concreto **deve** implementare `getSteps(): array` (nome ufficiale **`HasWizard`**). Tipicamente delega allo schema (**es.** `TicketForm::getSteps()`) preservando chiavi associative per `?step=privacy`-style URLs.
- Vuoi **policy unica** su `?step=` (solo local/debug o override esplicito via `wizardAllowStepQueryExtra()`).
- Vuoi **costruzione Wizard** con view tema pubblica quando `! inAdmin()`, `persistStepInQueryString()`, `columnSpanFull`.

### Parallelo con `CreateRecord` + HasWizard (Filament)

Nel [pannello](https://filamentphp.com/docs/5.x/resources/creating-records#using-a-wizard) si usa il trait `CreateRecord\Concerns\HasWizard` con `getSteps()` e opzionalmente `hasSkippableSteps()`.

In **frontoffice** ora si **`use`** lo stesso `Filament\Resources\Pages\Concerns\HasWizard` sul widget (`parent::form` = **`XotBaseWidget::form()`**), poi `final getWizardComponent()` aggiunge view tema/pub_theme + policy persistence query.

## Persistenza dopo submit

**Non** espone helper sulla classe base che riscrive lo stato dopo `$this->form->getState()`. La forma del payload per `Model::create` / actions è contratto **schema Filament / dehydrate** più eventuali merge espliciti nel widget dominio (**es.** `owner_id` in [`CreateTicketWizardWidget`](../../../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php)).

Perché: evitare doppioni e "middleware" PHP fragili quando Filament già definisce dove vivono i campi nello stato.

## Quando restare su XotBaseWidget

Widget con form lineare, tabelle, statistiche: usare **`XotBaseWidget`** (o `XotBaseTableWidget` dove previsto).

## Hook da estendere

| Metodo | Ruolo |
|--------|--------|
| `getSteps()` | Metodo (**astratto**); nella Fixcity delega tipicamente a `TicketForm::getSteps()` con chiavi stringa compatibili con `?step=` |
| `hasSkippableSteps()` | Su **`XotBaseWizardWidget`** default **`true`** (UX pubblica); **`HasWizard`** Filament sarebbe **`false`** — override nelle sottoclassi se servono step "bloccati" |
| `wizardAllowStepQueryExtra()` | Consenti salti fuori primo step anche in prod (override modulo) |
| `getWizardComponent()` | **`final`**: `pub_theme::components.wizard` fuori admin + `persistStepInQueryString` |
| Cancel / Submit | da `HasWizard` + view tema (`$getCancelAction()` / `$getSubmitAction()` stringhe) |

## Trait / Blade opzionale

| File | Ruolo breve |
|------|-------------|
| `Modules/Xot/Filament/Traits/DelegatesFilamentWizardSchemaMethods.php` | `goToStep()` / `nextStep` / `previousStep` quando Blade tema invoca Livewire |

## Importante: Regola di Qualità

Tutte le modifiche a widget wizard devono passare attraverso il **quality gate**:

1. **phpstan analyse** - 0 errori richiesti
2. **phpmd.phar** (in ./tools) - nessun errore bloccante  
3. **phpinsights** - nessun errore critico
4. **pest** - test devono passare
5. **puppeteer** e **playwright** - test visuali devono passare
6. **Verifica file .lock** - integrità mantenuta

Decisione tecnica storica / anti-pattern evitati: [`wiki/filament-wizard-refactoring.md`](../../wiki/filament-wizard-refactoring.md).

## Riferimento codice

Implementazione: `laravel/Modules/Xot/app/Filament/Widgets/XotBaseWizardWidget.php`

Esempio dominio: `Modules\Fixcity\Filament\Widgets\CreateTicketWizardWidget`

## Collegamenti

- [XotBaseWidget](./xot-base-widget.md)
- [Indice widget Filament](./index.md)
- [Ticket wizard Fixcity](../../../Fixcity/docs/ticket-wizard-frontoffice.md)
- [Pattern wizard Fixcity](../../../Fixcity/docs/filament-wizard-pattern.md)
- [Regole di qualità](../../../../../../docs/wiki/rules/quality-gate-after-edit.md)