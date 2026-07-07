# 📏 Coding Conventions

> **Last Updated**: 2026-03-13  
> **Status**: ✅ Active  
> **Applies To**: All modules and themes

---

## 📋 Table of Contents

1. [Directory Naming](#directory-naming)
2. [File Naming](#file-naming)
3. [Code Style](#code-style)
4. [Git Conventions](#git-conventions)
5. [Documentation](#documentation)

---

## 📁 Directory Naming

### Database Directories

**Rule**: Always use **lowercase** for database directories.

✅ **CORRECT**:
```
database/factories/
database/migrations/
database/seeders/
```

❌ **WRONG**:
```
database/Factories/
database/Migrations/
database/Seeders/
```

**Why**:
- Laravel convention is snake_case for directories
- PSR-4: Namespaces can be PascalCase, paths must be lowercase
- Linux is case-sensitive

**Reference**: [Database Naming Convention](database-naming.md)

---

### Module Directories

**Standard Structure**:
```
Modules/ModuleName/
├── app/
│   ├── Actions/
│   ├── Models/
│   ├── Providers/
│   └── ...
├── config/
├── database/
│   ├── factories/      # lowercase
│   ├── migrations/     # lowercase
│   └── seeders/        # lowercase
├── docs/
├── resources/
├── routes/
├── tests/
└── ...
```

---

## 📄 File Naming

### PHP Files

**Classes**: PascalCase
```
✅ ArticleFactory.php
✅ CreateArticlesTable.php
✅ ArticleSeeder.php
❌ articleFactory.php
❌ article_factory.php
```

**Migrations**: snake_case with timestamp
```
✅ 2024_01_01_000000_create_articles_table.php
✅ 2024_01_01_000001_add_status_to_articles_table.php
❌ CreateArticlesTable.php
❌ 2024-01-01_create_articles.php
```

**Tests**: PascalCase with Test suffix
```
✅ ArticleTest.php
✅ ArticleFactoryTest.php
❌ article_test.php
❌ ArticleTests.php
```

---

### Documentation Files

**Markdown**: lowercase with hyphens
```
✅ database-naming.md
✅ getting-started.md
✅ best-practices.md
❌ DatabaseNaming.md
❌ database_naming.md
❌ DATABASE-NAMING.md
```

---

## 💻 Code Style

### PHP

**Strict Types**: Always declare at top
```php
<?php

declare(strict_types=1);

namespace Modules\Blog\Models;
```

**Type Hints**: Required for all methods
```php
✅ public function getTitle(): string
✅ public function setUser(User $user): void
❌ public function getTitle()
❌ public function setUser($user)
```

**Return Types**: Always specify
```php
✅ public function getData(): array
✅ public function find(int $id): ?Model
❌ public function getData()
❌ public function find($id)
```

---

### Naming Conventions

**Classes**: PascalCase
```php
✅ class ArticleFactory
✅ class CreateArticleAction
❌ class articleFactory
❌ class Article_factory
```

**Methods**: camelCase
```php
✅ public function getArticleTitle()
✅ public function createUser()
❌ public function GetArticleTitle()
❌ public function get_article_title()
```

**Variables**: camelCase, descriptive
```php
✅ $articleTitle
✅ $userCount
❌ $ArticleTitle
❌ $article_title
❌ $at
```

**Constants**: UPPER_SNAKE_CASE
```php
✅ const MAX_ARTICLES = 100;
✅ const DEFAULT_STATUS = 'draft';
❌ const MaxArticles = 100;
❌ const max_articles = 100;
```

---

## 🔧 Git Conventions

### Commit Messages

**Format**: type(scope): description

**Types**:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes (formatting)
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

**Examples**:
```
✅ feat(blog): add article search functionality
✅ fix(user): resolve login timeout issue
✅ docs(readme): update installation instructions
✅ refactor(xot): simplify base model logic
✅ test(blog): add unit tests for Article model
✅ chore(deps): update Laravel to v12.0
```

**NOT**:
```
❌ Fixed bug
❌ Update file
❌ WIP
❌ stuff
```

---

### Branch Naming

**Format**: type/description

**Examples**:
```
✅ feature/article-search
✅ bugfix/login-timeout
✅ docs/readme-update
✅ refactor/base-model
✅ test/article-tests
```

**NOT**:
```
❌ my-branch
❌ fix
❌ test
❌ new-stuff
```

---

### Pull Requests

**Title**: Same format as commit messages

**Description Template**:
```markdown
## Description
[Brief description of changes]

## Type of Change
- [ ] 🐛 Bug fix
- [ ] ✨ New feature
- [ ] 📝 Documentation
- [ ] ♻️ Refactoring
- [ ] ✅ Tests
- [ ] ⚙️ Chore

## Testing
[How to test this change]

## Checklist
- [ ] Code follows style guidelines
- [ ] Tests added/updated
- [ ] Documentation updated
- [ ] No breaking changes
```

---

## 📚 Documentation

### File Structure

Every module should have:
```
Modules/ModuleName/
├── README.md              # Module overview
├── docs/
│   ├── README.md         # Docs index
│   ├── architecture/     # Architecture docs
│   ├── conventions/      # Module conventions
│   ├── guides/           # How-to guides
│   └── api/              # API documentation
```

### Markdown Standards

**Headers**: Use ATX style (#)
```markdown
✅ # H1 Header
✅ ## H2 Header
✅ ### H3 Header
❌ H1 Header
❌ H1 Header
   ==========
```

**Code Blocks**: Always specify language
````markdown
✅ ```php
   echo "Hello";
   ```

❌ ```
   echo "Hello";
   ```
````

**Links**: Use relative paths for internal
```markdown
✅ [See Guide](./guides/setup.md)
✅ [Architecture](../architecture/overview.md)
❌ [Guide](/var/www/.../guide.md)
```

---

## 🎯 Quality Checks

### Before Committing

```bash
# Run linters
npm run quality
composer pint

# Run tests
php artisan test

# Check documentation
npm run quality:markdownlint

# Verify naming
find . -name "*[A-Z]*" -type d | grep -v node_modules | grep -v vendor
```

### CI/CD Checks

- ✅ PHPStan Level 10
- ✅ PHPUnit tests passing
- ✅ Code coverage >90%
- ✅ Markdown lint passing
- ✅ No hardcoded paths
- ✅ No .gitattributes files

---

## 📖 References

- [Laravel Coding Standards](https://laravel.com/docs/contributions#coding-style)
- [PSR-12](https://www.php-fig.org/psr/psr-12/)
- [PSR-4](https://www.php-fig.org/psr/psr-4/)
- [Conventional Commits](https://www.conventionalcommits.org/)
- [GitHub Markdown Guide](https://docs.github.com/en/get-started/writing-on-github)

---

**Maintainer**: @marco76tv  
**Contact**: dev @fixcity.example.com  
**Last Review**: 2026-03-13
