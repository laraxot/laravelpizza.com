# Miglioramenti Qualità Codice - Modulo Sigma (Gennaio 2025)

## Obiettivo
Migliorare la qualità del codice del modulo Sigma utilizzando PHPStan livello 10, PHPMD, PHP Insights e Rector, concentrandosi sulla business logic e sulle dipendenze cross-modulo.

## Analisi Business Logic

### Scopo del Modulo
Il modulo **Sigma (Σ)** è il cuore computazionale per:
- Calcolo schede valutazione progressioni carriera PA
- Aggregazione dati multi-fonte (Performance, PresenzeAssenze, User)
- Denormalizzazione controllata per performance (+90% velocità)
- Conformità normativa CCNL (Art. 16, 19)

### Dipendenze Cross-Modulo
Sigma è utilizzato da:
- **Performance**: Anag, Ana10f, Asz00f, Qua00f, Rep00f, SchedaTrait, SigmaModelTrait
- **Progressioni**: Anag, Ana10f, Asz00f, Qua00f, Rep00f, SchedaTrait, SigmaModelTrait
- **IndennitaResponsabilita**: Anag, Ana10f, Asz00f, Qua00f, Rep00f, BaseScheda
- **Ptv**: BaseScheda che estende modelli Sigma
- **IndennitaCondizioniLavoro**: Modelli Sigma per calcoli
- **Incentivi**: Modelli Sigma per dati dipendenti

## Correzioni PHPStan Livello 10

### Actions/WebService/ImportJsonAction.php
**Errori corretti**:
- ✅ Uso di `Safe\mb_convert_encoding` invece di `mb_convert_encoding` unsafe
- ✅ Tipizzazione corretta di `$content` come string
- ✅ Gestione corretta di `$rows->messaggio` con tipizzazione esplicita
- ✅ Tipizzazione corretta di `json_last_error_msg()` come string

**Modifiche**:
```php
// PRIMA
$content = mb_convert_encoding($content ?? '', 'UTF-8', 'UTF-8');
return '<h2>...messaggio ['.$rows->messaggio.']...</h2>'.$content;

// DOPO
use function Safe\mb_convert_encoding;
$content = mb_convert_encoding($contentRaw, 'UTF-8', 'UTF-8');
/** @var string $messaggio */
$messaggio = $rows->messaggio;
return '<h2>...messaggio ['.$messaggio.']...</h2>'.$content;
```

### Actions/WebService/SyncModelAction.php
**Errori corretti**:
- ✅ Tipizzazione corretta di `$employees` come `array<int, array<string, mixed>>`
- ✅ Tipizzazione esplicita di tutti gli offset array
- ✅ Gestione corretta di valori nullable con cast esplicito

**Modifiche**:
```php
// PRIMA
$employees = Arr::map($employees, function ($employee) use ($model, $only) {
    $data = [
        'matricola' => $employee['MATR'],
        // ...
    ];
});

// DOPO
/** @var array<int, array<string, mixed>> $employees */
$employees = Arr::map($employees, function (array $employee) use ($model, $only): array {
    /** @var array<string, mixed> $employee */
    $matr = $employee['MATR'] ?? '';
    $data = [
        'matricola' => is_string($matr) ? $matr : (string) $matr,
        // ...
    ];
    return $employee;
});
```

### Filament/Actions/SigmaAPIAction.php
**Errori corretti**:
- ✅ Tipizzazione corretta di `$livewire` con controllo `method_exists`
- ✅ Tipizzazione esplicita di `$resource` e `$modelClass`
- ✅ Gestione corretta di `$data['only']` con tipizzazione

**Modifiche**:
```php
// PRIMA
->schema(function (UserContract $user, array $data, $livewire): array {
    $modelClass = $livewire->getResource()::getModel();
    // ...
})

// DOPO
->schema(function (UserContract $user, array $data, $livewire): array {
    /** @var \Filament\Resources\Pages\ListRecords|\Filament\Resources\Pages\CreateRecord|\Filament\Resources\Pages\EditRecord $livewire */
    if (! method_exists($livewire, 'getResource')) {
        return [];
    }
    /** @var \Filament\Resources\Resource $resource */
    $resource = $livewire->getResource();
    /** @var class-string<Model> $modelClass */
    $modelClass = $resource::getModel();
    // ...
})
```

### Filament/Pages/WebService.php
**Errori corretti**:
- ✅ Tipizzazione corretta di `$format` con controllo esistenza classe
- ✅ Tipizzazione esplicita di `$importClass` e `$importAction`

### Filament/Pages/SqlUpload.php
**Errori corretti**:
- ✅ Aggiunta PHPDoc `@property Schema $form` per InteractsWithForms
- ✅ Tipizzazione corretta di tutti i parametri array
- ✅ Gestione corretta di `pathinfo()` con tipizzazione esplicita

### Filament/Resources/WebServiceResource.php
**Errori corretti**:
- ✅ Return type corretto: `array<string, \Filament\Forms\Components\TextInput>`
- ✅ Uso di chiavi stringa per array associativo

### Filament/Resources/WebServiceResource/Pages/ListWebServices.php
**Errori corretti**:
- ✅ Return type corretto: `array<string, \Filament\Actions\CreateAction>`
- ✅ Uso di chiavi stringa per array associativo

### Http/Middleware/FilamentMiddleware.php
**Errori corretti**:
- ✅ Return type corretto per `getModule()`: `Module` invece di `Laravel\Module`
- ✅ Tipizzazione corretta di `$guardName` con controllo null
- ✅ Rimozione dead code dopo `abort()` e `unauthenticated()`

**Modifiche**:
```php
// PRIMA
private function getModule(): Module
{
    return app('modules')->findOrFail(static::$module);
}

// DOPO
/**
 * @return Module
 */
private function getModule(): Module
{
    /** @var Module $module */
    $module = app('modules')->findOrFail(static::$module);
    return $module;
}
```

## Risultati

### PHPStan Livello 10
- ✅ **Actions**: 0 errori (da 8 errori)
- ✅ **Filament**: 0 errori (da 7 errori)
- ✅ **Http**: 0 errori (da 2 errori)
- ⚠️ **Models**: ~1131 errori (da analizzare sistematicamente)

### PHPMD
- ⚠️ Warning su complessità ciclomatica in `ImportJsonAction::execute()` (18, threshold 10)
- ⚠️ Warning su complessità NPath in `ImportJsonAction::execute()` (18720, threshold 200)
- ⚠️ Warning su variabili non utilizzate (da rimuovere)
- ⚠️ Warning su naming conventions (snake_case vs camelCase - accettabile per legacy)

### Rector
- Analisi in corso...

## Prossimi Passi

1. **Analisi sistematica Models**:
   - SchedaTrait: 83 accessor da verificare
   - Modelli legacy: tipizzazione e PHPDoc
   - Relazioni: tipizzazione generics

2. **Refactoring Complessità**:
   - `ImportJsonAction::execute()`: estrarre metodi per ridurre complessità
   - `Asz00k1::gg()`: complessità ciclomatica 17
   - `Qua00f::gg()`: complessità ciclomatica 27

3. **Documentazione**:
   - Aggiornare README.md con risultati
   - Documentare pattern corretti
   - Creare guide per moduli dipendenti

## Note

- I modelli hanno molti errori PHPStan dovuti alla complessità del business logic
- La complessità ciclomatica alta è accettabile per metodi di calcolo complessi
- Le naming conventions snake_case sono mantenute per compatibilità con database legacy

## Collegamenti

- [README.md](./README.md) - Documentazione principale modulo
- [Business Logic Analysis](./business-logic-analysis.md) - Analisi business logic
- [Zen Philosophy](./zen-philosophy.md) - Filosofia e principi

---

**Data**: 2025-01-29  
**Autore**: AI Assistant  
**Status**: ✅ Actions/Filament/Http completati, Models in corso

