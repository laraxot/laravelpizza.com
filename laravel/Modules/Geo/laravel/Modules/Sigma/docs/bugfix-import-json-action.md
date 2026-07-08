# Bugfix: ImportJsonAction - Call to a member function all() on array

## Problema Identificato
**Errore:** `Call to a member function all() on array`  
**File:** `Modules/Sigma/app/Actions/WebService/ImportJsonAction.php:105`  
**Data:** Gennaio 2025

## Contesto
L'action `ImportJsonAction` è responsabile dell'importazione di dati JSON provenienti da web service Sigma nel database. Durante l'elaborazione dei dati, si verifica un errore di tipizzazione.

## Causa Radice

### Codice Problematico (righe 90-105)
```php
/** @var Collection<int, string> $valuesCollection */
$valuesCollection = collect($row)
    ->map(static function ($item, $key) {
        if (is_numeric($item)) {
            return $item;
        }
        $itemString = is_string($item) ? $item : (string) $item;
        $tmp = str_replace(',', '.', $itemString);
        if (is_numeric($tmp)) {
            return $tmp;
        }
        return '"'.str_replace('"', '', $itemString).'"';
    })
    ->all();  // <-- Riga 104: Converte Collection in array
$values = $valuesCollection->all();  // <-- Riga 105: ERRORE! Già un array
```

### Analisi del Problema

1. **Riga 91-103:** Si crea una Collection e si applica map()
2. **Riga 104:** Si chiama `->all()` che converte la Collection in un **array PHP**
3. **Riga 105:** Si tenta di chiamare `->all()` su `$valuesCollection`, ma è già un array
4. **PHPDoc errato:** Il commento alla riga 90 dichiara `Collection<int, string>` ma dopo la riga 104 è un `array<int, string>`

### Perché l'Errore si Verifica
PHP non può chiamare metodi su array. Il metodo `all()` è disponibile solo sugli oggetti Collection di Laravel, non sugli array nativi PHP.

## Impatto
- **Blocco funzionalità:** Import JSON da web service completamente bloccato
- **Severità:** Alta - impedisce importazione dati critici
- **Utenti affetti:** Tutti gli utenti che usano l'import da web service Sigma

## Soluzione Implementata

### Opzione 1: Rimuovere riga 105 (SCELTA)
La soluzione più pulita è rimuovere completamente la riga 105 e rinominare la variabile:

```php
/** @var array<int, string> $values */
$values = collect($row)
    ->map(static function ($item, $key): string|int|float {
        if (is_numeric($item)) {
            return $item;
        }
        $itemString = is_string($item) ? $item : (string) $item;
        $tmp = str_replace(',', '.', $itemString);
        if (is_numeric($tmp)) {
            return $tmp;
        }
        return '"'.str_replace('"', '', $itemString).'"';
    })
    ->all();
```

### Miglioramenti Implementati

1. **PHPDoc corretto:** Cambiato da `Collection<int, string>` a `array<int, string>`
2. **Type hint nel map:** Aggiunto `string|int|float` come return type della closure
3. **Variabile rinominata:** Da `$valuesCollection` a `$values` (più chiaro)
4. **Eliminata ridondanza:** Rimossa la riga 105 non necessaria

### Stessa Logica per Keys (righe 85-88)
Anche il blocco delle keys ha la stessa struttura e va allineato:

```php
/** @var array<int, string> $keys */
$keys = collect($row)
    ->map(static fn ($item, $key): string => strtolower((string) $key))
    ->all();
```

## Verifica Post-Fix

### Test Manuale
1. Accedere a `/sigma/admin/web-service`
2. Eseguire import di un file JSON
3. Verificare che non ci siano errori
4. Controllare che i dati vengano inseriti correttamente nel database

### PHPStan Validation
```bash
cd laravel
./vendor/bin/phpstan analyze Modules/Sigma/app/Actions/WebService/ImportJsonAction.php --level=9
```

### Test Automatizzato
Creare test in `Modules/Sigma/tests/Feature/Actions/ImportJsonActionTest.php`:

```php
public function test_import_json_executes_successfully(): void
{
    $filename = 'test-data.json';
    $disk = 'local';
    $tbl = 'anag';
    
    Storage::fake($disk);
    Storage::disk($disk)->put($filename, json_encode([
        ['id' => 1, 'nome' => 'Test', 'cognome' => 'User'],
    ]));
    
    $result = app(ImportJsonAction::class)->execute($filename, $disk, $tbl);
    
    $this->assertStringContainsString('Records', $result);
}
```

## Pattern e Anti-Pattern

### ✅ Pattern Corretto
```php
// Convertire Collection in array quando serve
$array = collect($data)->map(fn($item) => transform($item))->all();

// Usare direttamente l'array
echo implode(', ', $array);
```

### ❌ Anti-Pattern (da evitare)
```php
// NON chiamare all() due volte
$collection = collect($data)->map(...)->all();
$array = $collection->all();  // ERRORE!

// NON avere PHPDoc sbagliati
/** @var Collection $variable */  // Dice Collection
$variable = collect(...)->all(); // Ma è array
```

## Best Practices Laravel

### Collection vs Array
- **Collection:** Oggetto Laravel con metodi helper (`map`, `filter`, `pluck`, ecc.)
- **Array:** Tipo nativo PHP
- **Conversione:** `->all()` converte Collection → Array
- **Mai:** Chiamare metodi Collection su array

### Tipizzazione Corretta
```php
// Collection
/** @var Collection<int, string> */
$collection = collect([...]);

// Array dopo all()
/** @var array<int, string> */
$array = collect([...])->all();
```

## Lezioni Apprese

1. **PHPDoc Accuracy:** I commenti PHPDoc devono riflettere il tipo REALE della variabile
2. **Collection Lifecycle:** Capire quando si lavora con Collection vs array
3. **Type Safety:** Laravel Collections e array PHP non sono intercambiabili
4. **PHPStan Benefit:** Questo errore sarebbe stato rilevato da PHPStan livello 9+

## Documentazione Correlata

### File Modificati
- `Modules/Sigma/app/Actions/WebService/ImportJsonAction.php`

### File Correlati
- `Modules/Sigma/app/Filament/Pages/WebService.php` - Pagina che chiama l'action
- `Modules/Sigma/Models/Anag.php` - Modello utilizzato per la connessione DB

### Documentazione Esterna
- [Laravel Collections](https://laravel.com/docs/11.x/collections)
- [Spatie QueueableAction](https://github.com/spatie/laravel-queueable-action)
- [PHPStan Collection Types](https://phpstan.org/writing-php-code/phpdoc-types)

## Collegamenti

- [Modulo Sigma README](./readme.md)
- [WebService Integration](./webservice-integration.md)
- [Data Import Flow](./data-import-flow.md)

## Checklist Fix Completa

- [x] Identificata causa radice
- [x] Analizzato impatto
- [x] Implementata soluzione
- [x] Corretti PHPDoc
- [x] Migliorata tipizzazione
- [x] Documentato il bugfix
- [x] Verificato con PHPStan
- [ ] Creato test di regressione
- [ ] Testato manualmente

*Ultimo aggiornamento: gennaio 2025*
