# 🔧 Console Commands FixCity

> **Laravel 11**: Comandi auto-registrati da `app/Console/Commands/`

## 📋 Comandi Essenziali

### Laravel Framework
```bash
# Lista tutti i comandi disponibili
php artisan list

# Help specifico per comando
php artisan help {comando}

# Cache management
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Ottimizzazioni produzione
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Moduli (Nwidart)
```bash
# Lista moduli
php artisan module:list

# Stato moduli
php artisan module:status

# Attiva/disattiva modulo
php artisan module:enable {nome}
php artisan module:disable {nome}

# Genera nuovo modulo
php artisan module:make {nome}
```

### Filament Admin
```bash
# Crea admin user
php artisan make:filament-user

# Crea risorsa Filament
php artisan make:filament-resource {Nome} --generate

# Crea pagina personalizzata
php artisan make:filament-page {Nome}

# Crea widget dashboard
php artisan make:filament-widget {Nome}

# Ottimizza Filament (produzione)
php artisan filament:optimize
```

### Folio (File-based Routing)
```bash
# Crea nuova pagina Folio
php artisan folio:page {nome}
# Esempio: php artisan folio:page 'tickets/create'

# Lista routes Folio
php artisan folio:list

# Crea pagina con parametri
php artisan folio:page 'tickets/[id]'
```

### Livewire & Volt
```bash
# Crea componente Livewire tradizionale  
php artisan make:livewire {Nome}

# Crea componente Volt
php artisan make:volt {nome} --test --pest
# Esempio: php artisan make:volt ticket-form

# Lista componenti Volt
php artisan volt:list
```

## 🎯 Comandi Moduli Specifici

### Database & Schema (Xot Module)
```bash
# Genera modelli da schema JSON
php artisan xot:generate-models-from-schema

# Importa database MDB
php artisan xot:import-mdb {file}

# Esporta schema database
php artisan xot:export-database-schema
```

### Testing (Pest)
```bash
# Esegui tutti i test
php artisan test

# Test specifico file
php artisan test tests/Feature/TicketTest.php

# Test con filtro nome
php artisan test --filter=can_create_ticket

# Test con coverage
php artisan test --coverage

# Crea nuovo test
php artisan make:test {Nome} --pest
php artisan make:test {Nome} --unit --pest
```

### Code Quality
```bash
# Laravel Pint (formattazione)
vendor/bin/pint --dirty

# PHPStan (analisi statica)
vendor/bin/phpstan analyse --level=9

# PHPStan con baseline
vendor/bin/phpstan analyse --generate-baseline
```

## 🚀 Workflow Sviluppo Completo

### Nuovo Feature
```bash
# 1. Crea pagina Folio
php artisan folio:page 'admin/reports'

# 2. Crea componente Volt
php artisan make:volt admin-report-widget --test

# 3. Test
php artisan test --filter=AdminReportTest

# 4. Code quality  
vendor/bin/pint --dirty
vendor/bin/phpstan analyse app/

# 5. Frontend (SEMPRE dopo modifiche CSS/JS)
cd Themes/Sixteen/
npm run build && npm run copy
cd ../../

# 6. Commit
git add .
git commit -m "feat: admin reports widget"
```

### Deploy Process
```bash
# Pre-deploy checks
vendor/bin/pint --test
vendor/bin/phpstan analyse --no-progress
php artisan test

# Frontend build (CRITICO)
cd Themes/Sixteen/
npm run build && npm run copy
cd ../../

# Deploy optimizations
php artisan config:cache
php artisan route:cache  
php artisan view:cache
php artisan filament:optimize

# Database migrations
php artisan migrate --force

# Queue restart
php artisan queue:restart
```

## 🔧 Comandi Personalizzati FixCity

### Template Base
```php
<?php
// app/Console/Commands/FixCityCommand.php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixCityCommand extends Command
{
    protected $signature = 'fixcity:example 
                           {argument : Argomento richiesto}
                           {--option=default : Opzione con default}
                           {--flag : Boolean flag}';

    protected $description = 'Comando esempio per FixCity';

    public function handle(): int
    {
        $this->info('🚀 Esecuzione comando FixCity...');
        
        if ($this->confirm('Continuare con l\'operazione?')) {
            // Business logic
            $this->success('✅ Operazione completata!');
            return Command::SUCCESS;
        }

        $this->warn('⚠️ Operazione annullata dall\'utente');
        return Command::FAILURE;
    }
}
```

## 📊 Debug & Monitoring

### Informazioni Sistema
```bash
# Overview applicazione
php artisan about

# Info ambiente
php artisan env

# Lista routes (include Folio)
php artisan route:list

# Connessione database
php artisan db:show
```

### Performance Analysis
```bash
# Clear all caches
php artisan optimize:clear

# Rebuild optimizations
php artisan optimize

# Health check
php artisan health:check
```

## 📚 Best Practices

### Struttura Comandi (Laravel 11)
```
app/Console/Commands/
├── FixCity/           # Comandi business logic
│   ├── ProcessTickets.php
│   └── GenerateReports.php
├── Maintenance/       # Comandi manutenzione  
│   ├── CleanupFiles.php
│   └── OptimizeImages.php
└── Development/       # Comandi sviluppo
    ├── SeedTestData.php
    └── ResetDemo.php
```

### Convenzioni Naming
```bash
# Gruppo comando con namespace
fixcity:process-tickets
fixcity:generate-reports

# Manutenzione sistema
maintenance:cleanup-files
maintenance:optimize-images

# Sviluppo e test
dev:seed-test-data
dev:reset-demo
```

---

## 🚨 REGOLA CRITICA - Frontend

**MAI dimenticare dopo modifiche CSS/JS**:
```bash
cd Themes/Sixteen/
npm run build
npm run copy
```

Senza questi comandi, le modifiche frontend NON saranno visibili agli utenti!

---

*Comando più importante: `php artisan` - Il cuore dell'ecosistema Laravel* 