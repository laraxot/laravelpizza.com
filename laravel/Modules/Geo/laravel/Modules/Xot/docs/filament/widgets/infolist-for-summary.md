# Infolist per Summary e Author Sections

## Overview

Questa regola definisce quando usare **Filament Infolist Entries** invece di **Form Fields** nei wizard step.

---

## Filament v5: Sistema Schema Unificato

Filament v5 **unifica** Forms e Infolists sotto un singolo sistema **Schema**.

```
┌─────────────────────────────────────────────────────────────┐
│                    Schema (v5)                              │
│                                                             │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────────┐  │
│  │ Form Fields   │  │ Infolist     │  │ Layout + Prime   │  │
│  │ (input)       │  │ Entries      │  │ Components       │  │
│  │               │  │ (read-only)  │  │                  │  │
│  │ TextInput     │  │ TextEntry    │  │ Section, Grid    │  │
│  │ Select        │  │ ImageEntry   │  │ Wizard, Tabs     │  │
│  │ Textarea      │  │ IconEntry    │  │ Text, Icon       │  │
│  │ FileUpload    │  │ KeyValueEntry│  │ Actions          │  │
│  │ Placeholder   │  │              │  │                  │  │
│  └──────────────┘  └──────────────┘  └──────────────────┘  │
│                                                             │
│  TUTTI possono essere mixati nello stesso schema[]          │
└─────────────────────────────────────────────────────────────┘
```

**IMPORTANTE**: In Filament v5, **PUOI** usare `TextEntry` (Infolist) dentro un Form schema.
Non esiste più la separazione rigida di v3/v4.

---

## La Regola

| Tipo di dato | Componente da usare | Perché |
|--------------|---------------------|--------|
| **Input** (dati da raccogliere) | `Filament\Forms\Components` | L'utente interagisce, inserisce dati |
| **Display** (dati da mostrare) | `Filament\Infolists\Components` | L'utente legge, nessun input |
| **Testo statico** | `Filament\Schemas\Components\Text` | Label, descrizione, non è un dato |
| **Struttura** | `Filament\Schemas\Components` | Section, Grid, Wizard, Step |

---

## Casi d'uso nel progetto

### 1. Sezione Autore (Step 2)

L'autore della segnalazione è un **utente autenticato** con dati già esistenti:
- Nome, Codice Fiscale, Telefono → **read-only** → `TextEntry`
- Email → **editabile** → `TextInput`

```php
Section::make('autore')
    ->description('Informazione su di te')
    ->schema([
        // Dati read-only → Infolist Entries
        TextEntry::make('author_name')
            ->state(fn (): string => $this->getAuthUserName()),
        TextEntry::make('author_fiscal_code')
            ->state(fn (): string => $this->getAuthUserFiscalCode()),
        TextEntry::make('author_phone')
            ->state(fn (): string => $this->getAuthUserPhone()),
        
        // Dato editabile → Form Field
        TextInput::make('email')
            ->email()
            ->maxLength(255),
    ]),
```

### 2. Riepilogo (Step 3)

Il riepilogo mostra dati **già inseriti negli step precedenti**:
- Tutti i campi → **read-only** → `TextEntry` con `fn(Get $get)`

```php
Section::make('review')
    ->schema([
        TextEntry::make('review_name')
            ->state(fn (Get $get): string => (string) ($get('name') ?? '')),
        TextEntry::make('review_type')
            ->state(function (Get $get): string {
                $type = TicketTypeEnum::tryFrom((string) ($get('type') ?? ''));
                return $type?->getLabel() ?? '';
            })
            ->badge(),
        TextEntry::make('review_address')
            ->state(fn (Get $get): string => (string) ($get('address') ?? ''))
            ->columnSpanFull(),
    ]),
```

---

## Zen — "Non mentire sul tipo di componente"

### ❌ Sbagliato: Placeholder (Form Field disabilitato)

```php
Placeholder::make('author_name')
    ->content(fn (): string => $this->getAuthUserName()),
```

**Perché è sbagliato**:
- `Placeholder` è un **Form Field** (namespace `Filament\Forms\Components`)
- Dichiara "sono un campo di input" ma si comporta da visualizzatore
- Partecipa al ciclo di validazione (anche se passivamente)
- È una **bugia semantica**: il tipo dice "raccogli", l'intenzione dice "mostra"

### ✅ Corretto: TextEntry (Infolist Entry)

```php
TextEntry::make('author_name')
    ->state(fn (): string => $this->getAuthUserName()),
```

**Perché è corretto**:
- `TextEntry` è un **Infolist Entry** (namespace `Filament\Infolists\Components`)
- Dichiara esplicitamente "sono un display read-only"
- Non partecipa alla validazione (non è un Field)
- È **semanticamente onesto**: il tipo dice "mostra", l'intenzione dice "mostra"

---

## Religione — "Ogni tipo di dato ha il suo componente"

```
┌─────────────────────────────────────────────────────────┐
│                 DATI DA COLLABORAZIONE                  │
│       (l'utente inserisce, modifica, sceglie)           │
│  → Form Fields: TextInput, Select, Textarea, Checkbox   │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                  DATI DA MOSTRAZIONE                     │
│       (profilo utente, riepilogo, dati DB)               │
│  → Infolist Entries: TextEntry, ImageEntry, IconEntry   │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   STRUTTURA VISIVA                       │
│         (layout, griglie, sezioni, wizard)               │
│  → Layout: Section, Grid, Wizard, Step                  │
└─────────────────────────────────────────────────────────┘
```

---

## Come leggere lo stato form: `Get $get`

Nei wizard step, i dati sono flat (non annidati). Per leggere il valore di un altro componente:

```php
// ✅ Corretto: usa Get $get
TextEntry::make('review_name')
    ->state(fn (Get $get): string => (string) ($get('name') ?? '')),

// ❌ Sbagliato: usa $this->data
TextEntry::make('review_name')
    ->state(fn (): string => (string) ($this->data['name'] ?? '')),
```

**Perché `Get $get` è meglio**:
- È il meccanismo ufficiale Filament v5
- Funziona in qualsiasi contesto Schema (non solo widget Livewire)
- È testabile in isolamento
- Non crea accoppiamento con la property `$data` del widget

---

## ImageEntry vs TextEntry per immagini pre-submit

### ❌ Sbagliato: ImageEntry nel summary pre-submit

```php
ImageEntry::make('images')  // ← richiede un Eloquent record salvato
```

**Perché è sbagliato**:
- `ImageEntry` si aspetta un record Eloquent con path definitivi
- Nel summary pre-submit, le immagini sono **path temporanei** o **ID Livewire**
- Il record non esiste ancora nel database

### ✅ Corretto: TextEntry per conteggio immagini

```php
TextEntry::make('review_images_count')
    ->state(function (Get $get): string {
        $images = $get('images');
        $count = is_array($images) ? count($images) : 0;
        return trans_choice('fixcity::ticket.messages.images_uploaded.text', $count);
    }),
```

**Perché è corretto**:
- Mostra il conteggio (informazione utile all'utente)
- Usa `trans_choice` per pluralizzazione corretta
- Non richiede un record salvato

---

## Anti-pattern da evitare

| Anti-pattern | Perché evitarlo | Soluzione |
|--------------|-----------------|-----------|
| `TextInput::disabled()` nel riepilogo | È un Form Field travestito da display | `TextEntry::make()` |
| `Placeholder::make()` per dati read-only | Partecipa al form state, è un "finto campo" | `TextEntry::make()` |
| `$this->data['field']` nelle closure | Accoppiamento fragile a Livewire | `fn(Get $get)` |
| `ImageEntry` pre-submit | Richiede record Eloquent salvato | `TextEntry` per conteggio |
| `->label()` hardcoded | Duplica il sistema i18n | LangServiceProvider auto-applica |
| `SchemaView` per il riepilogo | Logica display nel layer Blade | Infolist Entries PHP |

---

## Nota su Filament v3/v4 vs v5

**v3/v4**: Forms e Infolists erano sistemi separati. NON potevi mixarli.

**v5**: Schema è il sistema unificato. **PUOI** e **DOVRESTI** usare TextEntry dentro Form schemas per dati read-only.

Se vedi documentazione o tutorial che dicono "non puoi mixare Forms e Infolists" — è obsoleta (v3/v4).

---

## Riferimenti

| Documento | URL |
|-----------|-----|
| Filament Infolists overview | https://filamentphp.com/docs/5.x/infolists/overview |
| Filament TextEntry | https://filamentphp.com/docs/5.x/infolists/entries/text |
| Filament Schema overview | https://filamentphp.com/docs/5.x/schemas/overview |
| Story 7-42 | `_bmad-output/implementation-artifacts/7-42-segnalazione-crea-step2-html-parity-infolist-author.md` |

---

## Vedi anche

- [Location Spinner UX](../../../Geo/docs/location-spinner-ux.md) — GPS button con spinner
- [Ticket Wizard Frontoffice](../../../Fixcity/docs/ticket-wizard-frontoffice.md) — Architettura wizard
- [Filament Wizard Rule](../../../Fixcity/docs/filament-wizard-rule.md) — NO Blade step management
