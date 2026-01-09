# Linee Guida per l'Ereditarietà da Classi Filament

## Problema di Compatibilità con Metodi Statici/Non Statici

Quando si estendono classi di Filament, è fondamentale rispettare la **natura statica o non statica** dei metodi. Convertire un metodo non statico in statico (o viceversa) causa errori fatali come:

```
Cannot make non static method Filament\Pages\BasePage::getView() static in class Modules\Xot\Filament\Pages\XotBasePage
```

## Regole Fondamentali

1. **Preservare la firma dei metodi**: Quando si sovrascrive un metodo di una classe genitore, mantenere **esattamente** la stessa firma:
   - Se è `static` nella classe genitore → deve rimanere `static` nella classe figlia
   - Se è non statico nella classe genitore → deve rimanere non statico nella classe figlia
   - Rispettare parametri, tipo di ritorno e visibilità (public/protected/private)

2. **Verifica prima di implementare**: Prima di implementare un metodo, verificare la sua definizione nella classe genitore:
   ```bash
   grep -r "function methodName" /var/www/html/base_<nome progetto>/laravel/vendor/filament
   ```

3. **Principio di Sostituzione di Liskov**: Le sottoclassi devono essere sostituibili alle loro classi base senza alterare il comportamento corretto del programma.

## Casi Comuni

### Metodi Non Statici (di Istanza)

Questi metodi operano sullo stato dell'oggetto e usano `$this`:

```php
// Nella classe Filament
public function getView(): string
{
    return static::$view;
}

// Nella classe XotBase - CORRETTO
public function getView(): string
{
    // implementazione
}

// Nella classe XotBase - ERRATO ❌
public static function getView(): string // Static!
{
    // implementazione
}
```

### Metodi Statici

Questi metodi non operano sullo stato dell'oggetto e usano `static::`:

```php
// Nella classe Filament
public static function getNavigationLabel(): string
{
    return static::$navigationLabel;
}

// Nella classe XotBase - CORRETTO
public static function getNavigationLabel(): string
{
    // implementazione
}

// Nella classe XotBase - ERRATO ❌
public function getNavigationLabel(): string // Non static!
{
    // implementazione
}
```

## Workflow di Implementazione Sicuro

1. **Analizza la classe originale**: Esamina la definizione dei metodi nella classe Filament
2. **Documenta la natura dei metodi**: Specifica nei commenti se il metodo è statico o non statico
3. **Utilizza IDE con supporto per type checking**: L'IDE evidenzierà errori di incompatibilità
4. **Esegui test unitari**: Verifica che l'ereditarietà funzioni come previsto

## Metodi Comuni di Filament e loro Natura

| Classe | Metodo | Tipo | Note |
|--------|--------|------|------|
| `BasePage` | `getView()` | Non statico | Ritorna la vista della pagina |
| `BasePage` | `getViewData()` | Non statico | Ritorna i dati per la vista |
| `Page` | `getTitle()` | Non statico | Ritorna il titolo della pagina |
| `Page` | `getNavigationLabel()` | Statico | Ritorna l'etichetta di navigazione |
| `Page` | `getNavigationIcon()` | Statico | Ritorna l'icona di navigazione |
| `Page` | `getSlug()` | Statico | Ritorna lo slug della pagina |

## Collegamenti

- [Documentazione di Filament](https://filamentphp.com/docs/3.x/panels/pages)
- [Principi di Ereditarietà](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/class_inheritance_principles.md)
- [XotBasePage](/var/www/html/base_<nome progetto>/laravel/Modules/Xot/docs/filament/pages/xotbasepage.md)
