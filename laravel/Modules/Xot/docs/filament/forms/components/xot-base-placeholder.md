# XotBasePlaceholder Component

## Obiettivo

`XotBasePlaceholder` esiste come **bridge legacy** per i casi storici in cui il progetto ha esteso `Filament\Forms\Components\Placeholder` senza passare direttamente da Filament.

Non e un componente da promuovere nei nuovi sviluppi.

## Gerarchia di Ereditarietà

```
Filament\Forms\Components\Placeholder
    ↓
Modules\Xot\Filament\Forms\Components\XotBasePlaceholder
    ↓
Modules\Cms\Filament\Forms\Components\DownloadAttachmentPlaceHolder
    // E altri placeholder personalizzati
```

## Implementazione

Il componente `XotBasePlaceholder` estende direttamente `Filament\Forms\Components\Placeholder`.

Va letto nel contesto Filament 5.x:

- `Placeholder` e deprecated
- estende `TextEntry`
- `content()` e un alias di `state()`

Quindi `XotBasePlaceholder` oggi e principalmente un artefatto di compatibilita.

```php
<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Forms\Components;

use Filament\Forms\Components\Placeholder;

class XotBasePlaceholder extends Placeholder
{
    // Logica comune futura per i placeholder Xot
}
```

## Posizione Architetturale Corrente

### Nuovo sviluppo

Non introdurre nuovi usi di `XotBasePlaceholder`.

Usare invece:

- `TextEntry` per dati read-only strutturati
- `Text` per contenuto statico o editoriale

### Codice legacy

`XotBasePlaceholder` puo restare temporaneamente dove il refactor non e ancora stato eseguito o dove esistono componenti custom storici basati su questa gerarchia.

## Strategia di Migrazione

| Caso storico | Migrazione corretta |
|---|---|
| Placeholder che mostra un attributo/valore | `Filament\Infolists\Components\TextEntry` |
| Placeholder che ospita testo/HTML statico | `Filament\Schemas\Components\Text` |
| Placeholder custom esteso da modulo | refactor verso componente semanticamente corretto; usare `XotBasePlaceholder` solo come tappa intermedia |

## Uso

Da considerare legacy:

I placeholder personalizzati, come `DownloadAttachmentPlaceHolder`, devono ora estendere `XotBasePlaceholder`:

```php
<?php

declare(strict_types=1);

namespace Modules\Cms\Filament\Forms\Components;

use Modules\Xot\Filament\Forms\Components\XotBasePlaceholder; // Import the new base class

class DownloadAttachmentPlaceHolder extends XotBasePlaceholder
{
    // ... implementazione specifica del placeholder
}
```

## Collegamenti Utili

- [Schemas Unified Religion](../../../../../../docs/schemas-unified-religion.md)
- [Infolists for Summary](../../widgets/infolists-for-summary.md)
