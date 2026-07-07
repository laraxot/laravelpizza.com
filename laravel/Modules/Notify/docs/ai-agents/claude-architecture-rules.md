# CLAUDE Architecture Rules

Regole architetturali critiche del progetto.

## 1. Theme Resolution (CRITICAL)

Il **tema pubblico** non è hardcoded: si ricava dalla configurazione tenant.

### Workflow

1. **`.env`** → `APP_URL` (es. `http://laravelpizza.local`)
2. **Cartella config** → da `APP_URL` il modulo Tenant ricava il nome tenant
3. **`config/local/laravelpizza/xra.php`** → chiave **`pub_theme`**
4. **Tema** → view namespace **`pub_theme::`**

### Build Tema

```bash
cd laravel/Themes/Meetup
composer update -W
npm install
npm run build
npm run copy  # OBbligatorio per vedere modifiche CSS/JS
```

---

## 2. BelongsToMany - CRITICAL

**NEVER use `$this->belongsToMany()` for many-to-many. ALWAYS use `$this->belongsToManyX()`.**

- `belongsToManyX` è nel trait `RelationX` (XotBaseModel)
- Sintassi: `$this->belongsToManyX(Related::class)` oppure con nome tabella pivot

---

## 3. Database Config - CRITICAL

**`config/database.php`** (base) e **`config/local/{tenant}/database.php`** devono seguire lo standard Laravel 12.

**NESSUNA** connessione per-modulo hardcoded:
- ❌ `notify`, `geo`, `media`, `job`, `xot`, `activity`, `cms`
- ✅ Solo connessioni driver (sqlite, mysql, mariadb, pgsql, sqlsrv)

---

## 4. SVG: File .svg, NO inline - CRITICAL

**Nelle Blade NON mettere SVG hardcoded.**

Creare il file `.svg` in `Modules/<ModuleName>/resources/svg/` e richiamare con:
```blade
<x-filament::icon icon="meetup-{nome}" class="..." />
```

---

## 5. Localizzazione URL - CRITICAL

**Tutti i link** verso pagine localizzate devono usare:
```php
LaravelLocalization::localizeUrl($path)
```

- **Locale corrente**: `LaravelLocalization::getCurrentLocale()`
- **Language selector**: `LaravelLocalization::getLocalizedURL($code, null, [], true)`
- Rotte pubbliche sotto `/{locale}/...`

---

## 6. Front Office: Folio + Volt + CMS-Driven Pages ONLY

**NEVER use traditional controllers or routes in web.php/api.php for front office.**

### Pattern Corretto

```
1. Create JSON content file:
   config/local/laravelpizza/database/content/pages/{slug}.json

2. Define content_blocks in JSON with view references

3. Folio catch-all route ([slug].blade.php) renders the page

4. Block components in:
   Themes/Meetup/resources/views/components/blocks/
```

---

## 7. XotBase Extension Pattern - CRITICAL

**NEVER extend Filament classes directly. ALWAYS extend XotBase abstracts.**

| Filament Class | Extend Instead |
|----------------|----------------|
| `Filament\Resources\Resource` | `Modules\Xot\Filament\Resources\XotBaseResource` |
| `Filament\Pages\Page` | `Modules\Xot\Filament\Pages\XotBasePage` |
| `Filament\Widgets\Widget` | `Modules\Xot\Filament\Widgets\XotBaseWidget` |
| `Filament\Resources\Pages\ListRecords` | `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` |

---

## 8. One Table, One Migration, One Module

- Each table has exactly ONE authoritative migration
- Schema changes use new migration files: `add_{column}_to_{table}.php`

---

## 9. Documentation Naming

**All .md files MUST be lowercase with hyphens**, except:
- `README.md` (allowed)
- `CHANGELOG.md` (allowed)

---

## Service Provider Pattern - CRITICAL

### ✅ CORRECT

```php
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

### ❌ WRONG

```php
class MeetupServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Meetup';

    public function boot(): void
    {
        parent::boot(); // Only calls parent - REMOVE THIS!
    }
}
```

**Regole**:
- ❌ NEVER add `boot()` or `register()` if you only call parent
- ❌ NEVER duplicate methods already in XotBase
- ✅ ALWAYS include all required properties: `$name`, `$module_dir`, `$module_ns`
- ✅ ALWAYS use `#[Override]` attribute when overriding

---

## 🔗 Link

- [Indice CLAUDE](./claude-split-index.md)
- [critical-rules.md](./critical-rules.md)
- [CLAUDE.md originale](../../CLAUDE.md)
- [Index principale](./index.md)
