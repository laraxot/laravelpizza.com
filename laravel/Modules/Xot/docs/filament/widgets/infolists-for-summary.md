# Infolists per Riepilogo — Regola Corretta

**Status**: Active  
**Created**: 2026-04-14  
**Last Updated**: 2026-04-14  
**Category**: Architecture / Filament / Wizard  
**Audience**: All developers

---

## Regola

Nel passo di review/riepilogo di un wizard:

- usare `Filament\Infolists\Components\*` per i **dati read-only strutturati**
- usare `Filament\Schemas\Components\Text` e gli altri prime components per **istruzioni o testo editoriale**
- non usare `Filament\Forms\Components\Placeholder`
- non usare `TextInput::disabled()` o altri field come finti componenti read-only

---

## Perche

Il summary step non raccoglie input: espone dati gia immessi.

Questa semantica combacia con gli `Infolists`:

- visualizzazione label-value
- stato letto via `Get $get`
- nessuna ambiguita con validazione o persistenza

Esempio:

```php
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Utilities\Get;

TextEntry::make('review_title')
    ->state(fn (Get $get): string => (string) ($get('title') ?? ''))
```

---

## Cosa NON Concludere

Questa regola **non** significa:

- "in un wizard si usano solo Infolists"
- "qualsiasi Placeholder va sempre sostituito con TextEntry"

Se il contenuto e un testo statico, una nota privacy, una spiegazione, un disclaimer o HTML arbitrario, il componente giusto e un prime component di `Filament\Schemas\Components`, in genere `Text`.

```php
use Filament\Schemas\Components\Text;
use Illuminate\Support\HtmlString;

Text::make(new HtmlString('<p>Informativa privacy...</p>'))
```

---

## Anti-pattern

### Blade partial come soluzione primaria

```php
// ❌ Sbagliato
SchemaView::make('fixcity::filament.widgets.partials.ticket-create-wizard-summary')
```

Perche:

- sposta la semantica fuori dallo schema
- duplica label e mapping
- rende piu fragile il controllo architetturale

### Field disabilitati come finto summary

```php
// ❌ Sbagliato
TextInput::make('review_title')
    ->disabled()
    ->dehydrated(false)
```

---

## Zen

La domanda giusta non e:

> "Posso mostrare qualcosa dentro un wizard?"

La domanda giusta e:

> "Sto mostrando un dato strutturato o sto pubblicando contenuto statico?"

Se e dato strutturato: `Infolists`.  
Se e contenuto statico: `Schemas` prime.  
Se e input: `Forms`.

---

## Riferimenti

- [docs/schemas-unified-religion.md](/var/www/_bases/base_fixcity_fila5/docs/schemas-unified-religion.md)
- https://filamentphp.com/docs/5.x/schemas/overview
- https://filamentphp.com/docs/5.x/infolists/overview
- https://filamentphp.com/docs/5.x/schemas/primes
