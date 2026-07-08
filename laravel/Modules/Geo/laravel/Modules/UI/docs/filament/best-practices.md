# Best Practices Filament

## Regole fondamentali

1. **MAI utilizzare metodi `->label()` nei componenti Filament**
   - Le etichette devono essere gestite tramite file di traduzione
   - Il sistema utilizza automaticamente il LangServiceProvider per risolvere le traduzioni

2. **Rispettare la visibilità dei metodi delle classi base**
   - Non dichiarare come statici i metodi che nella classe base sono di istanza
   - Non rendere astratti i metodi che nella classe base sono concreti

3. **Utilizzare i componenti nativi di Filament quando disponibili**
   - Non creare componenti personalizzati che duplicano funzionalità esistenti
   - Per separatori nei dropdown, usare HTML diretto: `<div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>`

4. **Non registrare manualmente i componenti Blade**
   - Quando si estende `XotBaseServiceProvider`, la registrazione è automatica
   - I componenti vengono automaticamente scoperti nella directory `View/Components`

## Errori comuni da evitare

### 1. Incompatibilità tra metodi statici e di istanza

**Errore comune:**
```php
// ERRATO ❌
public static function getTableColumns(): array
```

**Soluzione corretta:**
```php
// CORRETTO ✅
public function getTableColumns(): array
```

### 2. Uso di ->label() nei componenti

**Errore comune:**
```php
// ERRATO ❌
TextColumn::make('name')
    ->label('Nome utente')
```

**Soluzione corretta:**
```php
// CORRETTO ✅
TextColumn::make('name')
// La traduzione verrà risolta automaticamente dai file di lingua
```

### 3. Registrazione manuale di componenti Blade

**Errore comune:**
```php
// ERRATO ❌
public function boot(): void
{
    Blade::component('chart-assets', ChartAssets::class);
}
```

**Soluzione corretta:**
```php
// CORRETTO ✅
// Non fare nulla, XotBaseServiceProvider registra automaticamente i componenti
```

### 4. Struttura errata dei componenti dropdown

**Errore comune:**
```blade
<!-- ERRATO ❌ -->
<x-filament::dropdown.item>
    Content
</x-filament::dropdown.item>
```

**Soluzione corretta:**
```blade
<!-- CORRETTO ✅ -->
<x-filament::dropdown.list.item>
    Content
</x-filament::dropdown.list.item>
```

## Riferimenti

- [Filament Forms](https://filamentphp.com/docs/3.x/forms/installation)
- [Filament Tables](https://filamentphp.com/docs/3.x/tables/installation)
- [Filament Blade Components](https://filamentphp.com/docs/3.x/support/blade-components)
- [PSR-4 Autoloading Standard](https://www.php-fig.org/psr/psr-4/)
