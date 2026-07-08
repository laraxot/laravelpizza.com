---
type: overview
module: Lang
sources:
  - ../../../docs/translations-system.md
  - ../../../docs/filosofia-modulo-lang.md
  - ../../../docs/mcamara-laravel-localization-governance.md
confidence: high
updated: 2026-04-15
---

# Lang Module — Overview

> **Ruolo**: Sistema di traduzioni automatizzato — auto-discovery i18n, routing localizzato, LangBase classes per moduli multilingua.

## Responsabilità del Modulo

Il modulo Lang gestisce **tutta la localizzazione** dell'applicazione:

- Auto-discovery delle translation key tramite `AutoLabelAction` (backtrace analysis)
- Salvataggio automatico di chiavi mancanti via `SaveTransAction`
- Integra `mcamara/laravel-localization` per il routing con prefisso locale
- Fornisce `LangBase*` classes per moduli che gestiscono contenuto multilingua
- Gestisce Filament Admin con switcher di locale inline

## Auto-Discovery delle Traduzioni (Core Pattern)

Il meccanismo centrale di Lang è l'**intercettazione automatica** di tutti i componenti Filament:

```
LangServiceProvider.boot()
  → Field::configureUsing()    intercetta tutti i Field Filament
  → AutoLabelAction.execute()
    → GetTransKeyAction         analisi backtrace, identifica la classe
    → trans() lookup            cerca la chiave
    → SaveTransAction           crea la chiave se mancante
```

**Regola chiave**: Non mettere mai `->label()` espliciti nei campi Filament. Lang lo gestisce automaticamente.

```php
// ❌ VIETATO
TextInput::make('name')->label('Nome')
->label(__('lang::fields.name.label'))

// ✅ CORRETTO
TextInput::make('name')  // Lang intercetta e traduce automaticamente
```

## Struttura delle Chiavi di Traduzione

```
Modules/<Name>/lang/{locale}/
├── fields.php      → cms::fields.title.label
├── actions.php     → cms::actions.create.label
├── validation.php  → cms::validation.required
├── messages.php    → cms::messages.saved
└── sections.php    → cms::sections.content.heading
```

**Pattern naming key**: `namespace::type.parent.name.attribute`

| Esempio | Significato |
|---------|-------------|
| `cms::fields.title.label` | Campo "title" del modulo Cms |
| `cms::actions.create.label` | Azione "create" del modulo Cms |
| `cms::sections.content.heading` | Sezione "content" del modulo Cms |

## mcamara/laravel-localization — Regole

Il routing localizzato segue regole strict derivate dal pacchetto:

### Regola 1: Route pubbliche nel gruppo localizzato

```php
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localize', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {
    // tutte le route frontend vanno qui
});
```

### Regola 2: URL sempre via helper — mai concatenazione manuale

```php
// ✅ CORRETTO
LaravelLocalization::localizeUrl('/servizi')
LaravelLocalization::getLocalizedURL('en', null, [], true)

// ❌ VIETATO
url('/' . app()->getLocale() . '/servizi')
'/it/servizi'   // hardcode locale
```

### Regola 3: Prefisso locale sempre esplicito

```php
// config/laravellocalization.php
'hideDefaultLocaleInURL' => false  // anche it/ è esplicito
```

### Regola 4: Metodi HTTP mutanti ignorati dal redirect

```php
'httpMethodsIgnored' => ['POST', 'PUT', 'PATCH', 'DELETE']
// I form usano action localizzate, ma non vengono redirectati
```

## LangBase Classes (per moduli multilingua)

I moduli con contenuto multilingua (Cms, Notify, Lang) usano **LangBase** invece di **XotBase**:

| Classe | Estende | Aggiunge |
|--------|---------|---------|
| `LangBaseResource` | `XotBaseResource` | trait `Translatable` (Spatie), supporto locale multipla |
| `LangBaseListRecords` | `XotBaseListRecords` | `LocaleSwitcher` action negli header |
| `LangBaseModel` | `XotBaseModel` | `HasTranslations` (Spatie) |

Locales supportate: `['it', 'en']` (configurabile per modulo).

## Struttura File Lang

```
Modules/<Name>/lang/
├── it/
│   ├── fields.php
│   ├── actions.php
│   ├── messages.php
│   └── validation.php
└── en/
    ├── fields.php
    ├── actions.php
    ├── messages.php
    └── validation.php
```

## Anti-Pattern

- `->label()` espliciti nei componenti Filament (Lang lo fa automaticamente)
- URL costruite concatenando `app()->getLocale()` alla stringa
- Helper custom `localized_url()` che duplicano `LaravelLocalization`
- Hardcode di `/it`, `/en` nelle Blade
- Route pubbliche registrate fuori dal gruppo localizzato

## Cross-References

- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — XotBase* che LangBase* estende
- [[../../../../../../laravel/Modules/Cms/docs/wiki/overviews/cms-module|Cms Module]] — usa LangBase per content multilingua
- [[../../../../../../laravel/Modules/UI/docs/wiki/overviews/ui-module|UI Module]] — Filament intercettato da AutoLabelAction

## Raw Sources Prioritari

- `docs/translations-system.md` — LangServiceProvider, struttura file, cache
- `docs/filosofia-modulo-lang.md` — AutoLabelAction, LangBase classes, key pattern
- `docs/mcamara-laravel-localization-governance.md` — regole URL, routing, anti-pattern
- `docs/enum-translation-pattern.md` — traduzione degli Enum
- `docs/translation-preservation-rules.md` — regole per non perdere traduzioni
- `docs/architecture.md` — architettura completa del modulo
