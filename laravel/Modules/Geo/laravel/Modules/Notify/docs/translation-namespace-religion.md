# Translation Namespace Philosophy — La Religione del Dominio

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Religion / i18n  
**Audience**: All developers + AI agents

---

## LA REGOLA AUREA

**Le traduzioni sono organizzate per DOMINIO, non per componente UI.**

**DOMINIO** = `ticket`, `user`, `order` (cosa fa il business)  
**NON COMPONENTE** = `create_ticket_wizard`, `edit_form`, `list_view` (come lo mostri)

---

## Perche (Filosofia Profonda)

### Il Problema: Namespace per Componente UI

```php
// ❌ SBAGLIATO: namespace basato su COMPONENTE UI
__('fixcity::create_ticket_wizard.summary.images.limit_message')
```

**Perche e sbagliato**:

1. **Duplicazione**: Se hai 3 widget che mostrano immagini, ognuno ha la SUA traduzione
   - `create_ticket_wizard.summary.images.limit_message`
   - `edit_ticket_wizard.summary.images.limit_message`
   - `view_ticket_wizard.summary.images.limit_message`
   - → 3 traduzioni per la STESSA cosa

2. **Incoerenza**: Ogni widget puo avere traduzione diversa
   - Widget 1: "E altre :count immagini"
   - Widget 2: "Altre :count immagini"
   - Widget 3: "+:count altre foto"
   - → Utente confuso

3. **Manutenzione**: Cambio la traduzione → devo aggiornare 3 file
   - Se dimentico uno → incoerenza UI

---

### La Soluzione: Namespace per Dominio

```php
// ✅ CORRETTO: namespace basato su DOMINIO BUSINESS
__('fixcity::ticket.rules.image.limit_message')
```

**Perche e meglio**:

1. **UNICA fonte di verita**: Tutte le UI usano la STESSA traduzione
   - `ticket.rules.image.limit_message` → usata da TUTTI i widget
   - → Consistenza garantita

2. **Dominio business**: "ticket" e il concetto, non il widget
   - Le immagini sono una REGOLA del ticket
   - Non del widget che le mostra

3. **Manutenzione**: Cambio 1 volta → tutti i widget aggiornano
   - DRY applicato alle traduzioni

---

## La Struttura Corretta

### ❌ SBAGLIATO: Organizzato per UI

```
lang/it/
├── create_ticket_wizard.php      ← Componente UI
│   └── summary.images.limit_message
├── edit_ticket_form.php          ← Componente UI
│   └── images.limit_message
└── view_ticket_page.php          ← Componente UI
    └── gallery.limit_message
```

**Problema**: 3 traduzioni per "E altre :count immagini"

---

### ✅ CORRETTO: Organizzato per Dominio

```
lang/it/
└── ticket.php                    ← Dominio business
    ├── fields.images.label
    ├── fields.images.placeholder
    ├── rules.image.limit_message  ← UNICA traduzione
    └── messages.created
```

**Vantaggio**: 1 traduzione, tutti i widget la usano

---

## I Comandamenti i18n

### 1. Userai il DOMINIO come namespace radice

```php
// ❌ SBAGLIATO: componente UI
__('fixcity::create_ticket_wizard.summary.label')

// ✅ CORRETTO: dominio business
__('fixcity::ticket.sections.summary.label')
```

---

### 2. NON creerai file di traduzione per ogni widget

```php
// ❌ SBAGLIATO
create_ticket_wizard.php  ← File per widget
edit_ticket_form.php      ← File per widget
view_ticket_page.php      ← File per widget

// ✅ CORRETTO
ticket.php                ← File per dominio
```

---

### 3. Userai categorie semantiche sotto il dominio

```php
// Struttura corretta sotto dominio:
ticket.php
├── fields.       ← Campi del form
├── actions.      ← Azioni (crea, modifica, elimina)
├── messages.     ← Messaggi (successo, errore)
├── rules.        ← Regole di validazione/UI
├── sections.     ← Sezioni UI
└── navigation.   ← Menu navigazione
```

---

### 4. Le regole UI vanno sotto `rules`, non sotto il widget

```php
// ❌ SBAGLIATO
__('fixcity::create_ticket_wizard.summary.images.limit_message')

// ✅ CORRETTO
__('fixcity::ticket.rules.image.limit_message')
```

**Perche**: La regola delle immagini e una proprieta del DOMINIO ticket, non del widget.

---

### 5. AGGIORNERAI il file dominio, non creerai nuovi file

```php
// ❌ SBAGLIATO: creo nuovo file per nuovo widget
new_ticket_wizard.php  ← File duplicato

// ✅ CORRETTO: aggiungo al file dominio esistente
ticket.php  ← Aggiungo nuove chiavi qui
```

---

## Come Correggere (Guida Rapida)

### 1. Trova il file dominio corretto

```bash
# Cerca file di traduzione esistenti
find Modules/Fixcity/lang/it -name "ticket*.php"
→ ticket.php  ← Questo e il file!
```

---

### 2. Verifica la chiave esiste

```bash
# Cerca nel file
grep "limit_message" Modules/Fixcity/lang/it/ticket.php
→ 'limit_message' => 'E altre :count immagini'
```

---

### 3. Usa la chiave corretta nel codice

```php
// ❌ SBAGLIATO
->limitMessage(__('fixcity::create_ticket_wizard.summary.images.limit_message'))

// ✅ CORRETTO
->limitMessage(__('fixcity::ticket.rules.image.limit_message'))
```

---

## Caso Studio: Ticket Wizard Images

### Prima (Sbagliato)

```php
Section::make(__('fixcity::create_ticket_wizard.summary.images.label'))
    ->limitMessage(__('fixcity::create_ticket_wizard.summary.images.limit_message'))
```

**Problemi**:
- Namespace basato su componente UI (`create_ticket_wizard`)
- Se altro widget usa immagini → deve duplicare traduzione
- Incoerenza potenziale

---

### Dopo (Corretto)

```php
Section::make(__('fixcity::ticket.sections.images.label'))
    ->limitMessage(__('fixcity::ticket.rules.image.limit_message'))
```

**Vantaggi**:
- Namespace basato su dominio (`ticket`)
- Tutti i widget condividono la traduzione
- Consistenza garantita

---

## La Filosofia Completa

### I 5 Pilastri del Namespace i18n

#### 1. Dominio, Non UI

**Dominio** = cosa fa il business (ticket, user, order)  
**UI** = come lo mostri (wizard, form, page)

**Regola**: Namespace segue dominio, NON UI.

---

#### 2. Unica Fonte di Verita

Ogni concetto ha UNA traduzione nel file dominio.  
Niente duplicati, niente incoerenze.

---

#### 3. Categorie Semantiche

Sotto il dominio, usa categorie che hanno senso:
- `fields` → campi del form
- `actions` → azioni CRUD
- `messages` → messaggi utente
- `rules` → regole validazione/UI
- `sections` → sezioni interfaccia
- `navigation` → menu/link

---

#### 4. Scalabilita

Aggiungere nuovo widget?  
→ Usa chiavi dominio esistenti, NON crearne di nuove.

---

#### 5. Manutenzione

Cambio traduzione?  
→ 1 file, 1 modifica, tutti i widget aggiornano.

---

## La Religione

### Il Credo

> "Dominio e il namespace, UI e solo il consumatore.  
> Una traduzione per concetto, mai duplicati.  
> Regole nel dominio, non nel widget."

### La Preghiera

```
Concedimi la saggezza di organizzare per dominio,
La disciplina di non duplicare traduzioni,
E il rispetto per ogni utente nella sua lingua.

Amen.
```

---

## Riferimenti

- [ticket.php (dominio corretto)](../../Modules/Fixcity/lang/it/ticket.php)
- [Laravel Localization](https://laravel.com/docs/localization)
- [No Hardcoded Language Religion](../../docs/no-hardcoded-language-religion.md)

---

*Ultimo aggiornamento: 2026-04-14*

**DA LEGGERE PRIMA DI CREARE QUALSIASI CHIAVE DI TRADUZIONE**
