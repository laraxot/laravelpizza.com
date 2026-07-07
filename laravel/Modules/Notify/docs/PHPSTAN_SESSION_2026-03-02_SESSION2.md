# PHPStan Sessione 2 - 2026-03-02

## Stato Iniziale
- **Data**: 2026-03-02
- **Livello**: 10 (Massimo)
- **Errori Totali**: 194
- **Moduli Analizzati**: Tutti i moduli in `Modules/`

## Problemi Risolti (Fatal Errors)

### 1. Metodo duplicato `authId()` in SushiToJson.php
**Problema**: 
- Linea 88: `public static function authId(): string`
- Linea 426: `protected function authId(): int|string|null`
- Errore: "Cannot redeclare Modules\Tenant\Models\Traits\SushiToJson::authId()"

**Soluzione**: Rimossa la definizione protetta alla linea 426 (duplicato), mantenendo quella statica per PHPStan.

### 2. Metodo duplicato `ensureDirectoryExists()` in SushiToJson.php
**Problema**:
- Linea 104: `public static function ensureDirectoryExists(string $path): void`
- Linea 426: `protected function ensureDirectoryExists(string $filePath): void`
- Errore: "Cannot redeclare Modules\Tenant\Models\Traits\SushiToJson::ensureDirectoryExists()"

**Soluzione**: Rimossa la definizione protetta alla linea 426 (duplicato), mantenendo quella statica per PHPStan.

### 3. Metodo duplicato `getJsonFile()` in SushiToJsons.php
**Problema**:
- Linea 37: `public function getJsonFile(): string`
- Linea 90: `public function getJsonFile(): string` (duplicato)
- Errore: "Cannot redeclare Modules\Tenant\Models\Traits\SushiToJsons::getJsonFile()"

**Soluzione**: Rimossa la seconda definizione alla linea 90 (duplicato), mantenendo la prima.

## Errori PHPStan Attuali (194)

### Analisi Preliminare
Gli errori principali individuati:

1. **Section::getJsonFile()** - Metodo non trovato (1 errore)
2. **InformationSchemaTable::getModelCount()** - Metodo statico non trovato (1 errore)
3. **InformationSchemaTable::updateModelCount()** - Metodo statico non trovato (1 errore)
4. **CountAction::execute()** - Return type mixed invece di int (1 errore)

## Prossimi Passi

### Phase 1: Fix Rapidi (1-5 errori)
1. Aggiungere `getJsonFile()` a `Section` model
2. Aggiungere `getModelCount()` a `InformationSchemaTable` model
3. Aggiungere `updateModelCount()` a `InformationSchemaTable` model
4. Correggere return type di `CountAction::execute()`

### Phase 2: Analisi Completa
Eseguire analisi completa per identificare tutti i 194 errori:
```bash
cd /var/www/_bases/base_fixcity_fila5/laravel
./vendor/bin/phpstan analyse Modules --level=10 --memory-limit=2G --error-format=table > phpstan-full-report-2026-03-02-session2.txt
```

## Note Importanti
- PHPStan ora funziona correttamente senza fatal errors
- Tutti i trait duplicati sono stati rimossi
- I metodi helper per PHPStan sono stati mantenuti

## File Modificati
1. `laravel/Modules/Tenant/app/Models/Traits/SushiToJson.php` - Rimossi 2 metodi duplicati
2. `laravel/Modules/Tenant/app/Models/Traits/SushiToJsons.php` - Rimosso 1 metodo duplicato

## Primi Errori da Risolvere
```
 ------ ---------------------------------------------------------------- 
  Line   Cms/app/Models/Section.php                                        
 ------ ---------------------------------------------------------------- 
  184    Call to an undefined method                                       
         Modules\Cms\Models\Section::getJsonFile().                      
         🪪  method.notFound                                             
         ✏️  Tenant/app/Models/Traits/SushiToJsons.php                   
 ------ ---------------------------------------------------------------- 

 ------ --------------------------------------------------------------------- 
  Line   Xot/app/Actions/ModelClass/CountAction.php                           
 ------ --------------------------------------------------------------------- 
  29     Call to an undefined static method                                   
         Modules\Xot\Models\InformationSchemaTable::getModelCount().          
         🪪  staticMethod.notFound                                            
         ✏️  Xot/app/Actions/ModelClass/CountAction.php                       
  29     Method Modules\Xot\Actions\ModelClass\CountAction::execute() should  
         return int but returns mixed.                                        
         🪪  return.type                                                      
         ✏️  Xot/app/Actions/ModelClass/CountAction.php                       
 ------ ---------------------------------------------------------------- 

 ------ ---------------------------------------------------------------- 
  Line   Xot/app/Actions/ModelClass/UpdateCountAction.php                
 ------ ---------------------------------------------------------------- 
  25     Call to an undefined static method                              
         Modules\Xot\Models\InformationSchemaTable::updateModelCount().  
         🪪  staticMethod.notFound                                       
         ✏️  Xot/app/Actions/ModelClass/UpdateCountAction.php            
 ------ ---------------------------------------------------------------- 
```

## Stato
- **In Progress**: Analisi completa dei 194 errori
- **Pronto per**: Fix degli errori identificati