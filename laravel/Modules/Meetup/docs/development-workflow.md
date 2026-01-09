# Laravel Pizza Development Workflow & Best Practices

## Development Workflow

### 1. Setting Up the Development Environment

#### Prerequisites
- PHP 8.2+
- Composer
- Node.js and npm
- MySQL/PostgreSQL
- Redis (for caching and queues)

#### Initial Setup
```bash
# Clone the repository
git clone <repository-url>
cd /var/www/_bases/base_laravelpizza/laravel

# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Create environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database settings in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravelpizza
DB_USERNAME=root
DB_PASSWORD=

# Run database migrations
php artisan migrate

# Build frontend assets
npm run build
```

#### Regola generale per i comandi npm in un'app modulare con temi

- Esegui `npm install`, `npm run dev`, `npm run build` e script come `npm run copy` **nella root del progetto frontend a cui appartengono** (cioè nella cartella che contiene il relativo `package.json` e `vite.config.*`).
- Per gli asset globali dell'app Laravel la root è `/var/www/_bases/base_laravelpizza/laravel` (qui vive il `package.json` principale).
- Per il tema pubblico **Meetup** la root del frontend è `/var/www/_bases/base_laravelpizza/laravel/Themes/Meetup` (qui vanno eseguiti `npm install`, `npm run build`, `npm run copy` quando lavori sugli assets del tema).

#### Development Server
```bash
# Start development server with all services
composer run dev

# Or start individual services
php artisan serve
npm run dev
php artisan queue:listen
```

### 2. Module Development

#### Creating a New Module
```bash
# Use the module generator
php artisan module:make ModuleName

# The command creates the standard module structure
```

#### Module Development Guidelines
1. **Follow the standard module structure**
2. **Use actions for business logic**
3. **Implement proper error handling**
4. **Write tests for all functionality**
5. **Document public APIs**

#### Module Dependencies
- Modules should declare dependencies in their `module.json`
- Use service providers for module registration
- Follow the module loading order in `modules_statuses.json`

### 3. Code Standards

#### PHP Coding Standards
- Follow PSR-4 autoloading standards
- Use strict typing (`declare(strict_types=1)`)
- Type hint all method parameters and return values
- Follow SOLID principles
- Use dependency injection

#### Naming Conventions
- **Classes**: PascalCase (e.g., `UserController`)
- **Methods**: camelCase (e.g., `getUserData()`)
- **Variables**: camelCase (e.g., `$userData`)
- **Constants**: UPPER_SNAKE_CASE (e.g., `MAX_RETRIES`)
- **Files**: PascalCase for classes, snake_case for config

#### Code Organization
- **Actions**: For business logic operations
- **Models**: For data access and relationships
- **Controllers**: For request handling (minimal logic)
- **Services**: For complex business operations
- **Components**: For reusable UI elements

## Best Practices

### 1. Action Pattern Usage
```php
// Good: Business logic in action class
class CreateUserAction
{
    public function execute(array $data): User
    {
        // Validation and business logic
        return User::create($data);
    }
}

// In controller
public function store(StoreUserRequest $request)
{
    $user = app(CreateUserAction::class)->execute($request->validated());
    return response()->json($user);
}
```

### 2. Data Transfer Objects
```php
// Use Spatie Laravel Data for structured data
#[\Strict]
class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $phone = null,
    ) {}
}
```

### 3. Error Handling
```php
// Use custom exceptions with meaningful messages
class UserNotFoundException extends Exception
{
    public function __construct($id)
    {
        parent::__construct("User with ID {$id} not found.");
    }
}

// Handle exceptions in actions
try {
    $user = User::findOrFail($id);
} catch (ModelNotFoundException $e) {
    throw new UserNotFoundException($id);
}
```

### 4. Database Best Practices
- Use migrations for database changes
- Implement proper indexing
- Use eager loading to prevent N+1 queries
- Use database transactions for related operations
- Follow Laravel's naming conventions for tables and columns

### 5. Testing Guidelines
```php
// Feature tests for user stories
it('allows user to register', function () {
    $response = $this->post('/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('users', [
        'email' => 'john@example.com',
    ]);
});

// Unit tests for actions
it('creates user with valid data', function () {
    $action = new CreateUserAction();
    $user = $action->execute([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => bcrypt('password'),
    ]);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('John Doe');
});
```

## Development Tools

### 1. PHPStan Configuration
The project uses PHPStan for static analysis:
```bash
# Run PHPStan at level 8 (high strictness)
./vendor/bin/phpstan analyse --level=8

# Configuration file: phpstan.neon
```

### 2. Code Quality Tools
- **PHP-CS-Fixer**: Code style consistency
- **PHPMD**: Code mess detection
- **PHPInsights**: Code quality analysis
- **Pint**: Laravel-specific code styling

### 3. MCP Integration
The project supports Model Context Protocol for AI-assisted development:
- Filesystem access for file operations
- Database access for data operations
- Git integration for version control
- Artisan command access

## Git Workflow

### 1. Branch Naming Convention
```
feature/module-name-short-description
bugfix/module-name-issue-description
hotfix/security-patch-name
```

### 2. Commit Messages
Follow conventional commits:
```
feat: Add new user registration functionality
fix: Resolve issue with email validation
refactor: Update User model to use traits
docs: Update API documentation
test: Add tests for user authentication
```

### 3. Pull Request Process
1. Create a feature branch
2. Implement changes with tests
3. Run all tests and code quality checks
4. Create pull request with description
5. Request code review
6. Address feedback
7. Merge after approval

## Security Considerations

### 1. Input Validation
- Always validate and sanitize user input
- Use form request validation
- Implement proper authorization checks
- Use Laravel's built-in protection against common attacks

### 2. Authentication & Authorization
- Use Laravel Fortify for authentication
- Implement proper policy checks
- Use gates for complex authorization logic
- Implement rate limiting

### 3. Data Protection
- Encrypt sensitive data
- Use HTTPS in production
- Implement proper session management
- Follow GDPR compliance guidelines

## Performance Optimization

### 1. Caching Strategies
- Use Redis for session and cache storage
- Implement model caching
- Use Eloquent's `remember()` method
- Cache expensive operations

### 2. Database Optimization
- Add proper indexes
- Use eager loading
- Implement pagination
- Use database query optimization

### 3. Asset Optimization
- Use Vite for asset building
- Implement asset versioning
- Use CDN for static assets
- Optimize images

## Deployment Process

### 1. Environment Configuration
- Set proper environment variables
- Configure database connections
- Set up queue workers
- Configure caching

### 2. Deployment Steps
```bash
# Pull latest code
git pull origin main

# Install/update dependencies
composer install --optimize-autoloader --no-dev
npm install --production

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets
npm run build
```

## Troubleshooting Common Issues

### 1. Module Loading Issues
- Check `modules_statuses.json` for proper activation
- Clear module cache: `php artisan module:clear-cached`
- Verify module.json configuration

### 2. Database Issues
- Run migrations: `php artisan migrate`
- Check database connection settings
- Clear database cache: `php artisan cache:clear`

### 3. Asset Issues
- Rebuild assets: `npm run build`
- Clear asset cache: `php artisan view:clear`
- Check Vite configuration

Following these guidelines ensures consistent, maintainable, and high-quality code across the Laravel Pizza project.
