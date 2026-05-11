# Architettura Widget — La Filosofia dei Metodi Privati

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Philosophy / Best Practices  
**Audience**: All developers

---

## Il Problema: Separazione Artificiale

### L'Esempio "Merda"

```php
// ❌ SBAGLIATO: separazione artificiale e inutile
private function createTicketFromFormData(array $data): Ticket
{
    return Ticket::create($this->buildTicketPayload($data));
}

private function buildTicketPayload(array $data): array
{
    return [
        'name' => (string) ($data['title'] ?? ''),
        'content' => (string) ($data['details'] ?? ''),
        // ...
    ];
}
```

### Perche è "Merda" (Filosofia Profonda)

#### 1. Violazione del Principio KISS

**KISS = Keep It Simple, Stupid**

```php
// ❌ COMPLESSO: 2 metodi, 2 chiamate, stack più profondo
Ticket::create($this->buildTicketPayload($data));

// ✅ SEMPLICE: 1 metodo, 1 chiamata, logica inline
Ticket::create([
    'name' => (string) ($data['title'] ?? ''),
    'content' => (string) ($data['details'] ?? ''),
]);
```

**La domanda fondamentale**:
> "Cosa guadagniamo separando in 2 metodi privati?"

**Risposta**: **NULLA**. Non c'è riuso, non c'è testing separato, non c'è leggibilità migliorata.

---

#### 2. Violazione del Principio DRY (paradossalmente)

**DRY = Don't Repeat Yourself**

La separazione ha senso SOLO SE:
- ✅ `buildTicketPayload()` è riutilizzato da più metodi
- ✅ `createTicketFromFormData()` è chiamato da più punti
- ✅ C'è testing separato dei due metodi

**Nel nostro caso**:
- ❌ `buildTicketPayload()` chiamato UNA volta sola (da `createTicketFromFormData()`)
- ❌ `createTicketFromFormData()` chiamato UNA volta sola (da `submit()`)
- ❌ Nessun testing separato (testano solo il flusso completo)

**Risultato**: Abbiamo creato complessità SENZA eliminare duplicazione.

---

#### 3. Violazione della Leggibilità

```php
// ❌ LEGGERE: devo saltare tra 3 metodi per capire il flusso
public function submit(): void
{
    $data = $this->form->getState();
    $ticket = $this->createTicketFromFormData($data);  // → salto a metodo privato
    // ...
}

private function createTicketFromFormData(array $data): Ticket
{
    return Ticket::create($this->buildTicketPayload($data));  // → salto a altro metodo
}

private function buildTicketPayload(array $data): array { /* ... */ }

// ✅ LEGGERE: tutto il flusso è inline, leggo dall'alto in basso
public function submit(): void
{
    $data = $this->form->getState();
    
    $ticket = Ticket::create([
        'name' => (string) ($data['title'] ?? ''),
        'content' => (string) ($data['details'] ?? ''),
        'type' => TicketTypeEnum::tryFrom($data['issueType']) ?? TicketTypeEnum::OTHER,
        'address' => (string) ($data['address'] ?? ''),
        'email' => ($data['email'] ?? '') !== '' ? (string) $data['email'] : null,
    ]);
    
    TicketCreatedEvent::dispatch($ticket);
    $this->redirect('/it/segnalazione-04-conferma');
}
```

**La filosofia**:
> "Il codice deve leggersi come un libro, dall'alto in basso, senza salti mentali."

---

#### 4. Violazione del Principio di Incapsulamento

**Il problema**:
```php
// Questi metodi privati NON sono riutilizzabili:
// - Sono privati (accessibili solo dalla classe)
// - Non sono testabili separatamente (testing unitario impossibile)
// - Non sono documentabili separatamente (PHPDoc separato inutile)
```

**La domanda**:
> "Se non posso riusarli, testarli separatamente, o documentarli, perche esistono?"

**Risposta**: **Nessun motivo valido**. Sono solo complessità nascosta.

---

## La Soluzione: Inline nel Submit

### Il Pattern Corretto

```php
public function submit(): void
{
    try {
        // 1. Validazione (Filament automaticamente)
        $data = $this->form->getState();
        $this->data = $data;
        
        // 2. Costruzione payload (inline, leggibile)
        $issueType = (string) ($data['issueType'] ?? '');
        
        $payload = [
            'name' => (string) ($data['title'] ?? ''),
            'content' => (string) ($data['details'] ?? ''),
            'type' => TicketTypeEnum::tryFrom($issueType) ?? TicketTypeEnum::OTHER,
            'address' => (string) ($data['address'] ?? ''),
            'email' => ($data['email'] ?? '') !== '' ? (string) $data['email'] : null,
        ];
        
        if (auth()->check()) {
            $payload['owner_id'] = auth()->id();
        }
        
        // 3. Creazione modello
        $ticket = Ticket::create($payload);
        
        // 4. Dispatch evento
        TicketCreatedEvent::dispatch($ticket);
        
        // 5. Redirect
        $this->redirect('/'.app()->getLocale().'/tests/segnalazione-04-conferma');
        
    } catch (\Throwable $e) {
        // Gestione errore (user-friendly, NO Log::error)
        $message = (string) __('fixcity::create_ticket_wizard.notifications.submit_failed.body');
        $this->addError('data.submit', $message);
        
        Notification::make()
            ->title((string) __('fixcity::create_ticket_wizard.notifications.submit_failed.title'))
            ->body($message)
            ->danger()
            ->send();
    }
}
```

### I 5 Step del Submit

Ogni submit segue questo flusso:

1. **Validazione** → `$this->form->getState()` (Filament valida automaticamente)
2. **Costruzione payload** → Array con dati dal form (inline, leggibile)
3. **Creazione modello** → `Model::create($payload)`
4. **Dispatch eventi** → `Event::dispatch($model)`
5. **Redirect** → `$this->redirect('/path')`

**La filosofia**:
> "Tutto inline, tutto leggibile, tutto in un metodo."

---

## Quando Separare Ha Senso

### ✅ CASO 1: Riuso Effettivo

```php
// ✅ CORRETTO: buildTicketPayload è riusato da più metodi
private function buildTicketPayload(array $data): array
{
    return [
        'name' => (string) ($data['title'] ?? ''),
        'content' => (string) ($data['details'] ?? ''),
        // ...
    ];
}

public function submit(): void
{
    $data = $this->form->getState();
    $ticket = Ticket::create($this->buildTicketPayload($data));
    // ...
}

public function preview(): void
{
    $data = $this->form->getState();
    $payload = $this->buildTicketPayload($data);  // → RIUSATO!
    $this->dispatch('preview-generated', $payload);
}
```

**La regola**:
> "Separa SOLO se il metodo è chiamato da DUE o più punti diversi."

---

### ✅ CASO 2: Testing Separato

```php
// ✅ CORRETTO: buildTicketPayload ha logica complessa testabile separatamente
/**
 * Costruisce il payload per Ticket con normalizzazione avanzata.
 * 
 * @param array<string, mixed> $data
 * @return array<string, mixed>
 */
private function buildTicketPayload(array $data): array
{
    // Logica complessa: merita testing separato
    $geoData = $this->geocodeAddress($data['address']);
    $category = $this->classifyIssue($data['details']);
    
    return [
        'name' => $this->normalizeTitle($data['title']),
        'content' => $this->sanitizeContent($data['details']),
        'type' => $this->resolveTicketType($data['issueType'], $category),
        'address' => $this->normalizeAddress($data['address'], $geoData),
        'coordinates' => $geoData,
        'category' => $category,
    ];
}

// Test separato:
it('builds ticket payload with geocoding', function () {
    $payload = $this->invokeMethod('buildTicketPayload', [['address' => 'Via Roma 1']]);
    expect($payload['coordinates'])->not->toBeNull();
});
```

**La regola**:
> "Separa SOLO se la logica è abbastanza complessa da meritare testing unitario."

---

### ✅ CASO 3: Documentazione/Contratto Separato

```php
// ✅ CORRETTO: il metodo ha un contratto documentato separatamente
/**
 * Crea un Ticket dai dati del form.
 * 
 * Questo metodo è separato per:
 * - Documentare il contratto di creazione Ticket
 * - Permettere override in sottoclassi
 * - Centralizzare la logica di creazione per audit
 * 
 * @param array<string, mixed> $data
 * @return Ticket
 */
protected function createTicketFromFormData(array $data): Ticket
{
    $payload = $this->buildTicketPayload($data);
    
    $ticket = Ticket::create($payload);
    
    // Audit log centralizzato
    Log::info('Ticket created from form', [
        'ticket_id' => $ticket->id,
        'user_id' => auth()->id(),
    ]);
    
    return $ticket;
}
```

**La regola**:
> "Separa SOLO se il metodo ha un contratto documentato, è protected (overrideabile), o serve per audit trail."

---

## La Filosofia Completa

### I Principi Zen della Separazione

#### 1. "Inline di default"
- Scrivi tutto inline nel metodo principale
- Solo se diventa troppo lungo (>30 righe), valuta separazione

#### 2. "Separa solo se riusi"
- Metodo chiamato 2+ volte? → Separa
- Metodo chiamato 1 volta? → Inline

#### 3. "Separa solo se testi"
- Logica complessa con branch multipli? → Separa + testa
- Logica lineare senza branch? → Inline

#### 4. "Separa solo se documenti"
- Ha un contratto (pre/post condizioni)? → Separa + documenta
- È solo un passaggio intermedio? → Inline

#### 5. "Separa solo se proteggi"
- Deve essere overrideabile da sottoclassi? → `protected` + separa
- È solo interno alla classe? → `private` + inline

---

## La Religione

### I Comandamenti

1. **NON creerai metodi privati senza motivo**
2. **NON separerai logica senza riuso**
3. **NON testerai metodi privati (testa il flusso pubblico)**
4. **NON documenterai metodi privati (documenta il flusso pubblico)**
5. **NON proteggerai metodi senza sottoclassi**

### Il Credo

> "Inline è meglio di separato.  
> Separato è meglio di duplicato.  
> Duplicato è il male assoluto."

---

## Riferimenti Incrociati

- [Wizard Widget Rules](./wizard-widget-rules.md)
- [XotBaseWizardWidget Philosophy](./xot-base-wizard-widget-philosophy.md)
- [Clean Code Principles](../../../../docs/clean-code.md)
- [Laraxot Core Rules](../../../../laraxot-core.md)

---

*Ultimo aggiornamento: 2026-04-14*
