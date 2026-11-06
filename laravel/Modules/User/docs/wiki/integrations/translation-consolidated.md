---
title: "translation: Consolidated Documentation"
module: user
type: integration
tags: [integrations, modules, user]
created: 2026-08-24
updated: 2026-08-24
status: draft
qmd: "translation   consolidated documentation user"
---

# translation: Consolidated Documentation

Consolidated from **22** individual files.

## Table of Contents

- [---](#translation-best-practices)
- [---](#translation-city-field-refactor-.deprecated)
- [---](#translation-city-field-refactor-)
- [---](#translation-city-field-refactor-3)
- [---](#translation-city-field-refactor-conflict)
- [---](#translation-city-field-refactor.deprecated)
- [---](#translation-city-field-refactor)
- [---](#translation-conflict-resolution-prototype)
- [---](#translation-fields-key-importance)
- [---](#translation-fixes)
- [---](#translation-key-prototype)
- [---](#translation-keys-rules)
- [---](#translation-keys)
- [---](#translation-maintenance-log)
- [---](#translation-resolution-prototype)
- [---](#translation-syntax-fixes-)
- [---](#translation-syntax-fixes)
- [---](#translation-syntaxes)
- [Best Practices per le Traduzioni](#translation_best_practices)
- [Regole per le Chiavi di Traduzione](#translation_keys_rules)
- [---](#translationes)
- [---](#translations)

---

## translation-best-practices

*Consolidated from: `translation-best-practices.md`*

title: "Best Practices per le Traduzioni"
type: concept
tags: [translation, best, practices]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-best-practices best practices per le traduzioni"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Best Practices per le Traduzioni

## Principi Generali

1. **Coerenza**: Mantenere una nomenclatura coerente per le chiavi di traduzione
2. **Completezza**: Tradurre tutte le chiavi in tutte le lingue supportate
3. **Struttura**: Mantenere una struttura gerarchica chiara e logica
4. **Manutenibilità**: Organizzare le traduzioni in file separati per ogni contesto
5. **Riusabilità**: Evitare duplicazioni di chiavi e contenuti

## Struttura dei File

### Organizzazione

- `lang/{locale}/auth.php`: Autenticazione e autorizzazione
- `lang/{locale}/registration.php`: Registrazione utenti
- `lang/{locale}/change_password.php`: Gestione password
- `lang/{locale}/password.php`: Configurazione password
- `lang/{locale}/user.php`: Gestione utenti

### Formato delle Chiavi

```php
return [
    'context' => [
        'subcontext' => [
            'key' => 'value',
            'nested' => [
                'key' => 'value'
            ]
        ]
    ]
];
```

## Best Practices Specifiche

### 1. Nomenclatura delle Chiavi

- Utilizzare chiavi descrittive e significative
- Seguire una convenzione di denominazione coerente
- Evitare abbreviazioni non standard
- Utilizzare il formato snake_case per le chiavi

### 2. Struttura Gerarchica

- Organizzare le chiavi in modo logico e gerarchico
- Raggruppare le chiavi correlate
- Utilizzare sottosezioni per organizzare le traduzioni
- Mantenere una profondità massima di 3-4 livelli

### 3. Gestione delle Variabili

- Utilizzare il formato `:variable` per le variabili
- Documentare le variabili disponibili
- Fornire esempi di utilizzo
- Gestire correttamente il plurale/singolare

### 4. Manutenzione

- Verificare periodicamente la completezza delle traduzioni
- Rimuovere le chiavi non utilizzate
- Aggiornare le traduzioni quando si aggiungono nuove funzionalità
- Mantenere un registro delle modifiche

### 5. Qualità

- Verificare la correttezza grammaticale
- Mantenere uno stile coerente
- Evitare traduzioni letterali
- Considerare il contesto culturale

## Strumenti e Risorse

### Strumenti Consigliati

1. Editor di testo con supporto per PHP
2. Strumenti di validazione JSON
3. Strumenti di gestione delle traduzioni
4. Linter per PHP

### Risorse Utili

1. Documentazione Laravel sulle traduzioni
2. Guide di stile per le traduzioni
3. Glossario dei termini tecnici
4. Template per nuove traduzioni

## Processo di Revisione

1. Verifica della completezza
2. Controllo della coerenza
3. Validazione della struttura
4. Test delle traduzioni
5. Approvazione finale

## Note Tecniche

- Utilizzare `trans()` per le traduzioni semplici
- Utilizzare `trans_choice()` per le traduzioni con plurali
- Gestire correttamente le variabili nelle traduzioni
- Considerare l'ordine delle parole nelle diverse lingue

## Esempi

### Traduzione Semplice

```php
'welcome' => 'Benvenuto',
'goodbye' => 'Arrivederci'
```

### Traduzione con Variabili

```php
'hello_name' => 'Ciao :name',
'items_count' => ':count elementi'
```

### Traduzione con Plurali

```php
'items' => '{0} Nessun elemento|{1} Un elemento|[2,*] :count elementi'
```

### Traduzione Gerarchica

```php
'auth' => [
    'login' => [
        'title' => 'Accedi',
        'button' => 'Accedi',
        'error' => 'Credenziali non valide'
    ]
]
```

## Conclusione

Seguire queste best practices aiuta a mantenere un sistema di traduzioni efficiente, manutenibile e di alta qualità. È importante aggiornare regolarmente le traduzioni e mantenere la documentazione aggiornata.

## Collegamenti Correlati
- [Documentazione Laravel Localization](https://laravel.com/docs/localization)
- [Best Practices di Codice](./CODE_BEST_PRACTICES.md)
- [Struttura Moduli](./module-structure.md) 
- [Best Practices di Codice](./code_best_practices.md)
- [Struttura Moduli](./module-structure.md) 
- [Struttura Moduli](../../module-structure-user.md) 
---

## translation-city-field-refactor-.deprecated

*Consolidated from: `translation-city-field-refactor-.deprecated.md`*

title: "Refactor Completo Campi "Città" - Modulo User"
type: concept
tags: [translation, city, field, refactor]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-city-field-refactor-2025-08-08.deprecated refactor completo campi "città" - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Refactor Completo Campi "Città" - Modulo User

## Riepilogo Intervento

Sono stati identificati e corretti tutti i file di traduzione non italiani contenenti "Città" nel modulo User, applicando la struttura completa a 7 elementi secondo gli standard Laraxot SaluteOra.

## File Corretti

### 1. `/lang/de/registration.php`
**Problema**: Campo 'city' conteneva testo in italiano invece di tedesco
**Soluzione**: Applicata struttura completa con traduzione tedesca corretta

```php
// Prima (❌ ERRATO)
'city' => [
    'label' => 'Città',
    'placeholder' => 'Inserisci la città',
    'help' => 'Città di residenza o domicilio',
],

// Dopo (✅ CORRETTO)
'city' => [
    'label' => 'Stadt',
    'placeholder' => 'Stadt eingeben',
    'tooltip' => 'Stadt des Wohnsitzes oder Standorts',
    'helper_text' => 'Geben Sie den Namen der Stadt ein, in der Sie wohnen oder sich aufhalten',
    'description' => 'Feld zur Angabe der Wohnsitzstadt des Benutzers für die Registrierung',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### 2. `/lang/de/register_tenant.php`
**Problema**: Campo 'address' conteneva testo in italiano con riferimento a "Città"
**Soluzione**: Traduzione completa in tedesco con struttura a 7 elementi

```php
// Prima (❌ ERRATO)
'address' => [
    'label' => 'Indirizzo Completo Studio',
    'placeholder' => 'Via/Piazza Nome Strada, Numero Civico, CAP Città (Provincia)',
    'help' => 'Indirizzo fisico completo dello studio medico comprensivo di CAP e provincia',
],

// Dopo (✅ CORRETTO)
'address' => [
    'label' => 'Vollständige Praxisadresse',
    'placeholder' => 'Straße/Platz Straßenname, Hausnummer, PLZ Stadt (Provinz)',
    'tooltip' => 'Vollständige Adresse der medizinischen Praxis',
    'helper_text' => 'Geben Sie die vollständige physische Adresse der medizinischen Praxis einschließlich Postleitzahl und Provinz ein',
    'description' => 'Vollständige Adresse der medizinischen Praxis für die Registrierung des Mandanten',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### 3. `/lang/en/registration.php`
**Problema**: Campo 'city' conteneva testo italiano misto ("Città di residenza o domicilio")
**Soluzione**: Rimozione testo italiano e applicazione struttura completa inglese

```php
// Prima (❌ ERRATO)
'city' => [
    'label' => 'City',
    'placeholder' => 'Enter your city',
    'tooltip' => 'Enter your city of residence',
    'help' => 'Città di residenza o domicilio', // ❌ Italiano!
],

// Dopo (✅ CORRETTO)
'city' => [
    'label' => 'City',
    'placeholder' => 'Enter your city',
    'tooltip' => 'City of residence or location',
    'helper_text' => 'Enter the name of the city where you reside or are located',
    'description' => 'Field to specify the user\'s city of residence for registration',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

## Struttura Standard Applicata

Ogni campo ora include tutti i 7 elementi obbligatori:

1. **`label`** - Etichetta del campo tradotta correttamente
2. **`placeholder`** - Testo di esempio nella lingua appropriata
3. **`tooltip`** - Suggerimento breve al passaggio del mouse
4. **`helper_text`** - Testo di aiuto dettagliato sotto il campo
5. **`description`** - Descrizione completa del campo e del suo scopo
6. **`icon`** - Icona Heroicons appropriata (`heroicon-o-map-pin` per campi geografici)
7. **`color`** - Colore del contesto (`primary` per campi principali)

## Terminologia Medica Standardizzata

### Tedesco
- **Stadt**: Città
- **Praxis**: Studio medico/odontoiatrico
- **Wohnsitz**: Residenza
- **Standort**: Ubicazione
- **eingeben**: inserire
- **Registrierung**: Registrazione
- **Mandant**: Tenant/Inquilino

### Inglese
- **City**: Città
- **Practice**: Studio medico/odontoiatrico
- **Residence**: Residenza
- **Location**: Ubicazione
- **Enter**: inserire
- **Registration**: Registrazione
- **Tenant**: Tenant/Inquilino

## Principi DRY + KISS Applicati

1. **Struttura Unificata**: Tutti i campi seguono la stessa struttura a 7 elementi
2. **Terminologia Coerente**: Uso consistente della terminologia medica per lingua
3. **Icone Standardizzate**: `heroicon-o-map-pin` per tutti i campi geografici
4. **Colori Coerenti**: `primary` per campi principali come città/indirizzo

## Validazione PHPStan

Tutti i file corretti mantengono:
- `declare(strict_types=1);` all'inizio
- Sintassi breve `[]` per gli array
- Struttura PHP valida e bilanciata

## Impatto e Benefici

### Coerenza Linguistica
- ✅ Eliminato tutto il testo italiano dai file tedeschi e inglesi
- ✅ Applicata terminologia medica appropriata per ogni lingua
- ✅ Struttura uniforme tra tutti i file di traduzione

### Esperienza Utente
- ✅ Tooltip informativi per ogni campo
- ✅ Helper text dettagliati per guidare l'utente
- ✅ Icone visive per identificazione rapida
- ✅ Colori coerenti per categorizzazione

### Manutenibilità
- ✅ Struttura standardizzata facilita future modifiche
- ✅ Terminologia coerente riduce confusione
- ✅ Documentazione completa per ogni modifica

## Checklist di Verifica Completata

- [x] Tutti i campi hanno struttura completa (7 elementi)
- [x] Nessun testo in italiano nei file tedeschi
- [x] Nessun testo in italiano nei file inglesi
- [x] Tutti i file includono `declare(strict_types=1);`
- [x] Tutti i file utilizzano sintassi moderna `[]`
- [x] Terminologia medica coerente in ogni lingua
- [x] Icone Heroicons valide e appropriate
- [x] Colori appropriati per il contesto
- [x] Validazione PHPStan superata

## Collegamenti Bidirezionali

- [Struttura Completa Campi Traduzione](../../../docs/translation-field-structure-complete.md)
- [SaluteOra Translation Audit](../../SaluteOra/docs/translation_audit_city_fields.md)
- [Translation Syntax Fixes](../../../docs/translation_syntax_fixes.md)
- [User Module Widget Translation Rules](widget-translation-rules.md)

## Prevenzione Futura

### Controlli Automatici
```bash
# Verifica presenza testo italiano in file non italiani
grep -r "Città\|città" laravel/Modules/*/lang/de/ laravel/Modules/*/lang/en/

# Verifica struttura completa campi
grep -A 10 -B 2 "label.*City\|label.*Stadt" laravel/Modules/*/lang/
```

### Template di Riferimento
Utilizzare la documentazione centrale [`translation-field-structure-complete.md`](../../../docs/translation-field-structure-complete.md) come template per tutti i nuovi campi di traduzione.

## Ultimo Aggiornamento
2025-08-08 - Refactor completo campi "Città" modulo User ✅ COMPLETATO

*Intervento eseguito seguendo rigorosamente i principi DRY + KISS e gli standard Laraxot SaluteOra*

---

## translation-city-field-refactor-

*Consolidated from: `translation-city-field-refactor-.md`*

title: "Refactor Completo Campi "Città" - Modulo User"
type: concept
tags: [translation, city, field, refactor]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-city-field-refactor- refactor completo campi "città" - modulo user"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Refactor Completo Campi "Città" - Modulo User

## Riepilogo Intervento

Sono stati identificati e corretti tutti i file di traduzione non italiani contenenti "Città" nel modulo User, applicando la struttura completa a 7 elementi secondo gli standard Laraxot <nome progetto>.

## File Corretti

### 1. `/lang/de/registration.php`
**Problema**: Campo 'city' conteneva testo in italiano invece di tedesco
**Soluzione**: Applicata struttura completa con traduzione tedesca corretta

```php
// Prima (❌ ERRATO)
'city' => [
    'label' => 'Città',
    'placeholder' => 'Inserisci la città',
    'help' => 'Città di residenza o domicilio',
],

// Dopo (✅ CORRETTO)
'city' => [
    'label' => 'Stadt',
    'placeholder' => 'Stadt eingeben',
    'tooltip' => 'Stadt des Wohnsitzes oder Standorts',
    'helper_text' => 'Geben Sie den Namen der Stadt ein, in der Sie wohnen oder sich aufhalten',
    'description' => 'Feld zur Angabe der Wohnsitzstadt des Benutzers für die Registrierung',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### 2. `/lang/de/register_tenant.php`
**Problema**: Campo 'address' conteneva testo in italiano con riferimento a "Città"
**Soluzione**: Traduzione completa in tedesco con struttura a 7 elementi

```php
// Prima (❌ ERRATO)
'address' => [
    'label' => 'Indirizzo Completo Studio',
    'placeholder' => 'Via/Piazza Nome Strada, Numero Civico, CAP Città (Provincia)',
    'help' => 'Indirizzo fisico completo dello studio medico comprensivo di CAP e provincia',
],

// Dopo (✅ CORRETTO)
'address' => [
    'label' => 'Vollständige Praxisadresse',
    'placeholder' => 'Straße/Platz Straßenname, Hausnummer, PLZ Stadt (Provinz)',
    'tooltip' => 'Vollständige Adresse der medizinischen Praxis',
    'helper_text' => 'Geben Sie die vollständige physische Adresse der medizinischen Praxis einschließlich Postleitzahl und Provinz ein',
    'description' => 'Vollständige Adresse der medizinischen Praxis für die Registrierung des Mandanten',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

### 3. `/lang/en/registration.php`
**Problema**: Campo 'city' conteneva testo italiano misto ("Città di residenza o domicilio")
**Soluzione**: Rimozione testo italiano e applicazione struttura completa inglese

```php
// Prima (❌ ERRATO)
'city' => [
    'label' => 'City',
    'placeholder' => 'Enter your city',
    'tooltip' => 'Enter your city of residence',
    'help' => 'Città di residenza o domicilio', // ❌ Italiano!
],

// Dopo (✅ CORRETTO)
'city' => [
    'label' => 'City',
    'placeholder' => 'Enter your city',
    'tooltip' => 'City of residence or location',
    'helper_text' => 'Enter the name of the city where you reside or are located',
    'description' => 'Field to specify the user\'s city of residence for registration',
    'icon' => 'heroicon-o-map-pin',
    'color' => 'primary',
],
```

## Struttura Standard Applicata

Ogni campo ora include tutti i 7 elementi obbligatori:

1. **`label`** - Etichetta del campo tradotta correttamente
2. **`placeholder`** - Testo di esempio nella lingua appropriata
3. **`tooltip`** - Suggerimento breve al passaggio del mouse
4. **`helper_text`** - Testo di aiuto dettagliato sotto il campo
5. **`description`** - Descrizione completa del campo e del suo scopo
6. **`icon`** - Icona Heroicons appropriata (`heroicon-o-map-pin` per campi geografici)
7. **`color`** - Colore del contesto (`primary` per campi principali)

## Terminologia Medica Standardizzata

### Tedesco
- **Stadt**: Città
- **Praxis**: Studio medico/odontoiatrico
- **Wohnsitz**: Residenza
- **Standort**: Ubicazione
- **eingeben**: inserire
- **Registrierung**: Registrazione
- **Mandant**: Tenant/Inquilino

### Inglese
- **City**: Città
- **Practice**: Studio medico/odontoiatrico
- **Residence**: Residenza
- **Location**: Ubicazione
- **Enter**: inserire
- **Registration**: Registrazione
- **Tenant**: Tenant/Inquilino

## Principi DRY + KISS Applicati

1. **Struttura Unificata**: Tutti i campi seguono la stessa struttura a 7 elementi
2. **Terminologia Coerente**: Uso consistente della terminologia medica per lingua
3. **Icone Standardizzate**: `heroicon-o-map-pin` per tutti i campi geografici
4. **Colori Coerenti**: `primary` per campi principali come città/indirizzo

## Validazione PHPStan

Tutti i file corretti mantengono:
- `declare(strict_types=1);` all'inizio
- Sintassi breve `[]` per gli array
- Struttura PHP valida e bilanciata

## Impatto e Benefici

### Coerenza Linguistica
- ✅ Eliminato tutto il testo italiano dai file tedeschi e inglesi
- ✅ Applicata terminologia medica appropriata per ogni lingua
- ✅ Struttura uniforme tra tutti i file di traduzione

### Esperienza Utente
- ✅ Tooltip informativi per ogni campo
- ✅ Helper text dettagliati per guidare l'utente
- ✅ Icone visive per identificazione rapida
- ✅ Colori coerenti per categorizzazione

### Manutenibilità
- ✅ Struttura standardizzata facilita future modifiche
- ✅ Terminologia coerente riduce confusione
- ✅ Documentazione completa per ogni modifica

## Checklist di Verifica Completata

- [x] Tutti i campi hanno struttura completa (7 elementi)
- [x] Nessun testo in italiano nei file tedeschi
- [x] Nessun testo in italiano nei file inglesi
- [x] Tutti i file includono `declare(strict_types=1);`
- [x] Tutti i file utilizzano sintassi moderna `[]`
- [x] Terminologia medica coerente in ogni lingua
- [x] Icone Heroicons valide e appropriate
- [x] Colori appropriati per il contesto
- [x] Validazione PHPStan superata

## Collegamenti Bidirezionali

- [Struttura Completa Campi Traduzione](../../../../docs/translation-field-structure-complete.md)
- [<nome progetto> Translation Audit](../../<nome progetto>/docs/translation_audit_city_fields.md)
- [Translation Syntax Fixes](../../../../docs/translation_syntax_fixes.md)
- [User Module Widget Translation Rules](widget-translation-rules.md)

## Prevenzione Futura

### Controlli Automatici
```bash
# Verifica presenza testo italiano in file non italiani
grep -r "Città\|città" laravel/Modules/*/lang/de/ laravel/Modules/*/lang/en/

# Verifica struttura completa campi
grep -A 10 -B 2 "label.*City\|label.*Stadt" laravel/Modules/*/lang/
```

### Template di Riferimento
Utilizzare la documentazione centrale [`translation-field-structure-complete.md`](../../../../docs/translation-field-structure-complete.md) come template per tutti i nuovi campi di traduzione.

## Ultimo Aggiornamento
2025-08-08 - Refactor completo campi "Città" modulo User ✅ COMPLETATO

*Intervento eseguito seguendo rigorosamente i principi DRY + KISS e gli standard Laraxot <nome progetto>*

---

## translation-city-field-refactor-3

*Consolidated from: `translation-city-field-refactor.md`*
*Consolidated from: `translation-city-field-refactor-stato-rinominato.md`*

title: "translation-city-field-refactor-2025-08-08"
type: concept
tags: [deprecated]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-city-field-refactor-2025-08-08 deprecated"
status: deprecated
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
---

> Questo file è stato rinominato in [translation-city-field-refactor-3.md](../../translation-city-field-refactor.md). Non aggiungere date nel filename; usare `created/updated` nel front matter.
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

> Questo file è stato rinominato in [translation-city-field-refactor-3.md](../../translation-city-field-refactor-stato-rinominato.md). Non aggiungere date nel filename; usare `created/updated` nel front matter.

---

## translation-city-field-refactor-conflict

*Consolidated from: `translation-city-field-refactor-conflict.md`*

module: theme
topic: translation-city-field-refactor-conflict
canonical: ../../../Themes/docs/shared-components/translation-city-field-refactor-conflict.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/translation-city-field-refactor-conflict.md

---

## translation-city-field-refactor.deprecated

*Consolidated from: `translation-city-field-refactor.deprecated.md`*

title: "translation-city-field-refactor-2025-08-08.deprecated"
type: concept
tags: [deprecated]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-city-field-refactor-2025-08-08.deprecated deprecated"
status: deprecated
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
---

> Questo file è stato rinominato in [translation-city-field-refactor-.deprecated.md](../../translation-city-field-refactor-.deprecated.md). Non aggiungere date nel filename; usare `created/updated` nel front matter.
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

> Questo file è stato rinominato in [translation-city-field-refactor-.deprecated.md](../../translation-city-field-refactor-.deprecated.md). Non aggiungere date nel filename; usare `created/updated` nel front matter.

---

## translation-city-field-refactor

*Consolidated from: `translation-city-field-refactor.md`*

module: theme
topic: translation-city-field-refactor
canonical: ../../../Themes/docs/shared-components/translation-city-field-refactor.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/translation-city-field-refactor.md

---

## translation-conflict-resolution-prototype

*Consolidated from: `translation-conflict-resolution-prototype.md`*

title: "Translation Conflict Resolution Prototype"
type: concept
tags: [translation, conflict, resolution, prototype]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-conflict-resolution-prototype translation conflict resolution prototype"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Translation Conflict Resolution Prototype

## Overview
This document describes the prototype for resolving Git conflicts in Laravel translation files while preserving all translation content.

## Conflict Types Identified

### Type 1: Complete Structure Conflicts
**Example**: `Modules/User/lang/it/device.php`
- One version has rich structure with `tooltip`, `helper_text`, `actions`, `navigation`, etc.
- Other version has minimal structure with basic `label`, `placeholder`, `help` fields
- **Resolution Strategy**: Merge both structures, prioritizing the richer version while preserving unique content from minimal version

### Type 2: Partial Key Conflicts
**Example**: `Modules/User/lang/it/edit_role.php`, `permission.php`
- Some keys exist in one version but not in another
- **Resolution Strategy**: Add missing keys from both versions

### Type 3: Duplicate Sections
**Example**: `Modules/TechPlanner/lang/it/appointment.php`
- Same sections appear twice without conflict markers
- **Resolution Strategy**: Merge duplicate content, removing redundancy

## Resolution Algorithm

### Step 1: Parse Conflict Markers

---

## translation-fields-key-importance

*Consolidated from: `translation-fields-key-importance.md`*

title: "Understanding Translation Structure in Laraxot Framework"
type: concept
tags: [translation, fields, key, importance]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-fields-key-importance understanding translation structure in laraxot framework"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Understanding Translation Structure in Laraxot Framework

## 2026-01-09 - Translation Key Analysis

### Context
During analysis of translation files in the User module, specifically `/laravel/Modules/User/lang/fr/authentication_log.php`, it was observed that the 'fields' key is present and functioning correctly.

### Philosophy and Logic
The 'fields' key in translation files is essential for the Filament translation system. It follows the pattern `modulo::risorsa.fields.campo.label` as documented in the Laraxot architecture. This structure allows automatic translation of form fields, table columns, and other UI elements without requiring explicit `->label()` calls in the component definitions.

### Business Logic
- The 'fields' key contains translations for all model fields
- Each field has sub-keys like 'label', 'placeholder', 'helper_text'
- This enables centralized translation management
- Follows DRY principle by avoiding duplication of field labels in code

### Conclusion
The 'fields' key is not only important but essential for the proper functioning of the translation and UI system in Laraxot. It must be preserved and maintained in all translation files.

### Rule
NEVER remove the 'fields' key from translation files as it is critical for the Filament translation system.
---

## translation-fixes

*Consolidated from: `translation-fixes.md`*

module: theme
topic: translation-fixes
canonical: ../../../Themes/docs/shared-components/translation-fixes.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/translation-fixes.md

---

## translation-key-prototype

*Consolidated from: `translation-key-prototype.md`*

title: "Translation Key Prototype"
type: concept
tags: [translation, key, prototype]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-key-prototype translation key prototype"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

Translation key prototype

Project convention: '<namespace>::<context>.<collection>.<item>.<type>'

Examples:
- user::auth.register.actions.submit.label -> label for the submit button in registration form
- user::auth.login.page.meta_title.label -> page meta title label for login

Why:
- Ensures predictable namespacing across modules and themes
- Easier to programmatically find translation entries
- Prevents collisions and improves maintainability

Action performed:
- Replaced occurrences of __('user::auth.register.submit') with __('user::auth.register.actions.submit.label') and added corresponding entry to Modules/User/lang/it/auth.php

Follow-ups:
- Run a repo-wide grep for occurrences of less-structured keys and standardize them.
- Add CI check to enforce prototype for new keys.
---

## translation-keys-rules

*Consolidated from: `translation-keys-rules.md`*

title: "Regole per le Chiavi di Traduzione"
type: rule
tags: [translation, keys, rules]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-keys-rules regole per le chiavi di traduzione"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Regole per le Chiavi di Traduzione

## Principi Fondamentali

1. **Chiavi in Inglese**
   - Le chiavi di traduzione DEVONO essere sempre in inglese
   - Esempio corretto: `__('login')` invece di `__('Accedi')`
   - Le traduzioni effettive vengono gestite nei file di lingua

2. **Struttura delle Chiavi**
   - Utilizzare il formato `namespace.key` per chiavi complesse
   - Esempio: `auth.login` per la pagina di login
   - Mantenere una gerarchia logica e coerente

3. **File di Traduzione**
   - Posizione: `lang/{locale}/`
   - Struttura nidificata per organizzare le traduzioni
   - Esempio:
     ```php
     // lang/it/auth.php
     return [
         'login' => 'Accedi',
         'register' => 'Registrati'
     ];
     ```

4. **Convenzioni di Naming**
   - Utilizzare nomi descrittivi ma concisi
   - Evitare spazi e caratteri speciali
   - Mantenere la coerenza tra i file di traduzione

5. **Gestione dei Namespace**
   - Raggruppare le traduzioni per modulo/funzionalità
   - Esempio:
     ```php
     // lang/it/user.php
     return [
         'profile' => [
             'title' => 'Profilo',
             'edit' => 'Modifica Profilo'
         ]
     ];
     ```

## Implementazione

### 1. Definizione delle Chiavi

```php
// Corretto
__('auth.login')
__('auth.register')
__('user.profile.title')

// Non Corretto
__('Accedi')
__('Registrati')
__('Profilo')
```

### 2. File di Traduzione

```php
// lang/it/auth.php
return [
    'login' => 'Accedi',
    'register' => 'Registrati',
    'logout' => 'Esci'
];

// lang/en/auth.php
return [
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout'
];
```

### 3. Utilizzo nei Componenti

```blade
{{-- Corretto --}}
<a href="{{ route('login') }}">{{ __('auth.login') }}</a>
<a href="{{ route('register') }}">{{ __('auth.register') }}</a>

{{-- Non Corretto --}}
<a href="{{ route('login') }}">{{ __('Accedi') }}</a>
<a href="{{ route('register') }}">{{ __('Registrati') }}</a>
```

## Best Practices Aggiuntive

1. **Validazione**
   - Verificare l'esistenza delle chiavi di traduzione
   - Utilizzare strumenti di validazione automatica
   - Mantenere una lista di tutte le chiavi utilizzate

2. **Manutenzione**
   - Aggiornare regolarmente i file di traduzione
   - Rimuovere le chiavi non utilizzate
   - Documentare le nuove chiavi aggiunte

3. **Performance**
   - Utilizzare il caching delle traduzioni
   - Minimizzare le chiamate di traduzione
   - Ottimizzare la struttura dei file

4. **Testing**
   - Verificare la presenza di tutte le traduzioni
   - Testare con diverse lingue
   - Validare la coerenza delle traduzioni

## Collegamenti Correlati

- [Best Practices per le Traduzioni](TRANSLATION_BEST_PRACTICES.md)
- [Struttura del Modulo](MODULE_STRUCTURE.md)
- [Convenzioni di Codice](CODE_CONVENTIONS.md)
- [Best Practices per le Traduzioni](translation-best-practices.md)
- [Struttura del Modulo](module-structure.md)
- [Convenzioni di Codice](code-conventions.md)
- [Convenzioni di Codice](../../code_conventions.md)
- [Best Practices per le Traduzioni](../../translation-best-practices-traduzioni.md)
- [Struttura del Modulo](../../module-structure-user.md)
- [Convenzioni di Codice](../../code-conventions.md)
---

## translation-keys

*Consolidated from: `translation-keys.md`*

module: theme
topic: translation-keys
canonical: ../../../Themes/docs/shared-components/translation-keys-rules.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/translation-keys-rules.md

---

## translation-maintenance-log

*Consolidated from: `translation-maintenance-log.md`*

title: "Translation Maintenance Log - User Module"
type: concept
tags: [translation, maintenance, log]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-maintenance-log translation maintenance log - user module"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Translation Maintenance Log - User Module

## Overview
Questo documento traccia tutti gli interventi di manutenzione e audit delle traduzioni nel modulo User, seguendo i principi di refactoring costante e studio della documentazione come memoria del sistema.

## 2025-01-25: LoginWidget Translation Audit

### Problema Identificato
Il `LoginWidget` utilizzava 4 chiavi di traduzione che non esistevano:
- `user::messages.credentials_incorrect`
- `user::messages.login_success` 
- `user::messages.validation_error`
- `user::messages.login_error`

### Soluzione Implementata
1. **Creazione file messages.php** per 3 lingue (IT, EN, DE)
2. **60+ chiavi di traduzione** per copertura completa
3. **Documentazione completa** dell'audit process

### Files Aggiunti
- `Modules/User/lang/it/messages.php` - 61 chiavi
- `Modules/User/lang/en/messages.php` - 61 chiavi  
- `Modules/User/lang/de/messages.php` - 61 chiavi
- `Modules/User/project_docs/login-widget-translation-audit-2025.md` - Documentazione

### Verifica Risultati
✅ **Tutte le traduzioni funzionanti** in 3 lingue
✅ **LoginWidget completamente localizzato**
✅ **Pattern replicabile** per altri widget

### Best Practices Applicate
- **DRY**: Centralizzazione traduzioni in messages.php
- **KISS**: Struttura semplice e chiara
- **SOLID**: Estensibilità per nuove lingue
- **Robustness**: Gestione errori user-friendly
- **Intelligence**: Messaggi contestuali

## Guidelines per Future Manutenzioni

### 1. Audit Process
1. Identificare widget/componenti con traduzioni mancanti
2. Analizzare chiavi utilizzate nel codice
3. Verificare esistenza nei file lang/
4. Creare traduzioni mancanti per tutte le lingue
5. Testare funzionamento in ogni lingua
6. Documentare processo e risultati

### 2. File Structure Standards
```
Modules/User/lang/
├── it/
│   ├── messages.php      (✅ NUOVO - Messaggi generali)
│   ├── auth.php          (✅ Esistente - Autenticazione dettagliata)
│   ├── login.php         (✅ Esistente - Login widget fields)
│   └── widgets.php       (✅ Esistente - Widget specifici)
├── en/
│   ├── messages.php      (✅ NUOVO - General messages)
│   └── ...
└── de/
    ├── messages.php      (✅ NUOVO - Allgemeine Nachrichten)
    └── ...
```

### 3. Quality Checklist
- [ ] Tutte le chiavi utilizzate nel codice esistono
- [ ] Traduzioni coerenti tra tutte le lingue supportate  
- [ ] Messaggi user-friendly e informativi
- [ ] `declare(strict_types=1)` in tutti i file PHP
- [ ] Commenti documentativi appropriati
- [ ] Test di funzionamento in ogni lingua

### 4. Documentation Requirements
- Documentare ogni audit con data e dettagli
- Mantenere questo log aggiornato
- Linkare alla documentazione specifica
- Esempi di best practices

## Translation File Categories

### messages.php - Messaggi Generali
Utilizzato per:
- Feedback utente (successo, errore, warning)
- Messaggi di sistema e sicurezza
- Validazione generale
- Operazioni CRUD

### auth.php - Autenticazione Dettagliata  
Utilizzato per:
- Login/logout complesso
- Registrazione utenti
- Reset password
- Verifica email

### widgets.php - Widget Specifici
Utilizzato per:
- Form schema automatico
- Labels, placeholders, help text
- Widget-specific actions

### login.php - Legacy Login Fields
Utilizzato per:
- Compatibilità backward
- Form fields semplici

## Lingue Supportate
- **Italiano (it)**: Lingua principale ✅
- **Inglese (en)**: Internazionalizzazione ✅
- **Tedesco (de)**: Supporto Europa centrale ✅
- **Altre**: Francese, Spagnolo, etc. (da aggiungere se necessario)

## Metriche e KPIs

### Translation Coverage
- **LoginWidget**: 100% ✅
- **Altri Widget**: Da auditare
- **Resources**: Da verificare
- **Actions**: Da controllare

### Lingue Coverage
- **Italiano**: 100% mantenuto
- **Inglese**: 100% implementato
- **Tedesco**: 100% implementato

## Prossimi Steps

### 1. Audit Sistematico (Q1 2025)
- [ ] RegistrationWidget translation audit
- [ ] PasswordResetWidget translation audit
- [ ] EditUserWidget translation audit
- [ ] User Resources translations

### 2. Automation (Q2 2025)  
- [ ] Script per rilevare chiavi translation mancanti
- [ ] Test automatici per translation resolution
- [ ] CI/CD integration per verifica traduzioni

### 3. Documentation Expansion
- [ ] Translation guidelines per sviluppatori
- [ ] Best practices esempi
- [ ] Migration guide per widget esistenti

## Learning e Memoria
Questo maintenance log serve come:
- **Traccia storica** di tutti gli interventi
- **Pattern documentation** per future manutenzioni  
- **Knowledge base** per il team
- **Quality assurance** reference

Ogni intervento deve essere documentato seguendo questo template per mantenere la memoria del sistema e facilitare future manutenzioni.

---
**Log iniziato**: 25 Gennaio 2025  
**Ultimo update**: 25 Gennaio 2025  
**Prossimo audit**: Da programmare Q1 2025

---

## translation-resolution-prototype

*Consolidated from: `translation-resolution-prototype.md`*

module: theme
topic: translation-resolution-prototype
canonical: ../../../Themes/docs/shared-components/translation-conflict-resolution-prototype.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/translation-conflict-resolution-prototype.md

---

## translation-syntax-fixes-

*Consolidated from: `translation-syntax-fixes-.md`*

module: theme
topic: translation-syntax-fixes-
canonical: ../../../Themes/docs/shared-components/translation-syntax-fixes.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/translation-syntax-fixes.md

---

## translation-syntax-fixes

*Consolidated from: `translation-syntax-fixes.md`*

title: "Correzioni Errori di Sintassi nei File di Traduzione - 2025"
type: concept
tags: [translation, syntax, fixes]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-syntax-fixes correzioni errori di sintassi nei file di traduzione - 2025"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Errori di Sintassi nei File di Traduzione - 2025

## Data
2025-01-15

## Problema Identificato
Errori di sintassi PHP nei file di traduzione del modulo User che impedivano il corretto funzionamento dell'applicazione.

## Errori Risolti

### 1. File `user-resource.php` (Italiano)
- **Errore**: Mancanza di parentesi di chiusura per l'array `permissions`
- **Riga**: 132
- **Causa**: Struttura di array annidati non chiusa correttamente
- **Soluzione**: Aggiunta parentesi di chiusura mancante per l'array `permissions`

### 2. File `registration.php` (Italiano e Inglese)
- **Errore**: Nessun errore di sintassi rilevato
- **Stato**: Verificato e confermato corretto

## Standard Laraxot Applicati

### 1. Posizionamento Corretto
- **Prima**: `Modules/User/resources/lang/`
- **Dopo**: `Modules/User/lang/`
- **Motivazione**: Conformità alle regole Laraxot per la struttura dei moduli

### 2. Dichiarazione Strict Types
- **Aggiunto**: `declare(strict_types=1);` in tutti i file di traduzione
- **Motivazione**: Conformità agli standard PHP moderni e Laraxot

### 3. Sintassi Array
- **Verificato**: Utilizzo della sintassi breve `[]` invece di `array()`
- **Stato**: Tutti i file già conformi

## File Corretti

### File Principali
- `Modules/User/lang/it/user-resource.php`
- `Modules/User/lang/it/registration.php`
- `Modules/User/lang/en/registration.php`

### Verifica Completa
- **Totale file verificati**: Tutti i file in `Modules/User/lang/`
- **Errori trovati**: 1 (user-resource.php)
- **Errori risolti**: 1
- **Stato finale**: Tutti i file sintatticamente corretti

## Test di Verifica

### Comando Utilizzato
```bash
find Modules/User/lang -name "*.php" -exec php -l {} \;
```

### Risultato
- ✅ Tutti i file passano la verifica di sintassi PHP
- ✅ Nessun errore di parsing rilevato
- ✅ Conformità agli standard Laraxot verificata

## Impatto

### Funzionalità Ripristinate
- Sistema di traduzioni del modulo User completamente funzionante
- Caricamento corretto delle traduzioni in italiano e inglese
- Interfaccia utente con testi localizzati correttamente

### Prevenzione Errori Futuri
- Standardizzazione della struttura dei file di traduzione
- Applicazione delle regole Laraxot per la manutenzione
- Verifica automatica della sintassi PHP

## Raccomandazioni

### 1. Manutenzione Regolare
- Eseguire verifiche di sintassi PHP sui file di traduzione
- Utilizzare `php -l` per validare i file prima del commit

### 2. Conformità Standard
- Seguire sempre le regole Laraxot per i file di traduzione
- Utilizzare `declare(strict_types=1);` in tutti i file PHP
- Posizionare i file in `Modules/{ModuleName}/lang/{locale}/`

### 3. Struttura File
- Utilizzare la sintassi breve degli array `[]`
- Organizzare le traduzioni in struttura gerarchica
- Includere sempre `label`, `placeholder` e `help` per i campi

## Collegamenti

- [Regole Traduzioni Laraxot](../../.cursor/rules/translation-files-rules.mdc)
- [Struttura Moduli](../../.cursor/rules/module-structure.mdc)
- [Standard PHP](../../.cursor/rules/php-standards.mdc)

## Note Tecniche

### Struttura Array Corretta
```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta',
            'placeholder' => 'Placeholder',
            'help' => 'Testo di aiuto',
        ],
    ],
];
```

### Verifica Sintassi
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file di traduzione
find Modules/User/lang -name "*.php" -exec php -l {} \;
```

---

**Autore**: Sistema di Risoluzione Automatica
**Data**: 2025-01-15
**Versione**: 1.0
**Stato**: Completato

---

## translation-syntaxes

*Consolidated from: `translation-syntaxes.md`*

title: "Correzioni Errori di Sintassi nei File di Traduzione - 2025"
type: concept
tags: [translation, syntaxes]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-syntaxes correzioni errori di sintassi nei file di traduzione - 2025"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni Errori di Sintassi nei File di Traduzione - 2025

## Data
[DATE]

## Problema Identificato
Errori di sintassi PHP nei file di traduzione del modulo User che impedivano il corretto funzionamento dell'applicazione.

## Errori Risolti

### 1. File `user-resource.php` (Italiano)
- **Errore**: Mancanza di parentesi di chiusura per l'array `permissions`
- **Riga**: 132
- **Causa**: Struttura di array annidati non chiusa correttamente
- **Soluzione**: Aggiunta parentesi di chiusura mancante per l'array `permissions`

### 2. File `registration.php` (Italiano e Inglese)
- **Errore**: Nessun errore di sintassi rilevato
- **Stato**: Verificato e confermato corretto

## Standard Laraxot Applicati

### 1. Posizionamento Corretto
- **Prima**: `Modules/User/resources/lang/`
- **Dopo**: `Modules/User/lang/`
- **Motivazione**: Conformità alle regole Laraxot per la struttura dei moduli

### 2. Dichiarazione Strict Types
- **Aggiunto**: `declare(strict_types=1);` in tutti i file di traduzione
- **Motivazione**: Conformità agli standard PHP moderni e Laraxot

### 3. Sintassi Array
- **Verificato**: Utilizzo della sintassi breve `[]` invece di `array()`
- **Stato**: Tutti i file già conformi

## File Corretti

### File Principali
- `Modules/User/lang/it/user-resource.php`
- `Modules/User/lang/it/registration.php`
- `Modules/User/lang/en/registration.php`

### Verifica Completa
- **Totale file verificati**: Tutti i file in `Modules/User/lang/`
- **Errori trovati**: 1 (user-resource.php)
- **Errori risolti**: 1
- **Stato finale**: Tutti i file sintatticamente corretti

## Test di Verifica

### Comando Utilizzato
```bash
find Modules/User/lang -name "*.php" -exec php -l {} \;
```

### Risultato
- ✅ Tutti i file passano la verifica di sintassi PHP
- ✅ Nessun errore di parsing rilevato
- ✅ Conformità agli standard Laraxot verificata

## Impatto

### Funzionalità Ripristinate
- Sistema di traduzioni del modulo User completamente funzionante
- Caricamento corretto delle traduzioni in italiano e inglese
- Interfaccia utente con testi localizzati correttamente

### Prevenzione Errori Futuri
- Standardizzazione della struttura dei file di traduzione
- Applicazione delle regole Laraxot per la manutenzione
- Verifica automatica della sintassi PHP

## Raccomandazioni

### 1. Manutenzione Regolare
- Eseguire verifiche di sintassi PHP sui file di traduzione
- Utilizzare `php -l` per validare i file prima del commit

### 2. Conformità Standard
- Seguire sempre le regole Laraxot per i file di traduzione
- Utilizzare `declare(strict_types=1);` in tutti i file PHP
- Posizionare i file in `Modules/{ModuleName}/lang/{locale}/`

### 3. Struttura File
- Utilizzare la sintassi breve degli array `[]`
- Organizzare le traduzioni in struttura gerarchica
- Includere sempre `label`, `placeholder` e `help` per i campi

## Collegamenti

- [Regole Traduzioni Laraxot](../../.cursor/rules/translation-files-rules.mdc)
- [Struttura Moduli](../../.cursor/rules/module-structure.mdc)
- [Standard PHP](../../.cursor/rules/php-standards.mdc)

## Note Tecniche

### Struttura Array Corretta
```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta',
            'placeholder' => 'Placeholder',
            'help' => 'Testo di aiuto',
        ],
    ],
];
```

### Verifica Sintassi
```bash
# Verifica singolo file
php -l path/to/file.php

# Verifica tutti i file di traduzione
find Modules/User/lang -name "*.php" -exec php -l {} \;
```

---

**Autore**: Sistema di Risoluzione Automatica
**Versione**: 1.0
**Stato**: Completato

---

## translation_best_practices

*Consolidated from: `translation_best_practices.md`*


## Principi Generali

1. **Coerenza**: Mantenere una nomenclatura coerente per le chiavi di traduzione
2. **Completezza**: Tradurre tutte le chiavi in tutte le lingue supportate
3. **Struttura**: Mantenere una struttura gerarchica chiara e logica
4. **Manutenibilità**: Organizzare le traduzioni in file separati per ogni contesto
5. **Riusabilità**: Evitare duplicazioni di chiavi e contenuti

## Struttura dei File

### Organizzazione

- `lang/{locale}/auth.php`: Autenticazione e autorizzazione
- `lang/{locale}/registration.php`: Registrazione utenti
- `lang/{locale}/change_password.php`: Gestione password
- `lang/{locale}/password.php`: Configurazione password
- `lang/{locale}/user.php`: Gestione utenti

### Formato delle Chiavi

```php
return [
    'context' => [
        'subcontext' => [
            'key' => 'value',
            'nested' => [
                'key' => 'value'
            ]
        ]
    ]
];
```

## Best Practices Specifiche

### 1. Nomenclatura delle Chiavi

- Utilizzare chiavi descrittive e significative
- Seguire una convenzione di denominazione coerente
- Evitare abbreviazioni non standard
- Utilizzare il formato snake_case per le chiavi

### 2. Struttura Gerarchica

- Organizzare le chiavi in modo logico e gerarchico
- Raggruppare le chiavi correlate
- Utilizzare sottosezioni per organizzare le traduzioni
- Mantenere una profondità massima di 3-4 livelli

### 3. Gestione delle Variabili

- Utilizzare il formato `:variable` per le variabili
- Documentare le variabili disponibili
- Fornire esempi di utilizzo
- Gestire correttamente il plurale/singolare

### 4. Manutenzione

- Verificare periodicamente la completezza delle traduzioni
- Rimuovere le chiavi non utilizzate
- Aggiornare le traduzioni quando si aggiungono nuove funzionalità
- Mantenere un registro delle modifiche

### 5. Qualità

- Verificare la correttezza grammaticale
- Mantenere uno stile coerente
- Evitare traduzioni letterali
- Considerare il contesto culturale

## Strumenti e Risorse

### Strumenti Consigliati

1. Editor di testo con supporto per PHP
2. Strumenti di validazione JSON
3. Strumenti di gestione delle traduzioni
4. Linter per PHP

### Risorse Utili

1. Documentazione Laravel sulle traduzioni
2. Guide di stile per le traduzioni
3. Glossario dei termini tecnici
4. Template per nuove traduzioni

## Processo di Revisione

1. Verifica della completezza
2. Controllo della coerenza
3. Validazione della struttura
4. Test delle traduzioni
5. Approvazione finale

## Note Tecniche

- Utilizzare `trans()` per le traduzioni semplici
- Utilizzare `trans_choice()` per le traduzioni con plurali
- Gestire correttamente le variabili nelle traduzioni
- Considerare l'ordine delle parole nelle diverse lingue

## Esempi

### Traduzione Semplice

```php
'welcome' => 'Benvenuto',
'goodbye' => 'Arrivederci'
```

### Traduzione con Variabili

```php
'hello_name' => 'Ciao :name',
'items_count' => ':count elementi'
```

### Traduzione con Plurali

```php
'items' => '{0} Nessun elemento|{1} Un elemento|[2,*] :count elementi'
```

### Traduzione Gerarchica

```php
'auth' => [
    'login' => [
        'title' => 'Accedi',
        'button' => 'Accedi',
        'error' => 'Credenziali non valide'
    ]
]
```

## Conclusione

Seguire queste best practices aiuta a mantenere un sistema di traduzioni efficiente, manutenibile e di alta qualità. È importante aggiornare regolarmente le traduzioni e mantenere la documentazione aggiornata.

## Collegamenti Correlati
- [Documentazione Laravel Localization](https://laravel.com/docs/localization)
- [Best Practices di Codice](./CODE_BEST_PRACTICES.md)
- [Struttura Moduli](./MODULE_STRUCTURE.md) 

---

## translation_keys_rules

*Consolidated from: `translation_keys_rules.md`*


## Principi Fondamentali

1. **Chiavi in Inglese**
   - Le chiavi di traduzione DEVONO essere sempre in inglese
   - Esempio corretto: `__('login')` invece di `__('Accedi')`
   - Le traduzioni effettive vengono gestite nei file di lingua

2. **Struttura delle Chiavi**
   - Utilizzare il formato `namespace.key` per chiavi complesse
   - Esempio: `auth.login` per la pagina di login
   - Mantenere una gerarchia logica e coerente

3. **File di Traduzione**
   - Posizione: `lang/{locale}/`
   - Struttura nidificata per organizzare le traduzioni
   - Esempio:
     ```php
     // lang/it/auth.php
     return [
         'login' => 'Accedi',
         'register' => 'Registrati'
     ];
     ```

4. **Convenzioni di Naming**
   - Utilizzare nomi descrittivi ma concisi
   - Evitare spazi e caratteri speciali
   - Mantenere la coerenza tra i file di traduzione

5. **Gestione dei Namespace**
   - Raggruppare le traduzioni per modulo/funzionalità
   - Esempio:
     ```php
     // lang/it/user.php
     return [
         'profile' => [
             'title' => 'Profilo',
             'edit' => 'Modifica Profilo'
         ]
     ];
     ```

## Implementazione

### 1. Definizione delle Chiavi

```php
// Corretto
__('auth.login')
__('auth.register')
__('user.profile.title')

// Non Corretto
__('Accedi')
__('Registrati')
__('Profilo')
```

### 2. File di Traduzione

```php
// lang/it/auth.php
return [
    'login' => 'Accedi',
    'register' => 'Registrati',
    'logout' => 'Esci'
];

// lang/en/auth.php
return [
    'login' => 'Login',
    'register' => 'Register',
    'logout' => 'Logout'
];
```

### 3. Utilizzo nei Componenti

```blade
{{-- Corretto --}}
<a href="{{ route('login') }}">{{ __('auth.login') }}</a>
<a href="{{ route('register') }}">{{ __('auth.register') }}</a>

{{-- Non Corretto --}}
<a href="{{ route('login') }}">{{ __('Accedi') }}</a>
<a href="{{ route('register') }}">{{ __('Registrati') }}</a>
```

## Best Practices Aggiuntive

1. **Validazione**
   - Verificare l'esistenza delle chiavi di traduzione
   - Utilizzare strumenti di validazione automatica
   - Mantenere una lista di tutte le chiavi utilizzate

2. **Manutenzione**
   - Aggiornare regolarmente i file di traduzione
   - Rimuovere le chiavi non utilizzate
   - Documentare le nuove chiavi aggiunte

3. **Performance**
   - Utilizzare il caching delle traduzioni
   - Minimizzare le chiamate di traduzione
   - Ottimizzare la struttura dei file

4. **Testing**
   - Verificare la presenza di tutte le traduzioni
   - Testare con diverse lingue
   - Validare la coerenza delle traduzioni

## Collegamenti Correlati

- [Best Practices per le Traduzioni](TRANSLATION_BEST_PRACTICES.md)
- [Struttura del Modulo](MODULE_STRUCTURE.md)
- [Convenzioni di Codice](CODE_CONVENTIONS.md)
- [Convenzioni di Codice](../../code_conventions.md)

---

## translationes

*Consolidated from: `translationes.md`*

title: "Correzioni File di Traduzione User Module"
type: concept
tags: [translationes]
created: 2026-07-14
updated: 2026-07-14
qmd: "translationes correzioni file di traduzione user module"
issues: ["https://github.com/provtv/<nome repository>/issues/124"]
discussions: ["https://github.com/provtv/<nome repository>/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

# Correzioni File di Traduzione User Module

## Problemi Identificati e Risolti

### 1. Conflitti di Merge Git
**Problema**: Il file `Modules/User/lang/it/user.php` conteneva marcatori di conflitto Git non risolti:
- `=======`
- `>>>>>>> 42fc572 (.)`
- `>>>>>>> 199538c (.)`

**Soluzione**: Rimossi tutti i marcatori di conflitto e mantenuto solo il contenuto corretto.

### 2. Sintassi Array Inconsistente
**Problema**: Il file utilizzava una sintassi mista:
- Sintassi breve `[]` (corretta)
- Sintassi lunga `array()` (deprecata)

**Soluzione**: Standardizzata tutta la sintassi utilizzando la sintassi breve `[]` conforme alle regole Laraxot.

### 3. Struttura Espansa Incompleta
**Problema**: Le azioni non seguivano la struttura espansa obbligatoria per le regole Laraxot.

**Soluzione**: Completata la struttura espansa per tutte le azioni includendo:
- `modal_heading`
- `modal_description`
- `success`
- `error`
- `confirmation` (dove appropriato)

### 4. Helper Text Mancanti
**Problema**: Molti campi non avevano la proprietà `helper_text` richiesta dalle regole Laraxot.

**Soluzione**: Aggiunta la proprietà `helper_text` con valore vuoto `''` per tutti i campi, seguendo la regola che se `helper_text` è uguale al placeholder, deve essere vuoto.

### 5. Duplicazione di Contenuti
**Problema**: Il file conteneva sezioni duplicate e contenuti ridondanti.

**Soluzione**: Rimossa la duplicazione mantenendo una struttura pulita e organizzata.

## Struttura Finale

Il file ora segue la struttura espansa obbligatoria per le regole Laraxot:

```php
'fields' => [
    'field_name' => [
        'label' => 'Etichetta Campo',
        'placeholder' => 'Placeholder diverso',
        'help' => 'Testo di aiuto specifico',
        'helper_text' => '', // Vuoto se diverso da placeholder
    ]
],

'actions' => [
    'action_name' => [
        'label' => 'Etichetta Azione',
        'icon' => 'heroicon-name',
        'tooltip' => 'Descrizione dell\'azione',
        'modal_heading' => 'Titolo Modal',
        'modal_description' => 'Descrizione dettagliata',
        'success' => 'Messaggio di successo',
        'error' => 'Messaggio di errore',
        'confirmation' => 'Messaggio di conferma (se necessario)',
    ]
]
```

## Conformità alle Regole Laraxot

✅ **Struttura Espansa**: Tutti i campi e le azioni seguono la struttura espansa obbligatoria
✅ **Sintassi Array**: Utilizzata esclusivamente la sintassi breve `[]`
✅ **Helper Text**: Tutti i campi hanno la proprietà `helper_text` (vuota se appropriato)
✅ **Strict Types**: Mantenuto `declare(strict_types=1);`
✅ **Naming Convention**: Tutte le chiavi in inglese, valori in italiano
✅ **No Hardcoded**: Nessuna stringa hardcoded, tutto tramite file di traduzione

## Benefici delle Correzioni

1. **Manutenibilità**: Codice pulito e ben strutturato
2. **Conformità**: Rispetto delle regole Laraxot per le traduzioni
3. **Consistenza**: Struttura uniforme in tutto il file
4. **Funzionalità**: Tutte le azioni hanno messaggi completi per UX
5. **Debugging**: Eliminati i conflitti Git che causavano errori

## File Correlati

- `Modules/User/lang/it/user.php` - File principale delle traduzioni
- `docs/translation-standards.md` - Standard globali di traduzione
- `docs/translation-fixes.md` - Questo documento

## Data Correzioni

**Autore**: AI Assistant
**Versione**: 1.0
**Status**: Completato

---


---

## translations

*Consolidated from: `translations.md`*

module: theme
topic: translations
canonical: ../../../Themes/docs/shared-components/translations.md
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
---

See canonical documentation: ../../../Themes/docs/shared-components/translations.md

---

**Consolidated by:** Phase 2f intelligent merging
**Date:** 2026-08-04