# Filament `CreateRecord` — scopo, pipeline e regola Laraxot

**Fonte codice**: `vendor/filament/filament/src/Resources/Pages/CreateRecord.php` (Filament Panels).  
**Documentazione ufficiale**: [Creating records (Filament v5)](https://filamentphp.com/docs/5.x/resources/creating-records/)

Questa pagina non sostituisce la doc Filament: riassume **perché** esiste la classe, **in che ordine** avvengono le operazioni, e **come** si collega a `XotBaseCreateRecord` nel progetto.

---

## Perché esiste (visione)

`CreateRecord` è la **pagina di resource** del pannello admin dedicata alla creazione di un modello Eloquent da form. Incapsula:

- autorizzazione (`canCreate()` sulla Resource);
- stato form Livewire (`$data`, `statePath('data')` in `defaultForm()`);
- transazione DB opzionale (`CanUseDatabaseTransactions`);
- validazione tramite `$this->form->getState()`;
- persistenza **record + relazioni** (`saveRelationships()` dopo la creazione);
- notifica di successo e redirect coerente con le pagine disponibili (view/edit/index);
- eventi dominio Filament: `RecordCreated`, `RecordSaved`.

Filosofia: **un solo punto** per il flusso “submit form → modello → redirect”, con hook estendibili senza duplicare la coreografia.

---

## Pipeline di `create()` (ordine reale)

1. **Guard re-entrancy**: se `$this->isCreating` è già true, esce (evita doppi submit).
2. **`authorizeAccess()`**: `abort_unless(static::getResource()::canCreate(), 403)`.
3. **Transazione**: `beginDatabaseTransaction()`.
4. Hook **`beforeValidate`** → **`$data = $this->form->getState()`** (validazione inclusa) → **`afterValidate`**.
5. **`mutateFormDataBeforeCreate($data)`** — ultimo punto per arricchire/normalizzare i dati prima del `new Model`.
6. Hook **`beforeCreate`**.
7. **`handleRecordCreation($data)`** — default: `new ($this->getModel())($data)` poi `save()`; con nested resource può associare al parent.
8. **`$this->form->model($record)->saveRelationships()`** — salva relazioni dichiarate nello schema.
9. Hook **`afterCreate`**.
10. Eventi: `RecordCreated`, `RecordSaved`.
11. **`Halt`**: se lanciato, può decidere rollback o commit; interrompe senza redirect.
12. **Errore generico**: rollback transazione, `isCreating = false`, riesecuzione.
13. **Successo**: commit, `rememberData()`, notifica, **`getRedirectUrl()`** + redirect (SPA-aware se `FilamentView::hasSpaMode`).

**Zen**: la maggior parte della logica business “dopo validazione, prima del save” va in **`mutateFormDataBeforeCreate`** o **`handleRecordCreation`**, non in controller esterni.

---

## Politica e sicurezza

- Accesso create: **policy** del modello (`create()`), coerente con `authorizeAccess()`.
- `?step=` e wizard **nel pannello** possono usare `CreateRecord\Concerns\HasWizard` (vedi doc ufficiale): è un percorso **diverso** dal widget frontoffice Laraxot.

---

## Religione Laraxot: non estendere `CreateRecord` direttamente

| Filament | Laraxot |
|----------|---------|
| `Filament\Resources\Pages\CreateRecord` | `Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord` |

`XotBaseCreateRecord` oggi estende la classe Filament senza alterare la pipeline; serve **ancoraggio** e spazio per convenzioni condivise (es. `getDefaultFormData()`). Le pagine dei moduli devono estendere **XotBaseCreateRecord**, non importare `CreateRecord` direttamente.

Riferimenti: [extension-rules.md](../extension-rules.md), [filament.md](../filament.md).

---

## Non confondere con il frontoffice wizard

| Contesto | Classe / pattern |
|----------|------------------|
| Pannello admin, resource CRUD | `CreateRecord` + trait **`HasWizard`** → `getSteps()` / `hasSkippableSteps()` ([doc](https://filamentphp.com/docs/5.x/resources/creating-records#using-a-wizard)) |
| Pannello (senza wizard nel trait) | `CreateRecord` → **`XotBaseCreateRecord`** |
| Frontoffice CMS, wizard multi-step | `XotBaseWizardWidget` + widget dominio (es. `CreateTicketWizardWidget`) — `getWizardSteps()` / `hasSkippableWizardSteps()` |

Il flusso pubblico **non** passa da `CreateRecord::create()`; usa Livewire + form schema del widget e redirect gestito in `submit()`. La filosofia DRY è parallela (stesso `Wizard` Filament, step e skippable) ma **contesto e entrypoint** diversi.

---

## Collegamenti

- [XotBaseResourcePage](../resources/pages/xot-base-resource-page.md) — pagine resource generiche
- [Wizard widget rules](../widgets/wizard-widget-rules.md) — wizard **widget** non panel
- [xot-base-wizard-widget.md](../widgets/xot-base-wizard-widget.md)
- `Modules/Xot/app/Filament/Resources/Pages/XotBaseCreateRecord.php` — implementazione base
