# Resources Array Keys Philosophy: String Keys Always

## Data: 2025-01-22

## Il Dibattito Feroce

### 🎭 Protagonisti

**Il Purista** (Type Safety e Coerenza)
vs
**Il Pragmatico** (Semplice e Funziona)

---

## Round 1: Array Keys: String o Int?

### 🔴 Il Purista Attacca

> "Tutti i metodi che restituiscono array di componenti Filament DEVONO usare chiavi stringhe! È richiesto da Filament e XotBaseResource! `array<int, Component>` è SBAGLIATO!"

**Argomenti:**
- **Filament Requirement**: Filament si aspetta chiavi stringhe per identificazione componenti
- **XotBaseResource**: L'architettura Laraxot impone questo pattern
- **PHPStan Compliance**: La tipizzazione corretta è necessaria per PHPStan livello 10
- **Component Identification**: L'identificazione dei componenti dipende dalle chiavi stringhe

### 🟢 Il Pragmatico Controattacca

> "Ma gli array numerici sono più semplici! Non serve complicare con chiavi stringhe!"

**Argomenti:**
- **Semplicità**: Array numerici sono più semplici da scrivere
- **Funziona**: Anche con chiavi numeriche funziona
- **Meno codice**: Non serve pensare a nomi per le chiavi

### 🏆 VINCITORE: Il Purista

**Motivazione della Vittoria:**

1. **Filament Architecture**: Filament si aspetta chiavi stringhe per:
   - Identificazione univoca dei componenti
   - Gestione del ciclo di vita
   - Aggiornamenti reattivi
   - Validazione e error handling

2. **XotBaseResource Pattern**: `XotBaseResource` e `XotBaseRelationManager` gestiscono automaticamente le traduzioni basandosi sulle chiavi stringhe:
   ```php
   // XotBaseResource usa le chiavi per le traduzioni
   'name' => TextInput::make('name') // Cerca traduzione in 'fields.name.label'
   ```

3. **PHPStan Level 10**: La tipizzazione corretta è necessaria:
   ```php
   // ✅ CORRETTO
   /**
    * @return array<string, \Filament\Tables\Columns\Column>
    */
   public static function getTableColumns(): array
   {
       return [
           'id' => TextColumn::make('id'),
           'name' => TextColumn::make('name'),
       ];
   }
   
   // ❌ ERRATO
   /**
    * @return array<int, \Filament\Tables\Columns\Column>
    */
   public static function getTableColumns(): array
   {
       return [
           TextColumn::make('id'),
           TextColumn::make('name'),
       ];
   }
   ```

4. **Manutenibilità**: Chiavi stringhe descrittive rendono il codice più leggibile e manutenibile.

**Decisione Finale**: ✅ **SEMPRE USARE CHIAVI STRINGHE**

---

## Metodi che Richiedono Chiavi Stringhe

### Metodi Obbligatori

1. **`getFormSchema()`**: `array<string, Field|Section>`
2. **`getTableColumns()`**: `array<string, Column>`
3. **`getTableFilters()`**: `array<string, BaseFilter>`
4. **`getTableActions()`**: `array<string, Action>`
5. **`getTableBulkActions()`**: `array<string, Action|ActionGroup>`
6. **`getHeaderActions()`**: `array<string, Action>`
7. **`getInfolistSchema()`**: `array<string, Component>`

### Pattern Corretto

```php
/**
 * @return array<string, \Filament\Tables\Columns\Column>
 */
public static function getTableColumns(): array
{
    return [
        'id' => TextColumn::make('id')
            ->sortable()
            ->searchable(),
        'name' => TextColumn::make('name')
            ->sortable()
            ->searchable(),
        'created_at' => TextColumn::make('created_at')
            ->dateTime()
            ->sortable(),
    ];
}
```

### Pattern Errato

```php
/**
 * @return array<int, \Filament\Tables\Columns\Column> // ❌ ERRATO
 */
public static function getTableColumns(): array
{
    return [
        TextColumn::make('id'), // ❌ Nessuna chiave stringa
        TextColumn::make('name'),
        TextColumn::make('created_at'),
    ];
}
```

---

## Correzioni Implementate

### OauthClientResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`

### TeamUserResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`

### TenantUserResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`

### OauthPersonalAccessClientResource
- ✅ Corretto `getTableColumns()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableFilters()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableActions()`: chiavi stringhe aggiunte
- ✅ Corretto `getTableBulkActions()`: chiavi stringhe aggiunte
- ✅ Corretto PHPDoc: `array<string, ...>` invece di `array<int, ...>`
- ✅ Corretto modello: `OauthPersonalAccessClient` invece di `Laravel\Passport\PersonalAccessClient`
- ✅ Corretto import Actions: `Filament\Actions\` invece di `Tables\Actions\`

---

## Filosofia Finale

**Type Safety + Coerenza = Chiavi Stringhe Sempre**

- ✅ **Chiavi stringhe**: Sempre usare chiavi stringhe descrittive
- ✅ **PHPDoc corretto**: `array<string, Type>` invece di `array<int, Type>`
- ✅ **Coerenza**: Tutti i metodi seguono lo stesso pattern
- ✅ **Manutenibilità**: Chiavi descrittive rendono il codice più leggibile

## Prossimi Passi

1. ✅ Corretto `OauthClientResource`
2. ✅ Corretto `TeamUserResource`
3. ✅ Corretto `TenantUserResource`
4. ✅ Corretto `OauthPersonalAccessClientResource`
5. ⚠️ Verificare altre Resources per conformità

## Collegamenti

- [XotBaseResource Source Code](../../../Xot/app/Filament/Resources/XotBaseResource.php)
- [Critical Filament Rule: getInfolistSchema String Keys](./critical-filament-rule-getinfolistschema-string-keys.md)
- [Filament Best Practices](./filament-best-practices.md)
