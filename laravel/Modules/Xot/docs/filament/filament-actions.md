# Azioni Filament

## Best Practices per le Azioni

### Struttura Base
Le azioni Filament devono seguire questa struttura base:

```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Actions\Table;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;

class CustomAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->translateLabel()
            ->tooltip('Descrizione azione')
            ->icon('heroicon-o-icon-name')
            ->action(fn (Model $record) => app(ActionClass::class)
                ->execute(model: $record));
    }
}
```

### Convenzioni di Nomenclatura
- Le azioni di tabella devono essere in `Filament\Actions\Table`
- Il nome della classe deve terminare con `Action`
- Il nome del file deve corrispondere al nome della classe

### Azioni PDF
Le azioni PDF devono:
1. Estendere `Action`
2. Utilizzare `PdfByModelAction` per la generazione
3. Specificare un'icona appropriata
4. Includere un tooltip descrittivo
5. Aprire il PDF in una nuova tab

### Esempio di Azione PDF
```php
<?php

declare(strict_types=1);

namespace Modules\ModuleName\Filament\Actions\Table;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Actions\Export\PdfByModelAction;

class MakePdfAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->translateLabel()
            ->tooltip('Genera PDF')
            ->icon('heroicon-o-document-arrow-down')
            ->openUrlInNewTab()
            ->action(fn (Model $record) => app(PdfByModelAction::class)
                ->execute(model: $record));
    }
}
```

### Integrazione con le Risorse
Per utilizzare un'azione in una risorsa:

```php
public static function table(Table $table): Table
{
    return $table
        ->actions([
            MakePdfAction::make(),
            // altre azioni...
        ]);
}
```

### Traduzioni
Le traduzioni per le azioni devono essere definite nel file di traduzione del modulo:

```php
'actions' => [
    'make_pdf' => [
        'label' => 'Genera PDF',
        'tooltip' => 'Genera il documento in formato PDF',
    ],
],
```

### Best Practices
1. Utilizzare sempre `declare(strict_types=1)`
2. Seguire le convenzioni di nomenclatura
3. Documentare il codice
4. Utilizzare le traduzioni
5. Mantenere le azioni semplici e focalizzate
6. Utilizzare azioni in coda per operazioni pesanti
7. Fornire feedback appropriati all'utente 