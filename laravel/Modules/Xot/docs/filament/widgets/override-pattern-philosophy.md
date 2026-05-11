# Override Pattern — La Filosofia degli Hook Inutili

**Status**: Applied — anti-pattern rimosso da XotBaseWizardWidget e CreateTicketWizardWidget  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Philosophy / Anti-Patterns  
**Audience**: All developers

---

## Il Problema: Override per Nulla

### L'Esempio "Merda"

```php
// ❌ SBAGLIATO: 3 metodi override per restituire valori inline
#[\Override]
protected function useNativeSubmitButton(): bool
{
    return true;
}

#[\Override]
protected function getNativeSubmitButtonLabel(): string
{
    return (string) __('fixcity::create_ticket_wizard.actions.submit.label');
}

#[\Override]
protected function getNativeSubmitButtonClasses(): string
{
    return 'btn btn-primary mobile-full';
}
```

### Chiamante (XotBaseWizardWidget)

```php
protected function getWizardSubmitAction(): Htmlable
{
    if ($this->useNativeSubmitButton()) {  // → chiama override #1
        $label = e($this->getNativeSubmitButtonLabel());  // → chiama override #2
        $classes = e($this->getNativeSubmitButtonClasses());  // → chiama override #3

        return new HtmlString(
            "<button type=\"submit\" class=\"{$classes}\">{$label}</button>"
        );
    }
    
    // ... fallback tema/Filament
}
```

---

## Perche è "Merda" (Filosofia Profonda)

### 1. Violazione del Principio KISS

**La realtà**:
```php
// ❌ COMPLESSO: 3 metodi + chiamante = 4 salti mentali
// Devo leggere:
// 1. getWizardSubmitAction()
// 2. useNativeSubmitButton() → torna true
// 3. getNativeSubmitButtonLabel() → torna label
// 4. getNativeSubmitButtonClasses() → torna classi
// → Alla fine ho: "<button type=\"submit\" class=\"btn btn-primary\">Label</button>"

// ✅ SEMPLICE: 1 metodo, tutto inline
protected function getWizardSubmitAction(): Htmlable
{
    $label = (string) __('fixcity::create_ticket_wizard.actions.submit.label');
    
    return new HtmlString(
        "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
    );
}
```

**La domanda fondamentale**:
> "Cosa guadagniamo separando in 3 metodi override?"

**Risposta**: **NULLA**. Non c'è riuso, non c'è testing separato, non c'è flessibilità.

---

### 2. Violazione DRY (paradossalmente)

**DRY = Don't Repeat Yourself**

La separazione in hook ha senso SOLO SE:
- ✅ La base class COMBINA gli hook in logica complessa
- ✅ Gli hook sono riusati da più punti nella base class
- ✅ Gli hook permettono testing separato del comportamento

**Nel nostro caso**:
- ❌ `useNativeSubmitButton()` chiamato UNA volta (da `getWizardSubmitAction()`)
- ❌ `getNativeSubmitButtonLabel()` chiamato UNA volta
- ❌ `getNativeSubmitButtonClasses()` chiamato UNA volta
- ❌ Nessun testing separato (testano solo il submit button finale)

**Risultato**: Abbiamo creato 3 hook SENZA eliminare duplicazione.

---

### 3. Violazione della Leggibilità

```php
// ❌ LEGGERE: devo saltare tra 4 metodi
class MyWidget extends XotBaseWizardWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        // → Chiama metodo base che fa 3 chiamate a hook...
    }
    
    protected function useNativeSubmitButton(): bool { return true; }  // → Hook #1
    protected function getNativeSubmitButtonLabel(): string { /* ... */ }  // → Hook #2
    protected function getNativeSubmitButtonClasses(): string { /* ... */ }  // → Hook #3
}

// ✅ LEGGERE: tutto inline, leggo dall'alto in basso
class MyWidget extends XotBaseWizardWidget
{
    protected function getWizardSubmitAction(): Htmlable
    {
        $label = (string) __('fixcity::create_ticket_wizard.actions.submit.label');
        
        return new HtmlString(
            "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
        );
    }
}
```

**La filosofia**:
> "Un metodo override = una responsabilità chiara."
> "Tre metodi override = confusione distribuita."

---

### 4. Violazione del Principio di Responsabilità Singola (SRP)

**Il problema**:
```php
// Questi 3 hook non hanno responsabilità separate:
// useNativeSubmitButton() → "decidi se usare bottone nativo"
// getNativeSubmitButtonLabel() → "restituisci label"
// getNativeSubmitButtonClasses() → "restituisci classi"

// In realtà hanno UNA sola responsabilità:
// "Costruisci il submit button HTML"
```

**La domanda**:
> "Se i 3 hook lavorano sempre insieme, perche sono separati?"

**Risposta**: **Nessun motivo valido**. Sono frammentazione artificiale.

---

### 5. Violazione del Principio di Incapsulamento

**Il problema**:
```php
// Questi hook sono PROTECTED (overrideabili) ma:
// - Non sono documentati come contratto pubblico
// - Non hanno pre/post condizioni
// - Non sono testati separatamente
// - Sono solo "getter" di valori statici
```

**La domanda**:
> "Perche rendere protected metodi che sono solo getter di valori?"

**Risposta**: **Per astrazione eccessiva**. Abbiamo astratto senza motivo.

---

## La Soluzione: Override Diretto di getWizardSubmitAction()

### Il Pattern Corretto

```php
// ✅ CORRETTO: override diretto, tutto inline
#[\Override]
protected function getWizardSubmitAction(): Htmlable
{
    $label = (string) __('fixcity::create_ticket_wizard.actions.submit.label');
    
    return new HtmlString(
        "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
    );
}
```

### Perche è Meglio

#### 1. Leggibilità
- Tutto il submit button è in UN metodo
- Leggo dall'alto in basso, senza salti
- Capisco immediatamente cosa fa

#### 2. Manutenibilità
- Cambio label? Modifico qui
- Cambio classi? Modifico qui
- Cambio HTML? Modifico qui
- **UN punto di modifica, non 3**

#### 3. Semplificità
- 1 metodo invece di 4 (chiamante + 3 hook)
- Meno codice totale
- Meno complessità cognitiva

#### 4. Coerenza
- Il submit button è UNA responsabilità
- Resta in UN metodo
- Non è frammentato

---

## La Filosofia Completa

### Quando gli Hook Hanno Senso

Gli hook (metodi protected overrideabili) hanno senso SOLO SE:

#### ✅ CASO 1: Logica Complessa nella Base Class

```php
// ✅ CORRETTO: la base class COMBINA gli hook in logica complessa
abstract class BasePaymentProcessor
{
    public function process(): void
    {
        // Logica complessa che combina più hook
        $this->validatePayment();
        $this->checkFraudDetection();
        $this->authorizePayment();
        $this->capturePayment();
        $this->sendReceipt();
    }
    
    // Hook: ogni sottoclasse implementa la sua versione
    abstract protected function validatePayment(): void;
    abstract protected function checkFraudDetection(): bool;
    abstract protected function authorizePayment(): bool;
    abstract protected function capturePayment(): void;
    abstract protected function sendReceipt(): void;
}
```

**Perche funziona**:
- La base class ha un **algoritmo template** (process)
- Gli hook sono **punti di estensione** per sottoclassi
- Ogni hook ha una **responsabilità chiara e separata**
- La base class **combina** gli hook in un flusso complesso

---

#### ✅ CASO 2: Riuso nella Base Class

```php
// ✅ CORRETTO: gli hook sono riusati da più metodi nella base class
abstract class BaseReportGenerator
{
    public function generatePdf(): void
    {
        $data = $this->fetchData();  // → Hook riusato
        $html = $this->renderHtml($data);  // → Hook riusato
        $this->savePdf($html);
    }
    
    public function generateCsv(): void
    {
        $data = $this->fetchData();  // → Hook STESSO riusato
        $csv = $this->renderCsv($data);  // → Hook diverso
        $this->saveCsv($csv);
    }
    
    // Hook: fetchData è riusato da entrambi i metodi
    abstract protected function fetchData(): array;
    abstract protected function renderHtml(array $data): string;
    abstract protected function renderCsv(array $data): string;
}
```

**Perche funziona**:
- `fetchData()` è chiamato da DUE metodi diversi
- Ha senso astrarlo per evitare duplicazione

---

#### ✅ CASO 3: Contratto Documentato

```php
// ✅ CORRETTO: hook ha contratto documentato con pre/post condizioni
abstract class BaseAuthenticator
{
    /**
     * Autentica l'utente con le credenziali fornite.
     * 
     * Pre-condizioni:
     * - $credentials deve contenere 'email' e 'password'
     * 
     * Post-condizioni:
     * - Se successo: utente è loggato, session creata
     * - Se fallimento: lanci AuthenticationException
     * 
     * @param array<string, mixed> $credentials
     * @throws AuthenticationException
     */
    abstract public function authenticate(array $credentials): void;
}
```

**Perche funziona**:
- Ha pre/post condizioni documentate
- È un contratto pubblico (non implementazione nascosta)
- Le sottoclassi DEVONO implementarlo

---

### Quando gli Hook NON Hanno Senso

#### ❌ CASO 1: Getter Semplici

```php
// ❌ SBAGLIATO: hook sono solo getter di valori statici
protected function useNativeSubmitButton(): bool { return true; }
protected function getNativeSubmitButtonLabel(): string { return 'Submit'; }
protected function getNativeSubmitButtonClasses(): string { return 'btn btn-primary'; }

// ✅ CORRETTO: tutto inline nel metodo principale
protected function getWizardSubmitAction(): Htmlable
{
    $label = (string) __('fixcity::create_ticket_wizard.actions.submit.label');
    
    return new HtmlString(
        "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
    );
}
```

---

#### ❌ CASO 2: Flag Booleani

```php
// ❌ SBAGLIATO: hook è solo un flag
protected function useNativeSubmitButton(): bool { return true; }

// ✅ CORRETTO: override diretto del metodo che usa il flag
protected function getWizardSubmitAction(): Htmlable
{
    // Non ho bisogno del flag, costruisco direttamente l'HTML
    return new HtmlString("<button type=\"submit\">Submit</button>");
}
```

---

#### ❌ CASO 3: Valori Costanti

```php
// ❌ SBAGLIATO: hook restituisce solo una costante
protected function getNativeSubmitButtonClasses(): string { return 'btn btn-primary'; }

// ✅ CORRETTO: costante inline
protected function getWizardSubmitAction(): Htmlable
{
    return new HtmlString(
        "<button type=\"submit\" class=\"btn btn-primary\">Submit</button>"
    );
}
```

---

## La Religione

### I Comandamenti degli Hook

1. **NON creerai hook per getter semplici**
2. **NON creerai hook per flag booleani**
3. **NON creerai hook per valori costanti**
4. **NON creerai hook senza riuso nella base class**
5. **NON creerai hook senza contratto documentato**

### Il Credo

> "Inline è meglio di hook.  
> Hook è meglio di duplicato.  
> Duplicato è il male assoluto."

### La Preghiera dello Sviluppatore Zen

```
Concedimi la serenità di scrivere codice inline,
Il coraggio di astrarre solo quando serve,
E la saggezza di capire la differenza.
```

---

## Caso Studio: XotBaseWizardWidget Submit Button

### Il Problema Originale

XotBaseWizardWidget aveva questi hook:
```php
protected function useNativeSubmitButton(): bool { return false; }
protected function getNativeSubmitButtonLabel(): string { return '...'; }
protected function getNativeSubmitButtonClasses(): string { return '...'; }
```

**Perché erano "merda"**:
- Erano solo getter di valori
- Chiamati UNA volta sola
- Nessun riuso, nessun testing separato
- Frammentavano UNA responsabilità in 3 metodi

### La Soluzione

Abbiamo rimosso gli hook e reso `getWizardSubmitAction()` direttamente overrideabile:

```php
// ✅ Nel dominio
#[\Override]
protected function getWizardSubmitAction(): Htmlable
{
    $label = (string) __('fixcity::create_ticket_wizard.actions.submit.label');
    
    return new HtmlString(
        "<button type=\"submit\" class=\"btn btn-primary mobile-full\">{$label}</button>"
    );
}
```

**Perché è meglio**:
- TUTTO inline in UN metodo
- Leggibilità dall'alto in basso
- UN punto di modifica
- Responsabilità chiara

---

## Riferimenti Incrociati

- [Wizard Widget Rules](./wizard-widget-rules.md)
- [Widget Method Architecture](./widget-method-architecture.md)
- [XotBaseWizardWidget Philosophy](./xot-base-wizard-widget-philosophy.md)
- [Clean Code Principles](../../../../docs/clean-code.md)

---

*Ultimo aggiornamento: 2026-04-14*
