# XotBasePlaceholder Component

## Obiettivo

Il componente `XotBasePlaceholder` è stato introdotto per aderire rigorosamente al principio architetturale "NON estendere MAI classi Filament direttamente". Questo componente funge da classe base astratta per tutti i placeholder personalizzati all'interno del progetto, garantendo che le estensioni di Filament avvengano tramite la gerarchia `XotBase`.

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

Il componente `XotBasePlaceholder` estende direttamente `Filament\Forms\Components\Placeholder`. Al momento, non introduce logica aggiuntiva ma serve come punto di estensione standardizzato e centralizzato.

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

## Benefici

-   **Aderenza alle Regole Architetturali**: Garantisce che i principi Laraxot di estensione dei componenti Filament siano rispettati.
-   **Centralizzazione**: Fornisce un punto unico per l'aggiunta di funzionalità comuni o per l'override di comportamenti predefiniti dei placeholder in futuro.
-   **Migliore Manutenibilità**: Simplifica la gestione e l'aggiornamento dei placeholder personalizzati, isolando le dipendenze dirette dalle classi Filament.
-   **Conformità PHPStan**: Aiuta a risolvere potenziali problemi di type hinting e analisi statica, come quelli relativi alla risoluzione delle view (`view-string`), incanalandoli attraverso una classe base gestita.

## Uso

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

-   [Filament Class Extension Rules](../../../../../../docs/filament-class-extension-rules.md)
-   [DownloadAttachmentPlaceHolder Documentation](../../cms/docs/filament/forms/components/download-attachment-placeholder.md) (da creare)
