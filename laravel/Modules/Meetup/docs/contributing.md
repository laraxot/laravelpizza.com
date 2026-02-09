# 🤝 Contributing to LaravelPizza

Grazie per voler contribuire a LaravelPizza! Questa guida ti aiuterà a contribuire efficacemente al progetto.

---

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Code Standards](#code-standards)
- [Testing Requirements](#testing-requirements)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)
- [Documentation](#documentation)

---

## 🎯 Code of Conduct

- **Sii rispettoso** con altri contributor
- **Sii costruttivo** nelle code review
- **Sii paziente** - siamo tutti qui per imparare
- **Nessuna tolleranza** per abusi, discriminazione, harassment

---

## 🚀 Getting Started

### 1. Fork & Clone

```bash
# Fork su GitHub, poi:
git clone https://github.com/YOUR_USERNAME/laravelpizza.git
cd laravelpizza/laravel
```

### 2. Install Dependencies

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
```

### 3. Create Branch

```bash
git checkout -b feature/your-feature-name
# Or
git checkout -b fix/bug-description
```

---

## 💻 Development Workflow

### Branch Naming Convention

```
feature/add-pizza-reviews       # New feature
fix/order-total-calculation     # Bug fix
docs/update-installation        # Documentation
refactor/optimize-queries       # Code refactoring
test/add-order-tests           # Adding tests
chore/update-dependencies      # Maintenance
```

### Workflow Steps

1. **Create Branch** da `master`
2. **Make Changes** - scrivi codice pulito
3. **Write Tests** - coverage > 80%
4. **Run Quality Checks** (vedi sotto)
5. **Commit** - segui conventions
6. **Push & Create PR**
7. **Code Review** - rispondi ai commenti
8. **Merge** - dopo approval

---

## ⚙️ Code Standards

### ⚠️ CRITICAL RULE - Code Quality

**OGNI file PHP modificato DEVE passare:**

#### 1. PHPStan Level 10 (Obbligatorio)

```bash
vendor/bin/phpstan analyse Modules/Meetup/app/Models/Pizza.php --level=10

# Or whole module
vendor/bin/phpstan analyse Modules/Meetup --level=10
```

**Zero errori tollerati!**

#### 2. PHP Pint (Code Style)

```bash
vendor/bin/pint Modules/Meetup

# Fix specific file
vendor/bin/pint Modules/Meetup/app/Models/Pizza.php
```

#### 3. Pest Tests (Coverage > 80%)

```bash
vendor/bin/pest Modules/Meetup

# With coverage
vendor/bin/pest Modules/Meetup --coverage
```

### PHP Code Style

**Usa Laravel Pint (già configurato):**

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\XotBaseModel;

/**
 * Class Pizza
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property float $price
 */
class Pizza extends XotBaseModel
{
    /** @var array<string> */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }
}
```

### Key Rules

- ✅ **Strict types** sempre: `declare(strict_types=1);`
- ✅ **Type hints** ovunque possibile
- ✅ **PHPDoc** per properties e methods complessi
- ✅ **Namespaces** corretti
- ✅ **Extends XotBaseModel** mai Eloquent direttamente!
- ❌ **No var_dump, dd(), dump()** nel codice committato
- ❌ **No commented code** (usa git invece)

### JavaScript/TypeScript

```javascript
// Use ES6+
const fetchPizzas = async () => {
    const response = await fetch('/api/pizzas');
    return response.json();
};

// Prettier formatted
const config = {
    trailingComma: 'es5',
    tabWidth: 4,
    semi: true,
    singleQuote: true,
};
```

### CSS/Tailwind

```html
<!-- Tailwind utility classes -->
<div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">
        Pizza Margherita
    </h2>
</div>

<!-- NO custom CSS unless absolutely necessary -->
```

---

## 🧪 Testing Requirements

### Minimum Coverage: 80%

Every feature/fix MUST include tests.

### Types of Tests

#### 1. Unit Tests

```php
<?php

// Modules/Meetup/tests/Unit/Models/PizzaTest.php

use Modules\Meetup\Models\Pizza;

it('calculates price with discount correctly', function () {
    $pizza = Pizza::factory()->create(['price' => 10.00]);

    expect($pizza->priceWithDiscount(20))
        ->toBe(8.00);
});
```

#### 2. Feature Tests

```php
<?php

// Modules/Meetup/tests/Feature/OrderTest.php

it('creates order successfully', function () {
    $user = User::factory()->create();
    $pizza = Pizza::factory()->create();

    $response = $this->actingAs($user)
        ->post('/orders', [
            'items' => [
                ['pizza_id' => $pizza->id, 'quantity' => 2],
            ],
            'delivery_type' => 'delivery',
            'address' => 'Via Roma 123',
        ]);

    $response->assertStatus(201);
    expect(Order::count())->toBe(1);
});
```

#### 3. Browser Tests (Dusk)

```php
<?php

// tests/Browser/OrderFlowTest.php

it('completes order flow', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/menu.html')
            ->click('.pizza-card:first-child .add-to-cart')
            ->click('#cart-icon')
            ->assertSee('Carrello')
            ->click('#checkout-button')
            ->type('name', 'Mario Rossi')
            ->type('email', 'mario@test.com')
            ->click('#submit-order')
            ->assertPathIs('/orders/*/tracking');
    });
});
```

### Running Tests

```bash
# All tests
vendor/bin/pest

# Specific module
vendor/bin/pest Modules/Meetup

# With coverage
vendor/bin/pest --coverage --min=80

# Specific test
vendor/bin/pest --filter=PizzaTest
```

---

## 📝 Commit Guidelines

### Commit Message Format

```
<type>(<scope>): <subject>

<body>

<footer>
```

### Types

- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation only
- `style`: Code style (formatting, missing semi-colons, etc)
- `refactor`: Code change that neither fixes a bug nor adds a feature
- `perf`: Performance improvement
- `test`: Adding missing tests
- `chore`: Maintenance (dependencies, config, etc)

### Examples

```bash
# Good commits
git commit -m "feat(orders): add coupon discount functionality"
git commit -m "fix(cart): correct total calculation with taxes"
git commit -m "docs(api): update endpoint documentation"

# Bad commits
git commit -m "fix stuff"
git commit -m "WIP"
git commit -m "updates"
```

### Detailed Example

```
feat(events): add registration waitlist support

- Add waitlist status to EventRegistration model
- Implement automatic promotion when spots available
- Send notification email on waitlist promotion
- Add admin widget to manage waitlist

Closes #123
```

---

## 🔄 Pull Request Process

### Before Creating PR

✅ **Checklist:**

- [ ] Branch aggiornato con `master`
- [ ] PHPStan level 10 passa (zero errori)
- [ ] Pint formatta tutto correttamente
- [ ] Tests scritti (coverage > 80%)
- [ ] Pest tests tutti passano
- [ ] Commit messages seguono conventions
- [ ] Documentation aggiornata se necessario
- [ ] No console.log, dd(), var_dump() nel codice
- [ ] .env.example aggiornato se nuove variabili

### PR Template

```markdown
## Description
Brief description of what this PR does.

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Changes Made
- Added X feature
- Fixed Y bug
- Refactored Z component

## Testing
- [ ] Unit tests added/updated
- [ ] Feature tests added/updated
- [ ] Manual testing completed

## Screenshots (if applicable)
[Add screenshots here]

## Related Issues
Closes #123
Fixes #456

## Checklist
- [ ] Code follows style guidelines
- [ ] PHPStan level 10 passes
- [ ] All tests pass
- [ ] Documentation updated
- [ ] No breaking changes (or clearly documented)
```

### Review Process

1. **Create PR** con descrizione dettagliata
2. **Automated Checks** run (GitHub Actions)
3. **Code Review** da almeno 1 maintainer
4. **Address Comments** - rispondi e correggi
5. **Approval** - quando tutto ok
6. **Merge** - maintainer fa merge

### Review Guidelines

**As Reviewer:**
- ✅ Be constructive and helpful
- ✅ Explain WHY for each comment
- ✅ Suggest improvements, not just criticize
- ✅ Approve when quality standards met

**As Author:**
- ✅ Respond to all comments
- ✅ Don't take it personally
- ✅ Ask for clarification if unclear
- ✅ Push changes after addressing feedback

---

## 📚 Documentation

### When to Update Docs

Update documentation when you:

- Add new feature
- Change existing behavior
- Add new configuration option
- Create new Model/Action/Service
- Change API endpoints
- Modify database schema

### Documentation Locations

```
Modules/Meetup/docs/
├── README.md                 # Update for major changes
├── FEATURES.md               # Add new features here
├── DATABASE_SCHEMA.md        # Update schema changes
├── MODELS_REFERENCE.md       # Document new models
├── API_ENDPOINTS.md          # API changes
└── CHANGELOG.md              # Add to changelog
```

### Documentation Style

```markdown
## Feature Name

Brief description of feature.

### Usage

` ``php
// Code example showing usage
$pizza = Pizza::create([...]);
` ``

### Parameters

- `$title` (string) - Pizza title
- `$price` (float) - Price in EUR

### Returns

Returns `Pizza` model instance.

### Example

` ``php
$margherita = Pizza::create([
    'title' => 'Margherita',
    'price' => 8.50,
]);
` ``
```

---

## 🏗️ Architecture Guidelines

### Laraxot Pattern

**CRITICAL:** Segui sempre il pattern Laraxot!

```php
// ❌ WRONG - Don't extend Filament directly
use Filament\Resources\Resource;

class PizzaResource extends Resource

// ✅ CORRECT - Extend XotBase classes
use Modules\Xot\Filament\Resources\XotBaseResource;

class PizzaResource extends XotBaseResource
```

### Module Structure

```
Modules/Meetup/app/
├── Actions/              # Spatie Queueable Actions (prefer over Services)
├── Datas/                # Spatie Laravel Data DTOs
├── Filament/
│   ├── Resources/        # Extend XotBaseResource
│   └── Widgets/          # Extend XotBaseWidget
├── Models/               # Extend XotBaseModel
├── Services/             # Complex business logic only
└── View/
    └── Components/       # Blade components
```

### Actions over Services

```php
// ✅ Prefer Spatie Actions
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrderAction
{
    use AsAction;

    public function handle(array $data): Order
    {
        // Logic here
    }
}

// Use:
CreateOrderAction::run($data);
```

### Data Transfer Objects

```php
// ✅ Use Spatie Data
use Spatie\LaravelData\Data;

class PizzaData extends Data
{
    public function __construct(
        public string $title,
        public float $price,
        public ?string $description = null,
    ) {}
}
```

---

## 🚫 What NOT to Do

### Never

- ❌ Commit directly to `master`
- ❌ Push code that doesn't pass PHPStan level 10
- ❌ Skip writing tests
- ❌ Use `dd()`, `dump()`, `var_dump()` in committed code
- ❌ Hardcode credentials or secrets
- ❌ Extend Filament classes directly (use XotBase)
- ❌ Create huge PRs (> 500 lines changed)
- ❌ Ignore code review comments

### Avoid

- ⚠️ Complex nested ternaries
- ⚠️ Magic numbers (use constants)
- ⚠️ Long methods (> 20 lines)
- ⚠️ God classes (> 200 lines)
- ⚠️ Commented out code (delete it!)

---

## 🎖️ Recognition

Contributors will be:

- Listed in CONTRIBUTORS.md
- Mentioned in release notes for significant contributions
- Given credit in documentation for major features

---

## 📞 Getting Help

- **Questions:** Open a Discussion on GitHub
- **Bugs:** Open an Issue with reproduction steps
- **Feature Ideas:** Open an Issue with "Feature Request" label
- **Documentation:** Check `/Modules/Meetup/docs/`

---

## 🔗 Useful Links

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Spatie Packages](https://spatie.be/open-source)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Pest PHP Documentation](https://pestphp.com/docs)

---

**Grazie per contribuire a LaravelPizza! 🍕**

*Happy Coding!*

---

