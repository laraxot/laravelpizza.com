# Contributing to FixCity

First off, thank you for considering contributing to FixCity! 🎉

## 📋 Table of Contents

- [Code of Conduct](#code-of-conduct)
- [Getting Started](#getting-started)
- [Development Workflow](#development-workflow)
- [Code Quality Standards](#code-quality-standards)
- [Testing Requirements](#testing-requirements)
- [Commit Guidelines](#commit-guidelines)
- [Pull Request Process](#pull-request-process)

---

## 📜 Code of Conduct

This project adheres to a Code of Conduct that all contributors are expected to follow. Please read [CODE_OF_CONDUCT.md](CODE_OF_CONDUCT.md) before contributing.

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+

### Installation

```bash
# Clone the repository
git clone https://github.com/your-org/fixcity.git
cd fixcity/laravel

# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Run migrations
php artisan migrate

# Install Husky hooks
npm run prepare
```

---

## 💻 Development Workflow

### 1. Create a Branch

```bash
git checkout -b feature/your-feature-name
# or
git checkout -b bugfix/your-bugfix-name
```

### 2. Make Your Changes

- Follow the [Code Quality Standards](#code-quality-standards)
- Write tests for new features
- Update documentation as needed

### 3. Run Quality Checks

```bash
# Run PHPStan
./vendor/bin/phpstan analyse --level=3

# Run tests
./vendor/bin/pest

# Run code style fixer
./vendor/bin/pint

# Run complexity analysis
php analyze_complexity.php
```

### 4. Commit Your Changes

```bash
git add .
git commit -m "feat: add amazing feature"
```

### 5. Push and Create PR

```bash
git push origin feature/your-feature-name
```

Then create a Pull Request on GitHub.

---

## ✅ Code Quality Standards

### Cyclomatic Complexity

- **Maximum complexity per method: 10**
- Methods with complexity > 10 must be refactored
- Use design patterns to reduce complexity

### PHPStan

- **Minimum level: 3**
- All code must pass PHPStan analysis
- No errors allowed in CI/CD pipeline

### Code Style

- Follow PSR-12 coding standards
- Use Laravel Pint for automatic formatting
- Run `./vendor/bin/pint` before committing

### Architecture

- Follow SOLID principles
- Use design patterns appropriately
- Maintain separation of concerns
- Extend XotBase classes (see [LARAXOT_FRAMEWORK_RULES.md](.windsurf/rules/LARAXOT_FRAMEWORK_RULES.md))

---

## 🧪 Testing Requirements

### Test Coverage

- **Minimum coverage: 80%**
- All new features must have tests
- All bug fixes must have regression tests

### Test Types

1. **Unit Tests**
   - Test individual methods and classes
   - Mock dependencies
   - Fast execution

2. **Integration Tests**
   - Test component interactions
   - Use real dependencies when appropriate
   - Test complete workflows

3. **Feature Tests**
   - Test user-facing features
   - Test HTTP requests and responses
   - Test database interactions

### Writing Tests

```php
<?php

declare(strict_types=1);

use App\Services\YourService;

test('your service does something', function (): void {
    $service = new YourService();
    
    $result = $service->doSomething();
    
    expect($result)->toBe('expected_value');
});

test('your service handles errors', function (): void {
    $service = new YourService();
    
    expect(fn() => $service->doSomethingInvalid())
        ->toThrow(InvalidArgumentException::class);
});
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
- `docs`: Documentation changes
- `style`: Code style changes (formatting, etc.)
- `refactor`: Code refactoring
- `test`: Adding or updating tests
- `chore`: Maintenance tasks

### Examples

```bash
feat(user): add social login functionality

Implemented OAuth2 login with Google and Facebook providers.
Added user profile sync from social providers.

Closes #123
```

```bash
fix(tenant): resolve config resolution bug

Fixed issue where tenant-specific config was not being loaded
correctly in multi-tenant environments.

Fixes #456
```

---

## 🔄 Pull Request Process

### Before Submitting

1. ✅ All tests pass
2. ✅ PHPStan analysis passes
3. ✅ Code style is correct
4. ✅ Complexity is within limits
5. ✅ Documentation is updated
6. ✅ Changelog is updated

### PR Template

```markdown
## Description
Brief description of changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] Unit tests added/updated
- [ ] Integration tests added/updated
- [ ] Manual testing performed

## Checklist
- [ ] Code follows project standards
- [ ] Self-review completed
- [ ] Comments added for complex code
- [ ] Documentation updated
- [ ] No new warnings generated
- [ ] Tests pass locally
- [ ] PHPStan passes
- [ ] Complexity within limits
```

### Review Process

1. **Automated Checks**: CI/CD pipeline runs automatically
2. **Code Review**: At least one approval required
3. **Quality Gate**: All checks must pass
4. **Merge**: Squash and merge to main branch

---

## 🎯 Best Practices

### Design Patterns

Use appropriate design patterns to reduce complexity:

- **Command Pattern**: For command handlers
- **Strategy Pattern**: For interchangeable algorithms
- **Factory Pattern**: For object creation
- **Repository Pattern**: For data access
- **Service Pattern**: For business logic

### Refactoring

When refactoring complex code:

1. Write tests first (if not present)
2. Extract methods to reduce complexity
3. Use design patterns
4. Validate with PHPStan
5. Ensure all tests pass
6. Update documentation

### Documentation

- Add PHPDoc blocks to all public methods
- Document complex algorithms
- Update README when adding features
- Keep changelog up to date

---

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Pest Documentation](https://pestphp.com/docs)
- [Refactoring Guru](https://refactoring.guru/)

---

## 🤝 Getting Help

- **Questions**: Open a discussion on GitHub
- **Bugs**: Open an issue with reproduction steps
- **Features**: Open an issue with detailed description

---

## 📄 License

By contributing, you agree that your contributions will be licensed under the same license as the project.

---

**Thank you for contributing to FixCity! 🚀**
