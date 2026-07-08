---
description:
globs:
alwaysApply: false
---
---
description: >
  Regola per l'estensione di XotBaseResource nelle Filament Resource: vietato dichiarare le proprietà statiche $navigationGroup, $navigationLabel e il metodo statico table(Table $table): Table. Garantisce coerenza, DRY e compatibilità con l'architettura XotBaseResource.
globs:
  - '*/Filament/Resources/*.php'
alwaysApply: true

# Regola: Estensione di XotBaseResource

## When
- Stai creando o modificando una Filament Resource che estende XotBaseResource

## Then
- **NON** dichiarare mai:
  - `protected static ?string $navigationGroup`  
  - `protected static ?string $navigationLabel`  
  - `public static function table(Table $table): Table`
- Tutta la logica di navigazione e tabella deve essere gestita tramite i metodi e le convenzioni fornite da XotBaseResource e dai trait associati.
- Se hai bisogno di personalizzare la navigazione o la tabella, utilizza i metodi previsti da XotBaseResource o crea un trait/wrapper dedicato, MAI ridefinire queste proprietà/metodi direttamente nella Resource.

## Because
- La ridefinizione di queste proprietà/metodi rompe la coerenza e la centralizzazione della logica fornita da XotBaseResource.
- Evita bug, override indesiderati e comportamenti incoerenti tra moduli.
- Garantisce che tutte le risorse seguano lo stesso flusso di configurazione e siano facilmente aggiornabili.
- Permette di applicare patch e miglioramenti globali senza dover modificare ogni Resource manualmente.

## Common Pitfalls
- **Errore:** Dichiarare `$navigationGroup` o `$navigationLabel` in una Resource che estende XotBaseResource
  - **Soluzione:** Rimuovere la dichiarazione, usare la configurazione centralizzata
- **Errore:** Ridefinire il metodo statico `table(Table $table): Table`
  - **Soluzione:** Usare i metodi previsti da XotBaseResource o i trait
- **Errore:** Copiare esempi da documentazione Filament standard senza adattarli all'architettura XotBaseResource
  - **Soluzione:** Seguire sempre le regole del progetto e la documentazione custom

## Esempio ERRATO
```php
class UserResource extends XotBaseResource {
    protected static ?string $navigationGroup = 'Utenti'; // VIETATO
    public static function table(Table $table): Table { ... } // VIETATO
}
```

## Esempio CORRETTO
```php
class UserResource extends XotBaseResource {
    // Nessuna dichiarazione di navigationGroup, navigationLabel o table
    // Personalizzazioni solo tramite metodi/trait previsti
}
```

# Regola: Filament Pages che estendono XotBasePage

## When
- Stai creando o modificando una Filament Page che estende `Modules\Xot\Filament\Pages\XotBasePage`

## Then
- **NON** aggiungere `implements HasForms` alla classe figlia
- **NON** importare/usare `InteractsWithForms` nella classe figlia

## Because
- `XotBasePage` implementa già `HasForms` e include già `InteractsWithForms`, quindi la ripetizione è ridondante e aumenta il rumore/risks di incoerenza.

## Esempio ERRATO
```php
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class PasswordExpired extends XotBasePage implements HasForms
{
    use InteractsWithForms;
}
```

## Esempio CORRETTO
```php
class PasswordExpired extends XotBasePage
{
}
```