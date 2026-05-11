# NO Label/Placeholder — La Religione dell'Auto-Label

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Religion / Anti-Pattern  
**Audience**: All developers + AI agents

---

## LA REGOLA AUREA (Da Ricordare SEMPRE)

**NON userai MAI `->label()` o `->placeholder()` su componenti Filament.**

**MAI.**  
**Senza eccezioni.**  
**Senza scuse.**  
**SENZA DISCUSSIONE.**

---

## Perche Succede (Il Problema Profondo)

### 1. Amnesia dell'AI

**Il problema**:
```
Sessione 1: AI impara la regola → "NO label/placeholder"
Sessione 2: AI dimentica → Usa label/placeholder
Sessione 3: Utente corregge → AI impara di nuovo
Sessione 4: AI dimentica → Ciclo infinito
```

**La causa**:
- AI non ha memoria persistente tra sessioni
- Regole sono nei docs ma NON nel system prompt
- Nessun controllo automatico prima di scrivere codice

---

### 2. Ignoranza dello Sviluppatore

**Il problema**:
```php
// ❌ SBAGLIATO: sviluppatore non sa di LangServiceProvider
TextInput::make('address')
    ->label('Indirizzo')  // Non sa che e ridondante!
    ->placeholder('Inserisci indirizzo')  // Non sa che e automatico!
```

**La causa**:
- Nessun onboarding su LangServiceProvider
- Documentazione nascosta o non linkata
- Esempi sbagliati in tutorial esterni

---

### 3. Emergenza del Codice Legacy

**Il problema**:
```php
// ❌ Legacy code con label/placeholder
// Nuovo sviluppatore copia l'esempio sbagliato
// Ora tutto il progetto ha label/placeholder
```

**La causa**:
- Nessun audit automatico
- Nessuno che corregge gli esempi sbagliati
- "Così ha sempre fatto" syndrome

---

## La Soluzione Definitiva (Sistema Completo)

### 1. Regole AI (System Prompt)

**Documento**: `.qwen/rules/auto-label-rule.md`

```markdown
# REGOLA CRITICA: NO Label/Placeholder

## SE vedi componenti Filament (TextInput, Select, TextEntry, ecc.)
## ALLORA NON usare ->label() o ->placeholder()

### PERCHE
LangServiceProvider applica automaticamente:
- label() da traduzione {namespace}::{widget}.{type}.{field}.label
- placeholder() da traduzione {namespace}::{widget}.{type}.{field}.placeholder

### ECCEZIONI (NESSUNA)
NON CI SONO ECCEZIONI. MAI.

### CONTROLLO
Prima di scrivere codice, cerca:
grep -r "->label(" Modules/
grep -r "->placeholder(" Modules/

Se trovi chiamate, RIMUOVILE IMMEDIATAMENTE.
```

---

### 2. Script Pre-Commit

**File**: `bashscripts/check-auto-label-violations.sh`

```bash
#!/bin/bash
# Controlla violazioni regola auto-label

echo "🔍 Checking for ->label() and ->placeholder() violations..."

# Cerca in tutti i file Filament
VIOLATIONS=$(grep -r "->label(\|->placeholder(" \
    laravel/Modules/*/app/Filament/ \
    laravel/Modules/*/resources/views/filament/ \
    --include="*.php" \
    --include="*.blade.php" \
    2>/dev/null)

if [ -n "$VIOLATIONS" ]; then
    echo "❌ VIOLAZIONI AUTO-LABEL TROVATE:"
    echo "$VIOLATIONS"
    echo ""
    echo "📖 Leggi: laravel/Modules/Xot/docs/filament/widgets/no-label-placeholder-religion.md"
    exit 1
fi

echo "✅ Nessuna violazione auto-label"
exit 0
```

**Nel pre-commit hook**:
```bash
#!/bin/bash
# .git/hooks/pre-commit

bash bashscripts/check-auto-label-violations.sh
if [ $? -ne 0 ]; then
    echo "❌ Commit bloccato per violazioni auto-label"
    exit 1
fi
```

---

### 3. Documentation Index (Ricerca Rapida)

**Aggiornato in**: `laravel/Modules/Xot/docs/filament/widgets/index.md`

| Violazione | Documento | Quando Leggere |
|---|---|---|
| **->label()** | [no-label-placeholder-religion.md](./no-label-placeholder-religion.md) | PRIMA di scrivere qualsiasi componente |
| **->placeholder()** | [no-label-placeholder-religion.md](./no-label-placeholder-religion.md) | PRIMA di scrivere qualsiasi componente |

---

### 4. Anti-Pattern Catalog (Esempi SBAGLIATI/CORRETTI)

**NEL DOCUMENTO**: `no-label-placeholder-religion.md`

---

## I Comandamenti (Da Appendere al Muro)

### 1. NON userai ->label() MAI

```php
// ❌ SBAGLIATO
TextInput::make('address')
    ->label('Indirizzo')  // RIDONDANTE!

// ✅ CORRETTO
TextInput::make('address')
    ->required()  // LangServiceProvider applica label automaticamente!
```

---

### 2. NON userai ->placeholder() MAI

```php
// ❌ SBAGLIATO
TextInput::make('email')
    ->placeholder('Inserisci la tua email')  // RIDONDANTE!

// ✅ CORRETTO
TextInput::make('email')
    ->email()  // LangServiceProvider applica placeholder automaticamente!
```

---

### 3. NON userai ->helpText() MAI

```php
// ❌ SBAGLIATO
TextInput::make('fiscalCode')
    ->helpText('Codice fiscale di 16 caratteri')  // RIDONDANTE!

// ✅ CORRETTO
TextInput::make('fiscalCode')
    ->maxLength(16)  // LangServiceProvider applica helpText automaticamente!
```

---

### 4. NON userai ->description() MAI

```php
// ❌ SBAGLIATO
Select::make('issueType')
    ->description('Seleziona il tipo di segnalazione')  // RIDONDANTE!

// ✅ CORRETTO
Select::make('issueType')
    ->options(TicketTypeEnum::class)  // LangServiceProvider applica description!
```

---

## La Filosofia (Perche Profondo)

### LangServiceProvider: La Magia

```php
// Come funziona AutoLabelAction:

// 1. Intercetta creazione componente Filament
TextInput::make('address')

// 2. Deriva chiave traduzione:
//    - Classe chiamante: CreateTicketWizardWidget
//    - Namespace: fixcity
//    - Widget name: create_ticket_wizard
//    - Component type: fields
//    - Field name: address
//    → fixcity::create_ticket_wizard.fields.address.label

// 3. Applica traduzione automaticamente:
//    $component->label(trans('fixcity::create_ticket_wizard.fields.address.label'))

// 4. Se traduzione non esiste, la crea:
//    SaveTransAction::save('fixcity::create_ticket_wizard.fields.address.label', 'Indirizzo')
```

**Risultato**:
- ✅ Label applicata automaticamente
- ✅ Placeholder applicato automaticamente
- ✅ HelpText applicato automaticamente
- ✅ Description applicata automaticamente
- ✅ Traduzione salvata se non esiste

**Tu NON devi fare NULLA**. Solo scrivere il componente.

---

### I Benefici (Perche e Meglio)

#### 1. Consistenza
```php
// ❌ PRIMA: ogni sviluppatore scrive label diverse
TextInput::make('address')->label('Indirizzo')
TextInput::make('address')->label('indirizzo')  // minuscolo!
TextInput::make('address')->label('Address')    // inglese!

// ✅ DOPO: tutti usano la stessa traduzione
TextInput::make('address')  // → LangServiceProvider applica 'Indirizzo'
```

---

#### 2. i18n By Default
```php
// ❌ PRIMA: traduzioni mancanti
// Sviluppatore dimentica di tradurre label
// → UI in italiano, ma traduzione non esiste

// ✅ DOPO: traduzioni automatiche
// LangServiceProvider crea traduzione se non esiste
// → UI sempre tradotta, sempre consistente
```

---

#### 3. Manutenibilità
```php
// ❌ PRIMA: cambio label → cambio 100 file
// Devo cercare tutti i ->label('Indirizzo') e cambiare

// ✅ DOPO: cambio label → cambio 1 file (lang)
// Cambio solo fixcity::create_ticket_wizard.fields.address.label
```

---

#### 4. Developer Experience
```php
// ❌ PRIMA: boilerplate
TextInput::make('address')
    ->label('Indirizzo')
    ->placeholder('Inserisci indirizzo')
    ->helpText('Indirizzo completo')
    ->description('Campo obbligatorio')

// ✅ DOPO: essenziale
TextInput::make('address')
    ->required()  // Tutto il resto e automatico!
```

---

## Come Ricordarlo (Sistema Completo)

### 1. AI Memory (System Prompt)

**File**: `.qwen/memories/auto-label-memory.md`

```markdown
# MEMORIA PERSISTENTE: AUTO-LABEL

## REGOLA CRITICA
NON usare MAI ->label() o ->placeholder() su componenti Filament.

## PERCHE
LangServiceProvider applica automaticamente.

## CONTROLLO
Prima di scrivere codice, cerca violazioni:
grep -r "->label(" Modules/
grep -r "->placeholder(" Modules/

## SE TROVI VIOLAZIONI
RIMUOVILE IMMEDIATAMENTE.

## DOCUMENTO
laravel/Modules/Xot/docs/filament/widgets/no-label-placeholder-religion.md
```

---

### 2. Pre-Commit Script

**File**: `bashscripts/check-auto-label-violations.sh`

Vedi sezione "Script Pre-Commit" sopra.

---

### 3. IDE/Editor Snippets

**VS Code Snippet** (`.vscode/filament-components.code-snippets`):

```json
{
    "Filament TextInput (CORRETTO)": {
        "prefix": "fti",
        "body": [
            "TextInput::make('${1:field_name}')",
            "    ->${2:required()}"
        ],
        "description": "Filament TextInput SENZA label/placeholder (auto-applicati)"
    }
}
```

---

### 4. Pull Request Template

**File**: `.github/PULL_REQUEST_TEMPLATE.md`

```markdown
## Checklist Auto-Label

- [ ] NON ho usato ->label() su componenti Filament
- [ ] NON ho usato ->placeholder() su componenti Filament
- [ ] Ho verificato con: `grep -r "->label(" Modules/`
- [ ] Ho verificato con: `grep -r "->placeholder(" Modules/`

## Se ho violazioni:
- [ ] Ho rimosso TUTTE le chiamate ->label()
- [ ] Ho rimosso TUTTE le chiamate ->placeholder()
- [ ] Ho letto: `laravel/Modules/Xot/docs/filament/widgets/no-label-placeholder-religion.md`
```

---

## Come Correggere (Guida Rapida)

### 1. Cerca Violazioni

```bash
# Cerca in tutti i moduli
grep -r "->label(" laravel/Modules/ --include="*.php"
grep -r "->placeholder(" laravel/Modules/ --include="*.php"

# Cerca solo in Fixcity
grep -r "->label(" laravel/Modules/Fixcity/ --include="*.php"
grep -r "->placeholder(" laravel/Modules/Fixcity/ --include="*.php"
```

---

### 2. Rimuovi Violazioni

```php
// ❌ PRIMA
TextInput::make('address')
    ->label('Indirizzo')
    ->placeholder('Inserisci indirizzo')
    ->required()

// ✅ DOPO
TextInput::make('address')
    ->required()  // Label e placeholder sono automatici!
```

---

### 3. Verifica Traduzioni

```bash
# Verifica che traduzioni esistano
cat laravel/Modules/Fixcity/resources/lang/it/create_ticket_wizard.php

# Se non esistono, LangServiceProvider le crea automaticamente
# al primo accesso della pagina
```

---

## La Preghiera dello Sviluppatore Zen

```
Concedimi la disciplina di NON usare label espliciti,
La saggezza di fidarmi di LangServiceProvider,
E la memoria di ricordare questa regola.

Amen.
```

---

## Riferimenti

- [LangServiceProvider Implementation](../../../Lang/app/Providers/LangServiceProvider.php)
- [AutoLabelAction](../../../Lang/app/Actions/Filament/AutoLabelAction.php)
- [Wizard Widget Rules](./wizard-widget-rules.md)
- [XotBaseWizardWidget Philosophy](./xot-base-wizard-widget-philosophy.md)

---

*Ultimo aggiornamento: 2026-04-14*

**DA LEGGERE PRIMA DI SCRIVERE QUALSIASI COMPONENTE FILAMENT**
