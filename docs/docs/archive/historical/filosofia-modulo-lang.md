# Analisi Approfondita del Modulo Lang

> **Generato**: [DATE]
> **Scopo**: Documentare la filosofia, logica e architettura del modulo Lang

---

## ANALISI MODULO LANG: SISTEMA DI TRADUZIONI AUTOMATIZZATO

### 1. LOGICA CORE - Auto-Discovery Traduzioni

Il sistema Lang implementa un **auto-discovery bidirezionale** delle traduzioni:

**Pattern:** Quando un componente Filament (Form, Table, Action) è renderizzato, `AutoLabelAction` intercetta automaticamente:
- Estrae il backtrace per identificare la classe che ha creato il componente
- Determina il translation key formato come: `ModuleNamespace::file.type.fieldname.label` (es: `cms::pages.fields.title.label`)
- Se il key non esiste nel file di traduzione, lo **salva automaticamente** via `SaveTransAction`
- Applica la traduzione al componente oppure fallback al key stesso (per debugging)

**Code flow:**
```
LangServiceProvider.boot()
  → Field::configureUsing() intercetta tutti i Field
  → AutoLabelAction.execute()
    → GetTransKeyAction (backtrace analysis)
    → trans() lookup oppure SaveTransAction
```

---

### 2. FILOSOFIA I18N - Struttura Gerarchica

**Naming Convention Rigoroso:**
```
Modules/ModuleName/lang/{locale}/
├── fields.php          # Campi form (trad. field.fieldname.label)
├── actions.php         # Bottoni/azioni (trad. actions.name.label)
├── validation.php      # Messaggi validazione
├── messages.php        # Messaggi generici
└── sections.php        # Sezioni/wizard steps
```

**Key Pattern:** `namespace::type.parent.name.attribute`
- `cms::fields.title.label` → Campo "title" nella sezione Fields
- `cms::actions.create.label` → Azione "create" con label
- `cms::sections.content.heading` → Sezione "content" con heading

---

### 3. BUSINESS LOGIC - LangBase Classes

Moduli multilingua (Cms, Notify, Lang stesso) usano **LangBase** instead of **XotBase**:

**LangBaseResource** (extends `XotBaseResource` + Spatie Translatable)
- Aggiunge trait `Translatable` che integra `spatie/laravel-translatable`
- Supporta multiple locales: `['it', 'en']` (configurabile)
- Record model deve implementare `HasTranslations` (Spatie)

**LangBaseListRecords** (extends `XotBaseListRecords`)
- Aggiunge `LocaleSwitcher` action negli header
- Permette switching lingua durante navigation
- Mantiene compatibilità con parent actions

**LangBaseCreateRecord/EditRecord**
- Stesso pattern con locale switcher
- Supporta form fields multilingue con Spatie

**HasStrictTranslations Trait**
- Type-safe wrapper su Spatie `HasTranslations`
- Strict return types: `string|array|int|null`
- Conversione automatica di bool/float

---

### 4. RELIGIONE - Dogmi Architetturali

1. **MAI hardcode labels**: `AutoLabelAction` deve trovare il file `lang/locale/file.php`
2. **Nomenclatura rigorosa**: `fields`, `actions`, `sections` obbligatori
3. **Translation Memory**: `Translation` model traccia all keys usate (DB)
4. **Fallback Chain**: `it → en → de` (configurabile in `lang.php`)
5. **Config-driven**: Tutto in `Modules/Lang/config/lang.php` (cache, validation, auto-translate)

---

### 5. SCOPO - Sistema Completo

**Tre livelli di traduzione:**
1. **File-based** (`lang/it/fields.php`) - Core tradizioni, versionate
2. **DB-backed** (`Translation` model) - Runtime tracking, admin UI management
3. **Auto-discovery** (`SaveTransAction`) - Cattura keys mancanti, auto-crea entries

**Spatie Translatable Integration:**
```php
// Modelli multilingua salvano traduzioni come JSON
$post = Post::factory()->create([
    'title' => ['it' => 'Titolo', 'en' => 'Title'],  // JSON
    'content' => ['it' => '...', 'en' => '...']
]);

// Get automatico della locale corrente
$post->getTranslation('title', 'it')  // 'Titolo'
```

---

### 6. ZEN - Essenza Arquitectturale

**Filosofia:** "Translation follows component creation, not component follows translation"

- Quando sviluppatore crea `TextInput::make('title')` in Cms PageResource, Lang automaticamente:
  1. Intercetta via `AutoLabelAction`
  2. Legge file `cms::fields.title.label`
  3. Se missing, lo salva in `Translation` table + file
  4. Applica label al component

- Zero boilerplate: niente `->label(__('cms::...'))`, solo il component itself

- **MultiLanguage Transparency**: Moduli multilingua (Cms, Notify) estendono `LangBaseResource` che include locale switcher + Spatie integration automatica

---

## SUMMARY IN NUMERI

| Aspetto | Dato |
|---------|------|
| Moduli che usano LangBase | 3 (Cms, Notify, Lang) |
| File di traduzione per locale | 8+ file obbligatori/opzionali |
| Locales supportate | 3+ (IT, EN, DE configurabili) |
| Translation source | 2 (File + Database) |
| Auto-discovery triggers | 4 (Field, Column, Action, Step) |
| Cache TTL default | 3600s (1 ora) |

---

## DIFFERENZA CRITICA: LangBase vs XotBase

**Quando usare LangBase:**
- Modulo ha contenuti multilingua (Cms, Blog, News)
- Models implementano `Spatie\Translatable\HasTranslations`
- Form fields salvano JSON multilingua

**Quando usare XotBase:**
- Modulo NON ha contenuti multilingua (User, TechPlanner, UI)
- Standard Laravel/Filament workflow
- Traduzioni solo per UI, non per contenuti

---

**CONCLUSIONE**: Il modulo Lang è il **cuore invisibile** del sistema multilingua, fornendo auto-discovery, Spatie integration e LangBase classes per moduli multilingua.
