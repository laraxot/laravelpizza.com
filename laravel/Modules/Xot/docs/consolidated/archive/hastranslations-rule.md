# 🚨 REGOLA FONDAMENTALE: HasTranslations

## Regola Critica

**SE IL MODELLO HA `use Spatie\Translatable\HasTranslations` → SEMPRE `LangBase*`**

## Procedura di Controllo

### 1. Identifica il Modello
Prima di creare/modificare una pagina Filament, identifica il modello corrispondente:
- `CreateArticle` → modello `Article`
- `CreateCategory` → modello `Category`
- `CreatePageContent` → modello `PageContent`

### 2. Controlla HasTranslations
Apri il file del modello e cerca:
```php
use Spatie\Translatable\HasTranslations;

class MyModel extends BaseModel {
    use HasTranslations;  // ← SE PRESENTE
    // ...
}
```

### 3. Scegli la Classe Base
- **HasTranslations PRESENTE** → `LangBase*`
- **HasTranslations ASSENTE** → `XotBase*`

## Esempi Verificati

### ✅ Modelli CON HasTranslations (usa LangBase*)

**Article (Blog):**
```php
// Modules/Blog/app/Models/Article.php
use HasTranslations;
public $translatable = ['title', 'content_blocks', 'sidebar_blocks', 'footer_blocks'];

// Pagine Filament:
class CreateArticle extends LangBaseCreateRecord {}
class EditArticle extends LangBaseEditRecord {}
class ViewArticle extends LangBaseViewRecord {}
```

**Category (Blog):**
```php
// Modules/Blog/app/Models/Category.php
use HasTranslations;
public $translatable = ['title', 'description'];

// Pagine Filament:
class CreateCategory extends LangBaseCreateRecord {}
class EditCategory extends LangBaseEditRecord {}
```

**PageContent (Cms):**
```php
// Modules/Cms/app/Models/PageContent.php
use HasTranslations;
public $translatable = ['name', 'blocks'];

// Pagine Filament:
class CreatePageContent extends LangBaseCreateRecord {}
class EditPageContent extends LangBaseEditRecord {}
class ViewPageContent extends LangBaseViewRecord {}
```

### ✅ Modelli SENZA HasTranslations (usa XotBase*)

**Rating (Rating):**
```php
// Modules/Rating/app/Models/Rating.php
// NO HasTranslations

// Pagine Filament:
class CreateRating extends XotBaseCreateRecord {}
class EditRating extends XotBaseEditRecord {}
```

## Errori Comuni

### ❌ Errore: Usare XotBase con modello HasTranslations
```php
// Modello HA HasTranslations
class Article extends BaseModel {
    use HasTranslations;
}

// ❌ ERRATO - Usa XotBase invece di LangBase
class CreateArticle extends XotBaseCreateRecord {}
```

### ❌ Errore: Aggiungere trait Translatable
```php
// ❌ ERRATO - NON aggiungere trait se usi LangBase
class CreateArticle extends LangBaseCreateRecord {
    use Translatable;  // ← NON FARE - già incluso in LangBase
}
```

## Classi Disponibili

### LangBase (per modelli CON HasTranslations)
- `LangBaseResource`
- `LangBaseCreateRecord`
- `LangBaseEditRecord`
- `LangBaseViewRecord`
- `LangBaseListRecords`

### XotBase (per modelli SENZA HasTranslations)
- `XotBaseResource`
- `XotBaseCreateRecord`
- `XotBaseEditRecord`
- `XotBaseViewRecord`
- `XotBaseListRecords`

## Comando di Verifica

Per verificare tutti i modelli con HasTranslations:
```bash
grep -r "use HasTranslations" laravel/Modules/*/app/Models/
```

## Link Correlati

- [Pattern di Estensione Filament](filament_extension_pattern.md)
- [Log Correzioni](filament_corrections_log.md)
- [Best Practices Filament](filament_best_practices.md) 