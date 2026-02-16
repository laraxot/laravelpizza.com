# Risoluzione Conflitto Trait: NavigationLabelTrait e XotBasePage

## Problema

Si verificava un conflitto di firma del metodo `trans()` quando `NavigationLabelTrait` veniva usato insieme a `XotBasePage`:

```
PHP Fatal error: Declaration of Modules\Xot\Filament\Traits\NavigationLabelTrait::trans(...)
must be compatible with Modules\Xot\Filament\Pages\XotBasePage::trans(...)
```

### Causa

- `NavigationLabelTrait` usava `TransTrait` che definisce:
  ```php
  public static function trans(string $key, bool $exceptionIfNotExist = false, array $params = []): string
  ```

- `XotBasePage` definisce:
  ```php
  public static function trans(string $key, array $replace = [], ?string $locale = null, bool $useFallback = true): string
  ```

- Quando una classe usa `NavigationLabelTrait` e estende `XotBasePage`, entrambi definiscono `trans()` con firme incompatibili.

## Soluzione

Creato `TransFuncTrait` che contiene solo i metodi necessari per `NavigationLabelTrait`:
- `transFunc()` - traduzione basata su nome funzione
- `getKeyTransFunc()` - generazione chiave traduzione da nome funzione

`NavigationLabelTrait` ora usa `TransFuncTrait` invece di `TransTrait`, evitando il conflitto con `trans()`.

### File Modificati

1. **Creato**: `Modules/Xot/app/Filament/Traits/TransFuncTrait.php`
   - Contiene solo `transFunc()` e `getKeyTransFunc()`
   - NON contiene `trans()` per evitare conflitti

2. **Modificato**: `Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php`
   - Cambiato da `use TransTrait;` a `use TransFuncTrait;`
   - `NavigationLabelTrait` usa solo `transFunc()`, non `trans()`

3. **Modificato**: `Modules/Xot/app/Filament/Resources/XotBaseResource/Pages/XotBaseManageRelatedRecords.php`
   - Rimosse precedence rules per metodi non più presenti in `NavigationLabelTrait`
   - Mantenute solo per `getKeyTransFunc()` e `transFunc()`

## Pattern Architetturale

### Quando Usare TransTrait

Usa `TransTrait` quando hai bisogno di:
- `trans()` - traduzione generica con gestione errori
- `getKeyTrans()` - generazione chiave traduzione
- `transClass()` - traduzione basata su classe
- `transChoice()` - traduzione con pluralizzazione

### Quando Usare TransFuncTrait

Usa `TransFuncTrait` quando:
- Hai bisogno solo di `transFunc()` e `getKeyTransFunc()`
- Vuoi evitare conflitti con altri trait che definiscono `trans()`
- Stai creando trait che verranno usati insieme a classi che hanno il proprio `trans()`

### Quando Usare NavigationLabelTrait

Usa `NavigationLabelTrait` per:
- Metodi di navigazione Filament (`getNavigationLabel()`, `getNavigationGroup()`, ecc.)
- Quando NON hai bisogno di `trans()` diretto
- Quando vuoi traduzioni automatiche basate su nomi di metodi

## Verifica

Dopo la modifica, verifica con:

```bash
./vendor/bin/phpstan analyse Modules/Xot/app/Filament/Traits/NavigationLabelTrait.php \
  Modules/Xot/app/Filament/Traits/TransFuncTrait.php \
  Modules/Xot/app/Filament/Pages/XotBasePage.php \
  --level=10
```

## Note Importanti

- `NavigationLabelTrait` NON deve mai usare `TransTrait` direttamente se viene usato insieme a classi che definiscono `trans()`
- `TransFuncTrait` è un subset di `TransTrait` creato specificamente per evitare conflitti
- Se hai bisogno di `trans()` in una classe che usa `NavigationLabelTrait`, usa `XotBasePage::trans()` o definisci il tuo metodo

---

*Risolto: [DATE]*
*Architecture Version: XotBase 2.1*
