# FixCity - Architecture Documentation

**Version:** 4.0  
**Date:** 2025-10-01  
**Status:** Production Ready

---

## 📐 System Architecture

### High-Level Overview

```
┌─────────────────────────────────────────────────────────────┐
│                     Presentation Layer                       │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │   Filament   │  │    Themes    │  │     API      │     │
│  │   Admin      │  │   (Sixteen)  │  │   Endpoints  │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    Application Layer                         │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │  Controllers │  │   Actions    │  │   Services   │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                     Domain Layer                             │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │    Models    │  │  Contracts   │  │    Enums     │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                  Infrastructure Layer                        │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │   Database   │  │    Cache     │  │   Storage    │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
└─────────────────────────────────────────────────────────────┘
```

---

## 🏗️ Modular Architecture

### Module Structure

```
Modules/
├── Xot/              # Core framework extensions
├── Tenant/           # Multi-tenancy support
├── User/             # User management & authentication
├── Fixcity/          # Main application logic
├── Blog/             # Content management
├── Cms/              # CMS functionality
├── Geo/              # Geographic services
├── Notify/           # Notification system
├── Media/            # Media management
├── UI/               # UI components
├── Lang/             # Localization
├── Comment/          # Comment system
├── Rating/           # Rating system
├── Activity/         # Activity logging
├── Job/              # Job management
├── Gdpr/             # GDPR compliance
├── Seo/              # SEO optimization
└── AI/               # AI integrations
```

### Module Dependencies

```mermaid
graph TD
    A[Xot] --> B[Tenant]
    A --> C[User]
    A --> D[Lang]
    B --> E[Fixcity]
    C --> E
    E --> F[Blog]
    E --> G[Cms]
    E --> H[Geo]
    E --> I[Notify]
    D --> F
    D --> G
```

---

## 🎯 Design Patterns

### 1. Command Pattern

**Used in:** ArtisanService

```php
// Registry
$registry = new CommandRegistry();
$handler = $registry->findHandler($command);
$result = $handler->handle($moduleName);

// Handlers
class MigrationCommandHandler implements CommandHandlerInterface
{
    public function handle(string $moduleName = ''): string
    {
        // Execute migration logic
    }
}
```

**Benefits:**
- Encapsulates commands as objects
- Easy to add new commands
- Testable in isolation

### 2. Strategy Pattern

**Used in:** TenantService Config Resolution

```php
// Registry
$registry = new ConfigResolverRegistry();
$resolver = $registry->findResolver($key);
$value = $resolver->resolve($key, $default);

// Resolvers
class MorphMapConfigResolver implements ConfigResolverInterface
{
    public function resolve(string $key, $default = null)
    {
        // Resolve morph_map configuration
    }
}
```

**Benefits:**
- Interchangeable algorithms
- Separation of concerns
- Easy to extend

### 3. Repository Pattern

**Used in:** Data Access Layer

```php
interface UserRepositoryInterface
{
    public function find(int $id): ?User;
    public function findByEmail(string $email): ?User;
    public function create(array $data): User;
}
```

### 4. Factory Pattern

**Used in:** Model Creation

```php
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
```

### 5. Observer Pattern

**Used in:** Model Events

```php
class UserObserver
{
    public function created(User $user): void
    {
        // Handle user created event
    }
}
```

---

## 🔐 Security Architecture

### Authentication Flow

```
User Request
    ↓
Middleware (auth, verified)
    ↓
Policy Check
    ↓
Controller Action
    ↓
Response
```

### Multi-Tenancy

```
Request
    ↓
Tenant Identification (subdomain/domain)
    ↓
Tenant Context Setup
    ↓
Database Connection Switch
    ↓
Application Logic
```

### Authorization

- **Policies**: Fine-grained permissions
- **Gates**: Simple authorization checks
- **Middleware**: Route-level protection
- **Spatie Permissions**: Role-based access control

---

## 💾 Data Architecture

### Database Schema

```
┌─────────────┐
│   tenants   │
└─────────────┘
       ↓
┌─────────────┐     ┌─────────────┐
│    users    │────→│    teams    │
└─────────────┘     └─────────────┘
       ↓                   ↓
┌─────────────┐     ┌─────────────┐
│   profiles  │     │team_members │
└─────────────┘     └─────────────┘
```

### Caching Strategy

```
┌─────────────────────────────────────┐
│         Application Cache            │
│  ┌──────────┐  ┌──────────┐        │
│  │  Config  │  │  Routes  │        │
│  └──────────┘  └──────────┘        │
└─────────────────────────────────────┘
              ↓
┌─────────────────────────────────────┐
│          Redis Cache                 │
│  ┌──────────┐  ┌──────────┐        │
│  │ Sessions │  │   Data   │        │
│  └──────────┘  └──────────┘        │
└─────────────────────────────────────┘
```

---

## 🚀 Performance Architecture

### Optimization Strategies

1. **Query Optimization**
   - Eager loading relationships
   - Query result caching
   - Database indexing

2. **Asset Optimization**
   - Vite for bundling
   - Code splitting
   - Lazy loading

3. **Caching Layers**
   - Application cache
   - Redis cache
   - CDN caching

4. **Queue System**
   - Async job processing
   - Email queuing
   - Report generation

---

## 🧪 Testing Architecture

### Test Pyramid

```
        ┌─────────┐
        │   E2E   │  ← Few, slow, expensive
        └─────────┘
      ┌─────────────┐
      │ Integration │  ← Some, medium speed
      └─────────────┘
    ┌─────────────────┐
    │   Unit Tests    │  ← Many, fast, cheap
    └─────────────────┘
```

### Test Organization

```
Tests/
├── Unit/
│   ├── Services/
│   ├── Actions/
│   └── Models/
├── Feature/
│   ├── Auth/
│   ├── Api/
│   └── Admin/
└── Integration/
    ├── Database/
    └── External/
```

---

## 📦 Deployment Architecture

### CI/CD Pipeline

```
Code Push
    ↓
GitHub Actions
    ↓
┌─────────────────────────────────────┐
│  Quality Gates                       │
│  ├── PHPStan (Level 3+)             │
│  ├── Pest Tests (80%+ coverage)     │
│  ├── Complexity Check (<20)         │
│  ├── Code Style (Pint)              │
│  └── Security Audit                 │
└─────────────────────────────────────┘
    ↓
Build & Deploy
    ↓
Production
```

### Environment Structure

```
┌─────────────┐
│   Local     │  ← Development
└─────────────┘
       ↓
┌─────────────┐
│   Staging   │  ← Testing
└─────────────┘
       ↓
┌─────────────┐
│ Production  │  ← Live
└─────────────┘
```

---

## 🔄 Event-Driven Architecture

### Event Flow

```
Action/Command
    ↓
Event Dispatched
    ↓
┌─────────────────────────────────────┐
│  Event Listeners                     │
│  ├── Send Notification              │
│  ├── Log Activity                   │
│  ├── Update Cache                   │
│  └── Trigger Webhook                │
└─────────────────────────────────────┘
```

### Key Events

- `UserRegistered`
- `UserLoggedIn`
- `TenantCreated`
- `ReportGenerated`
- `PaymentProcessed`

---

## 🌐 API Architecture

### RESTful API Structure

```
/api/v1/
├── /auth
│   ├── POST /login
│   ├── POST /register
│   └── POST /logout
├── /users
│   ├── GET /users
│   ├── GET /users/{id}
│   ├── POST /users
│   ├── PUT /users/{id}
│   └── DELETE /users/{id}
└── /reports
    ├── GET /reports
    └── POST /reports
```

### API Response Format

```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "John Doe"
  },
  "meta": {
    "timestamp": "2025-10-01T21:35:00Z",
    "version": "1.0"
  }
}
```

---

## 📊 Monitoring Architecture

### Metrics Collection

```
Application
    ↓
┌─────────────────────────────────────┐
│  Metrics                             │
│  ├── Response Time                  │
│  ├── Error Rate                     │
│  ├── Request Count                  │
│  └── Database Queries               │
└─────────────────────────────────────┘
    ↓
Monitoring Dashboard
```

### Health Checks

- Database connectivity
- Cache availability
- Queue status
- Disk space
- Memory usage

---

## 🔧 Configuration Management

### Configuration Hierarchy

```
1. Environment Variables (.env)
    ↓
2. Config Files (config/)
    ↓
3. Tenant-Specific Config (config/tenant/)
    ↓
4. Runtime Configuration
```

### Config Resolution

```php
TenantService::config('database.default')
    ↓
ConfigResolverRegistry
    ↓
Appropriate Resolver
    ↓
Merged Configuration
```

---

## 📱 Frontend Architecture

### Theme Structure

```
Themes/
├── Sixteen/          # AGID Bootstrap Italia
│   ├── Components/
│   ├── Layouts/
│   ├── Views/
│   └── Assets/
└── TwentyOne/        # Alternative theme
    ├── Components/
    ├── Layouts/
    ├── Views/
    └── Assets/
```

### Component Hierarchy

```
Layout
    ↓
Page Component
    ↓
Section Components
    ↓
UI Components
```

---

## 🎯 Best Practices

### Code Organization

1. **Single Responsibility**: Each class has one job
2. **Dependency Injection**: Use constructor injection
3. **Interface Segregation**: Small, focused interfaces
4. **Open/Closed**: Open for extension, closed for modification

### Performance

1. **Eager Loading**: Prevent N+1 queries
2. **Caching**: Cache expensive operations
3. **Queues**: Defer heavy processing
4. **Indexing**: Proper database indexes

### Security

1. **Input Validation**: Validate all user input
2. **SQL Injection**: Use parameterized queries
3. **XSS Protection**: Escape output
4. **CSRF Protection**: Use CSRF tokens

---

## 📚 References

- [Laravel Architecture Concepts](https://laravel.com/docs/architecture)
- [Domain-Driven Design](https://martinfowler.com/bliki/DomainDrivenDesign.html)
- [Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
- [Design Patterns](https://refactoring.guru/design-patterns)

---

*Document maintained by: Architecture Team*  
*Last Updated: 2025-10-01*  
*Next Review: Quarterly*
