# Module Structure

## 🏗️ Project Structure

```
/var/www/_bases/base_ptvx_fila5_mono/
├── laravel/                          # Root Laravel
│   ├── Modules/                      # Laravel Modules
│   │   ├── Xot/                     # Base framework module
│   │   │   ├── app/                 # Xot application code
│   │   │   ├── config/              # Xot configuration
│   │   │   ├── database/            # Xot database
│   │   │   ├── docs/                # Xot documentation
│   │   │   ├── resources/           # Xot resources
│   │   │   └── routes/              # Xot routes
│   │   ├── User/                    # User management module
│   │   ├── Performance/             # Performance module
│   │   └── [OtherModules]/          # Other modules
│   ├── Themes/                       # Themes
│   │   └── One/                     # One theme
│   ├── config/                       # Laravel configuration
│   ├── database/                     # Laravel database
│   ├── resources/                    # Laravel resources
│   └── routes/                       # Laravel routes
├── docs/                             # Root documentation
└── .ai/                              # AI guidelines
    └── guidelines/                   # AI-specific guidelines
```

## 🔧 Module Structure

### Complete Module Layout

```
Modules/NomeModulo/
├── app/                              # Module application code
│   ├── Actions/                      # Actions (Spatie QueableActions)
│   ├── Data/                         # Data Objects (Spatie Laravel Data)
│   ├── Exceptions/                   # Custom exceptions
│   ├── Filament/                     # Filament components
│   │   ├── Actions/                  # Filament actions
│   │   ├── Pages/                    # Filament pages
│   │   ├── Resources/                # Filament resources
│   │   └── Widgets/                  # Filament widgets
│   ├── Http/                         # HTTP layer
│   │   ├── Controllers/              # Controllers
│   │   ├── Livewire/                 # Livewire components
│   │   ├── Middleware/               # Middleware
│   │   ├── Requests/                 # Form requests
│   │   └── Resources/                # API resources
│   ├── Models/                       # Eloquent models
│   ├── Notifications/                # Notifications
│   ├── Observers/                    # Model observers
│   ├── Policies/                     # Authorization policies
│   ├── Providers/                    # Service providers
│   ├── Repositories/                 # Repository pattern
│   ├── Services/                     # Services (if needed)
│   └── Traits/                       # Reusable traits
├── config/                           # Module configuration
├── database/                         # Module database
│   ├── factories/                    # Testing factories
│   ├── migrations/                   # Migrations
│   └── seeders/                      # Seeders
├── docs/                             # Module documentation
├── resources/                        # Module resources
│   ├── lang/                         # Translation files
│   ├── views/                        # Blade views
│   └── assets/                       # Assets (CSS, JS, images)
└── routes/                           # Module routes
```

## 📋 Module Creation Checklist

### For New Modules
- [ ] Directory structure follows the pattern above
- [ ] Namespace follows `Modules\NomeModulo\...` format (no 'app' segment)
- [ ] Service provider extends `XotBaseServiceProvider`
- [ ] Models extend `BaseModel` from the specific module
- [ ] Repository pattern implemented
- [ ] Data objects for DTOs
- [ ] Actions for business logic
- [ ] Policies for authorization
- [ ] Translations complete in all languages
- [ ] Documentation updated in `docs/README.md`

---

**Version**: 2.0 (Refactor DRY + KISS)  
**File**: module-structure.md - Module structure and conventions