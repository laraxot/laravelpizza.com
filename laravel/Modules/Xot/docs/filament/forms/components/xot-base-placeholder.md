# XotBasePlaceholder Component

## Obiettivo

<<<<<<< HEAD
`XotBasePlaceholder` esiste come **bridge legacy** per i casi storici in cui il progetto ha esteso `Filament\Forms\Components\Placeholder` senza passare direttamente da Filament.

Non e un componente da promuovere nei nuovi sviluppi.
=======
Il componente `XotBasePlaceholder` è stato introdotto per aderire rigorosamente al principio architetturale "NON estendere MAI classi Filament direttamente". Questo componente funge da classe base astratta per tutti i placeholder personalizzati all'interno del progetto, garantendo che le estensioni di Filament avvengano tramite la gerarchia `XotBase`.
>>>>>>> origin/dev

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

<<<<<<< HEAD
Il componente `XotBasePlaceholder` estende direttamente `Filament\Forms\Components\Placeholder`.

Va letto nel contesto Filament 5.x:

- `Placeholder` e deprecated
- estende `TextEntry`
- `content()` e un alias di `state()`

Quindi `XotBasePlaceholder` oggi e principalmente un artefatto di compatibilita.
=======
Il componente `XotBasePlaceholder` estende direttamente `Filament\Forms\Components\Placeholder`. Al momento, non introduce logica aggiuntiva ma serve come punto di estensione standardizzato e centralizzato.
>>>>>>> origin/dev

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

<<<<<<< HEAD
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

=======
## Benefici

-   **Aderenza alle Regole Architetturali**: Garantisce che i principi Laraxot di estensione dei componenti Filament siano rispettati.
-   **Centralizzazione**: Fornisce un punto unico per l'aggiunta di funzionalità comuni o per l'override di comportamenti predefiniti dei placeholder in futuro.
-   **Migliore Manutenibilità**: Simplifica la gestione e l'aggiornamento dei placeholder personalizzati, isolando le dipendenze dirette dalle classi Filament.
-   **Conformità PHPStan**: Aiuta a risolvere potenziali problemi di type hinting e analisi statica, come quelli relativi alla risoluzione delle view (`view-string`), incanalandoli attraverso una classe base gestita.

## Uso

>>>>>>> origin/dev
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

<<<<<<< HEAD
- [Schemas Unified Religion](../../../../../../docs/schemas-unified-religion.md)
- [Infolists for Summary](../../widgets/infolists-for-summary.md)
=======
-   [Filament Class Extension Rules](../../../../docs/filament-class-extension-rules.md)
-   [DownloadAttachmentPlaceHolder Documentation](../../cms/docs/filament/forms/components/download-attachment-placeholder.md) (da creare)
>>>>>>> origin/dev
