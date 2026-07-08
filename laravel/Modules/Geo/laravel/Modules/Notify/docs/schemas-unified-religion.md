# Filament Schemas Unificati — Regola Canonica

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Filament 5.x / Canonical Rule  
**Audience**: All developers + AI agents

---

## Tesi

In Filament 5.x esiste **un solo sistema di schema**: `Filament\Schemas\Schema`.

Dentro lo stesso schema convivono tre famiglie diverse:

- `Filament\Forms\Components\*` per **input interattivo**
- `Filament\Infolists\Components\*` per **dati read-only strutturati**
- `Filament\Schemas\Components\*` per **layout e contenuto statico/arbitrario**

La sostituzione di `Filament\Forms\Components\Placeholder` **non** segue la regola banale "sempre Infolists".  
Segue invece la semantica del contenuto.

---

## Regola Operativa

| Se il contenuto e... | Usa | Perche |
|---|---|---|
| Un dato che l'utente modifica | `Forms` field (`TextInput`, `Select`, `Checkbox`, ...) | E input, validation, hydration, state |
| Un dato gia raccolto che l'utente deve solo leggere | `Infolists` entry (`TextEntry`, `ImageEntry`, `IconEntry`, ...) | E read-only strutturato, label-value |
| Testo libero, istruzioni, disclaimer, notice, microcopy, HTML statico | `Schemas` prime (`Text`, `Image`, `Icon`, `UnorderedList`) | Non e un field e non e un description list |

Formula breve:

```text
input -> Forms
read-only structured data -> Infolists
static or editorial content -> Schemas prime
```

---

## Placeholder: Perche Va Disattivato

Il sorgente Filament 5.x definisce `Placeholder` cosi:

```php
/**
 * @deprecated Use `TextEntry` with the `state()` method instead.
 */
class Placeholder extends TextEntry
{
    public function content(mixed $content): static
    {
        $this->state($content);

        return $this;
    }
}
```

Conclusioni:

- `Placeholder` e **deprecated**
- non aggiunge una semantica propria
- `content()` e solo un alias di `state()`
- tenerlo nel codice aumenta ambiguita: sembra un form component, ma in realta e read-only

---

## La Distinzione Che Conta

### 1. Read-only strutturato

E il caso da `Infolists`.

Esempi:

- timestamp record
- riepilogo step finale
- email autore
- badge di stato
- elenco immagini o valori chiave

```php
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Utilities\Get;

TextEntry::make('review_email')
    ->state(fn (Get $get): string => (string) ($get('email') ?? ''))
```

### 2. Contenuto statico o editoriale

E il caso da `Schemas` prime.

Esempi:

- testo privacy
- istruzioni di compilazione
- nota legale
- paragrafo introduttivo
- microcopy non label-value

```php
use Filament\Schemas\Components\Text;
use Illuminate\Support\HtmlString;

Text::make(new HtmlString('<p>Informativa privacy...</p>'))
```

`TextEntry` qui sarebbe tecnicamente possibile, ma semanticamente meno corretto: un entry e nato per descrivere un attributo/valore, non per ospitare testo arbitrario.

---

## Esempi Corretti

### Riepilogo wizard

```php
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

Section::make()
    ->schema([
        TextEntry::make('review_title')
            ->state(fn (Get $get): string => (string) ($get('title') ?? '')),
        TextEntry::make('review_email')
            ->state(fn (Get $get): string => (string) ($get('email') ?? '')),
    ])
```

### Notice privacy nello step iniziale

```php
use Filament\Schemas\Components\Text;
use Illuminate\Support\HtmlString;

Text::make(new HtmlString((string) __('fixcity::privacy.notice.html')))
```

### Anti-pattern

```php
// ❌ Sbagliato: usa Placeholder per tutto
Placeholder::make('privacy_notice')
    ->content(new HtmlString(...))

// ❌ Sbagliato: usa TextInput disabled come componente read-only
TextInput::make('review_title')
    ->disabled()
    ->dehydrated(false)
```

---

## Implicazioni Per Laraxot

- Vietare `Placeholder` come default nei nuovi sviluppi
- Migrare gradualmente gli usi esistenti in base alla semantica:
  - `Placeholder` usato come finto field read-only -> `TextEntry`
  - `Placeholder` usato come contenuto statico -> `Text`
- Tenere `XotBasePlaceholder` solo come bridge legacy/documentale, non come pattern da promuovere

---

## Fonti

- Filament Schemas Overview: https://filamentphp.com/docs/5.x/schemas/overview
- Filament Infolists Overview: https://filamentphp.com/docs/5.x/infolists/overview
- Filament Schemas Prime Components: https://filamentphp.com/docs/5.x/schemas/primes
- Placeholder source locale: [Placeholder.php](/var/www/_bases/base_fixcity_fila5/laravel/Themes/Sixteen/vendor/filament/forms/src/Components/Placeholder.php)
