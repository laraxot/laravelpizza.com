# XotBaseWizardWidget — Filosofia Completa

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Philosophy / Filament  
**Related Rules**: [wizard-widget-rules.md](./wizard-widget-rules.md)

---

## La Filosofia Completa (Zen Laraxot)

### Perche XotBaseWizardWidget Esiste

```
XotBaseWidget (contratto generico: form + statePath('data'))
       ↓
XotBaseWizardWidget (specializzazione: wizard multi-step)
       ↓
CreateTicketWizardWidget (dominio concreto: creazione ticket)
```

### I 6 Pilastri

#### 1. Separazione delle Responsabilita

**Il problema che risolviamo**:
Senza `XotBaseWizardWidget`, ogni modulo reinventa:
- Come leggere `?step=` dalla query string
- Come validare che lo step sia nel range 1..N
- Come permettere/negare l'override di `?step=` in produzione
- Come appiattire lo stato annidato del form (`data['wizard']['address']` → `data['address']`)
- Come gestire la navigazione Avanti/Indietro
- Come renderizzare il pulsante Submit correttamente

**Il risultato**: 10+ implementazioni divergenti, bug inconsistenti, policy di sicurezza incoerenti.

**La soluzione**: UNA sola base class che gestisce il **protocollo**, il dominio gestisce il **contenuto**.

Il contratto esplicito sulla base è `abstract public function getWizardSteps(): array` (ordine degli step); `getFormSchema()` consuma solo API definite, così static analysis e IDE non inferiscono metodi fantasma.

---

#### 2. DRY + KISS

**DRY (Don't Repeat Yourself)**:
- Logica `?step=` scritta UNA volta in `resolveInitialStepFromQuery()`
- Normalizzazione stato scritta UNA volta in `normalizeWizardFormState()`
- Policy sicurezza scritta UNA volta in `queryStepOverrideAllowed()`

**KISS (Keep It Simple, Stupid)**:
- Il widget dominio chiama metodi ereditati, non reinventa logica
- Override solo per comportamento domain-specific (campi, validazione, redirect)
- Nessun boilerplate ripetuto in ogni modulo

---

#### 3. Allineamento Filament

**Principio**: NON sostituiamo Filament, lo **incorniciamo** con hook Laraxot.

**Esempio**:
```php
// ❌ SBAGLIATO: reinventiamo la navigazione wizard
public function nextStep(): void { /* nostra logica custom */ }
public function previousStep(): void { /* nostra logica custom */ }

// ✅ CORRETTO: delegamo a Filament Wizard
protected function makeWizard(array $steps): Wizard
{
    return Wizard::make($steps)
        ->startOnStep(fn(): int => $this->wizardStartStep)
        ->columnSpanFull();
}
```

**Perche**:
- Filament Wizard e testato, mantenuto, documentato
- La nostra base class aggiunge hook, non sostituisce funzionalita
- Se Filament aggiorna il Wizard, noi beneficiamo automaticamente

---

#### 4. Politica Sicurezza

**Il problema**:
Permettere `?step=3` in produzione significa:
- Saltare validazione step precedenti
- Possibile accesso a dati non ancora raccolti
- Violazione del flusso utente progettato

**La soluzione**:
```php
protected function queryStepOverrideAllowed(): bool
{
    // 1. Ambiente local → sempre consentito (sviluppo)
    if (app()->isLocal()) return true;
    
    // 2. Debug mode → consentito (testing/QA)
    if (config('app.debug', false)) return true;
    
    // 3. Hook modulo-specifico → esplicito opt-in
    return $this->wizardAllowStepQueryExtra();
}
```

**Filosofia**:
- **Mai** implicito in produzione
- **Sempre** esplicito (local, debug, config)
- **Never trust, always verify**

---

#### 5. Auto-Label e Traduzioni (LangServiceProvider)

**Il problema storico**:
```php
// ❌ PRIMA: ogni sviluppatore scrive label diverse
TextInput::make('address')->label('Indirizzo')  // Mario
TextInput::make('address')->label('indirizzo')  // Luigi (minuscolo!)
TextInput::make('address')->label('Address')    // Giovanni (inglese!)
```

**Risultato**:
- Incoerenza UI (maiuscole/minuscole, lingue miste)
- Traduzioni mancanti (dimenticate, non standardizzate)
- Boilerplate ripetuto (1000+ `->label()` calls nel progetto)

**La soluzione (LangServiceProvider)**:
```php
// ✅ DOPO: label auto-applicate da AutoLabelAction
TextInput::make('address')
    ->required()  // Label applicata automaticamente!
```

**Come funziona**:
1. `AutoLabelAction` inspects call stack via `debug_backtrace()`
2. Trova la classe chiamante (es. `CreateTicketWizardWidget`)
3. Deriva chiave traduzione: `fixcity::create_ticket_wizard`
4. Costruisce label key: `fixcity::create_ticket_wizard.fields.address.label`
5. Applica traduzione: `$component->label(trans($label_key))`
6. Se traduzione non esiste, la salva automaticamente

**La filosofia**:
> "Lo sviluppatore descrive INTENZIONE, il sistema applica CONVENZIONE."

**La religione**:
> "Niente `->label()` espliciti. Mai. Senza eccezioni."

**Il perche profondo**:
- **i18n by default**: ogni campo e traducibile senza sforzo
- **Consistenza**: label seguono convenzione, non gusti personali
- **Mantenibilita**: cambio traduzione in UN posto (lang file), non in 100 file
- **Developer experience**: meno boilerplate, piu focus su dominio

---

#### 6. Log e Gestione Errori

**Il problema**:
```php
// ❌ PRIMA: ogni widget scrive log a modo suo
catch (\Throwable $e) {
    Log::error('Submit fallito', [
        'message' => $e->getMessage(),
        'data' => $data,
        'user' => auth()->user(),
        // ... ogni sviluppatore inventa il suo formato
    ]);
}
```

**Risultato**:
- Log duplicati (widget + framework logging)
- Formati inconsistenti (difficile parsing automatico)
- Dati sensibili nei log (privacy risk)
- Confusione: dove guardare quando qualcosa fallisce?

**La soluzione (filosofia Laraxot)**:
```php
// ✅ DOPO: widget mostra solo notifica user-friendly
catch (\Throwable $e) {
    $message = (string) __('mymodule::widget.notifications.submit_failed.body');
    
    $this->addError('data.submit', $message);
    
    Notification::make()
        ->title('Errore')
        ->body($message)
        ->danger()
        ->send();
    
    // Log dettagliato: compito di logging.php (Monolog handlers)
}
```

**La filosofia**:
> "Il dominio mostra messaggi user-friendly, il framework gestisce i log."

**La religione**:
> "NO `Log::error()` nei widget dominio. Mai. Senza eccezioni."

**Il perche profondo**:
- **Separazione delle responsabilita**: dominio ≠ infrastruttura
- **User experience**: messaggio generico e tradotto, niente stack trace
- **Security**: niente dettagli tecnici esposti all'utente
- **Consistenza**: log gestiti centralmente (logging.php), non sparsi nel codice
- **Debugging**: sviluppatori guardano log del framework, non del dominio

**Eccezioni (rare)**:
- Widget che gestiscono auth/logout (es. `LogoutWidget`) → log necessario per security audit
- Widget che caricano moduli dinamici (es. `ModulesOverviewWidget`) → log per graceful degradation
- **Regola**: solo se il fallimento richiede audit trail o recovery strategico

---

## La Visione Completa

### Il Flusso di un Wizard

```
Utente → Wizard Step 1 → Step 2 → Step 3 → Submit
            ↓              ↓         ↓        ↓
        Validazione → Persistenza → Redir → Evento
```

**XotBaseWizardWidget** gestisce:
- ✅ Navigazione (Avanti/Indietro)
- ✅ Persistenza `?step=` in query string
- ✅ Validazione range step (1..N)
- ✅ Normalizzazione stato annidato
- ✅ Policy sicurezza (chi puo override `?step=`)
- ✅ Rendering submit button (tema o custom)

**Domain Widget** gestisce:
- ✅ Campi specifici di ogni step
- ✅ Validazione dominio-specifica
- ✅ Creazione modello (es. `Ticket::create()`)
- ✅ Dispatch eventi (es. `TicketCreatedEvent`)
- ✅ Redirect post-submit

### Il Perche dell'Architettura

**Domanda**: "Perche non mettere tutto in XotBaseWidget?"

**Risposta**: Perche un widget con form lineare NON ha bisogno di:
- Navigazione multi-step
- Persistenza `?step=`
- Normalizzazione stato annidato
- Policy sicurezza step query

**Separazione delle responsabilita**:
- `XotBaseWidget` = form singolo, tabelle, statistiche
- `XotBaseWizardWidget` = wizard multi-step (specializzazione)
- Ogni dominio sceglie il livello giusto

---

## Lo Zen del Wizard Widget

### I Principi Zen

#### 1. "Il dominio descrive, la base governa"
- Dominio: "Voglio 3 step con questi campi"
- Base: "Gestisco navigazione, sicurezza, stato"

#### 2. "Meno e meglio"
- NO boilerplate ripetuto
- NO reinvenzione logica comune
- NO duplicazione traduzioni

#### 3. "Convenzione sopra configurazione"
- Label auto-applicate da LangServiceProvider
- Submit button con fallback tema → Filament
- Step query con policy sicura by default

#### 4. "Fidati del framework"
- Filament Wizard gestisce navigazione
- Filament validation gestisce errori
- Framework logging gestisce log

#### 5. "Separa sempre"
- Dominio ≠ Infrastruttura
- Contenuto ≠ Protocollo
- UI ≠ Log

---

## Riferimenti Incrociati

- [Wizard Widget Rules](./wizard-widget-rules.md)
- [XotBaseWizardWidget Implementation](../../../app/Filament/Widgets/XotBaseWizardWidget.php)
- [LangServiceProvider](../../../../Lang/app/Providers/LangServiceProvider.php)
- [AutoLabelAction](../../../../Lang/app/Actions/Filament/AutoLabelAction.php)
- [CreateTicketWizardWidget Example](../../../../Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php)

---

*Ultimo aggiornamento: 2026-04-14*
