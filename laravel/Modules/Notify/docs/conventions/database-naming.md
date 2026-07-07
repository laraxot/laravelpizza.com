# Database Directory Naming Convention

> **Last Updated**: 2026-03-13  
> **Status**: ✅ Standardizzato  
> **Applies To**: Tutti i moduli Laravel

---

## 📋 Rule Summary

**Utilizzare SEMPRE il minuscolo per le directory del database:**

✅ **CORRETTO**:
- `database/factories/`
- `database/migrations/`
- `database/seeders/`

❌ **SBAGLIATO**:
- `database/Factories/`
- `database/Migrations/`
- `database/Seeders/`

---

## 🎯 Why This Matters

### 1. Laravel Convention
Laravel segue la convenzione **snake_case** per tutte le directory del progetto:

```
✅ database/factories/
✅ database/migrations/
✅ database/seeders/
✅ app/Http/Controllers/
✅ app/Models/
```

### 2. PSR-4 Autoloading
I **namespace** possono usare PascalCase, ma i **path** devono essere minuscoli:

```php
// ✅ CORRETTO
namespace Modules\Blog\Database\Factories;
// File: database/factories/ArticleFactory.php

// ❌ SBAGLIATO
namespace Modules\Blog\Database\Factories;
// File: database/Factories/ArticleFactory.php
```

### 3. Case Sensitivity
- **Linux**: Case-sensitive (potrebbe funzionare con maiuscole)
- **Windows/macOS**: Case-insensitive (potrebbe causare confusione)
- **Git**: Mantiene il case esatto
- **Composer**: Si aspetta minuscolo per convenzione

### 4. Consistency
Mantenere coerenza in tutto il progetto:
- Migliore leggibilità
- Minore confusione
- Più facile onboarding nuovi sviluppatori

---

## 📁 Standard Directory Structure

```
Modules/Blog/
├── app/
│   ├── Models/
│   ├── Providers/
│   └── ...
├── config/
├── database/
│   ├── factories/          ✅ Minuscolo
│   │   ├── ArticleFactory.php
│   │   └── CategoryFactory.php
│   ├── migrations/         ✅ Minuscolo
│   │   ├── 2024_01_01_000000_create_articles_table.php
│   │   └── 2024_01_01_000001_create_categories_table.php
│   └── seeders/            ✅ Minuscolo
│       ├── BlogDatabaseSeeder.php
│       └── ArticleSeeder.php
├── docs/
└── ...
```

---

## 🔧 Migration Guide

### If You Have Incorrect Directory Names

#### Step 1: Check Current Structure

```bash
cd laravel/Modules/Blog/database
ls -la
```

#### Step 2: Rename Directories (if needed)

```bash
# Se esistono directory con maiuscole
mv database/Factories database/factories
mv database/Migrations database/migrations
mv database/Seeders database/seeders
```

#### Step 3: Update Composer Autoload

```json
{
    "autoload": {
        "psr-4": {
            "Modules\\Blog\\Database\\Factories\\": "database/factories/",
            "Modules\\Blog\\Database\\Seeders\\": "database/seeders/"
        }
    }
}
```

#### Step 4: Regenerate Autoload

```bash
composer dump-autoload
```

#### Step 5: Update Documentation

Cercare e sostituire nei file markdown:
- `database/Factories/` → `database/factories/`
- `database/Migrations/` → `database/migrations/`
- `database/Seeders/` → `database/seeders/`

---

## 🚨 Common Mistakes

### Mistake 1: Mixed Case

```
❌ database/Factories/
✅ database/factories/
```

### Mistake 2: Inconsistent Naming Across Modules

```
❌ Module A: database/factories/
❌ Module B: database/Factories/
✅ Tutti i moduli: database/factories/
```

### Mistake 3: Documentation References

```markdown
❌ See `database/Factories/UserFactory.php`
✅ See `database/factories/UserFactory.php`
```

---

## 📝 Namespace Conventions

### Factories

```php
// Namespace: PascalCase
namespace Modules\Blog\Database\Factories;

// Path: minuscolo
// File: database/factories/ArticleFactory.php

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    protected $model = \Modules\Blog\Models\Article::class;
    
    public function definition(): array
    {
        return [
            'title' => fake()->title(),
            'content' => fake()->text(),
        ];
    }
}
```

### Seeders

```php
// Namespace: PascalCase
namespace Modules\Blog\Database\Seeders;

// Path: minuscolo
// File: database/seeders/BlogDatabaseSeeder.php

use Illuminate\Database\Seeder;

class BlogDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ArticleSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
```

### Migrations

```php
// Namespace: PascalCase (se usato)
namespace Modules\Blog\Database\Migrations;

// Path: minuscolo
// File: database/migrations/2024_01_01_000000_create_articles_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
}
```

---

## ✅ Checklist

Prima di commitare, verificare:

- [ ] Tutte le directory `database/` usano il minuscolo
- [ ] I namespace usano PascalCase (`Database\Factories`)
- [ ] I file usano PascalCase (`ArticleFactory.php`)
- [ ] La documentazione usa path minuscoli
- [ ] `composer.json` autoload punta a path minuscoli
- [ ] Nessun riferimento a `database/Factories/`, `database/Migrations/`, `database/Seeders/`

---

## 🔍 How to Check

### Grep Search

```bash
# Cerca riferimenti errati nelle docs
grep -r "database/Factories" docs/
grep -r "database/Migrations" docs/
grep -r "database/Seeders" docs/
```

### Find Directories

```bash
# Trova directory con nomi errati
find laravel/Modules -type d -name "Factories"
find laravel/Modules -type d -name "Migrations"
find laravel/Modules -type d -name "Seeders"
```

---

## 📚 References

- [Laravel Directory Structure](https://laravel.com/docs/structure)
- [Laravel Factories](https://laravel.com/docs/eloquent-factories)
- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Laravel Seeders](https://laravel.com/docs/seeding)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)
- [AGENTS.md - Database Naming](../../AGENTS.md)

---

## 🆘 Need Help?

If you find incorrect directory names:

1. **Don't Panic**: It's fixable
2. **Check Impact**: See what references the directory
3. **Rename Carefully**: Use `mv` command
4. **Update References**: Fix docs, config, imports
5. **Test**: Run tests to ensure nothing broke
6. **Document**: Update this doc if you find edge cases

---

**Maintainer**: FixCity Dev Team  
**Contact**: dev @fixcity.example.com
