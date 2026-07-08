# 🔧 Development Tasks - Task e Script di Sviluppo

> **FONDAMENTALE**: Task e script standardizzati per sviluppo efficiente e consistente in PTVX.

## 🚀 Script di Sviluppo

### Script Location Policy
**MAI** creare script in `/laravel/`. **SEMPRE** in `../bashscripts/`.

```
../bashscripts/
├── setup/
│   ├── install.sh                 # Installazione completa
│   ├── configure.sh               # Configurazione ambiente
│   └── permissions.sh             # Setup permessi
├── development/
│   ├── quality-check.sh           # Controlli qualità
│   ├── test.sh                    # Esecuzione test
│   ├── build.sh                   # Build applicazione
│   └── deploy.sh                  # Deploy staging
├── maintenance/
│   ├── backup.sh                  # Backup database
│   ├── cleanup.sh                 # Cleanup files
│   └── optimize.sh                # Ottimizzazione
└── modules/
    ├── create-module.sh           # Creazione modulo
    ├── update-module.sh           # Aggiornamento modulo
    └── test-module.sh             # Test modulo
```

---

## 🛠️ Script Principali

### 1. quality-check.sh - Controlli Qualità

```bash
#!/bin/bash
# ../bashscripts/quality-check.sh

set -e

echo "🔍 Running PTVX Quality Checks..."

echo "📊 PHPStan Level 10 Analysis..."
./vendor/bin/phpstan analyze --memory-limit=2G --no-progress

echo "🎨 Code Formatting with Pint..."
./vendor/bin/pint

echo "🧪 Running Tests..."
php artisan test --parallel

echo "📈 PHPInsights Analysis..."
./vendor/bin/phpinsights analyse --no-interaction --min-quality=80

echo "📝 PHPMD Analysis..."
./vendor/bin/phpmd . text phpmd-ruleset.xml

echo "✅ All quality checks passed!"
```

### 2. setup-module.sh - Setup Nuovo Modulo

```bash
#!/bin/bash
# ../bashscripts/setup-module.sh

MODULE_NAME=$1

if [ -z "$MODULE_NAME" ]; then
    echo "❌ Usage: $0 <ModuleName>"
    exit 1
fi

echo "🏗️ Setting up module: $MODULE_NAME"

# Create module structure
php artisan module:make $MODULE_NAME

# Create directories
mkdir -p "Modules/$MODULE_NAME/app/Actions"
mkdir -p "Modules/$MODULE_NAME/app/Data"
mkdir -p "Modules/$MODULE_NAME/app/Filament/Resources"
mkdir -p "Modules/$MODULE_NAME/docs"
mkdir -p "Modules/$MODULE_NAME/tests/Feature"
mkdir -p "Modules/$MODULE_NAME/tests/Unit"

# Create basic files
cat > "Modules/$MODULE_NAME/docs/README.md" << EOF
# $MODULE_NAME Module

## Overview
Description of the $MODULE_NAME module.

## Installation
\`\`\`bash
php artisan module:enable $MODULE_NAME
\`\`\`

## Usage
Basic usage examples.

EOF

echo "✅ Module $MODULE_NAME setup completed!"
echo "📝 Don't forget to:"
echo "   - Update module.json"
echo "   - Add service provider"
echo "   - Write documentation"
```

### 3. build-pdf-assets.sh - Build PDF Assets

```bash
#!/bin/bash
# ../bashscripts/build-pdf-assets.sh

echo "📄 Building PDF assets for HTML2PDF..."

# Create PDF assets directory
mkdir -p public/pdf-assets/images
mkdir -p public/pdf-assets/fonts

# Copy common assets
cp assets/pdf/logo.png public/pdf-assets/images/
cp assets/pdf/signature.png public/pdf-assets/images/

# Generate base64 encoded images for better performance
for image in public/pdf-assets/images/*; do
    if [ -f "$image" ]; then
        filename=$(basename "$image")
        base64=$(base64 -w 0 "$image")
        echo "data:image/png;base64,$base64" > "public/pdf-assets/images/${filename%.*}.b64"
    fi
done

echo "✅ PDF assets built successfully!"
```

### 4. test-module.sh - Test Modulo Specifico

```bash
#!/bin/bash
# ../bashscripts/test-module.sh

MODULE_NAME=$1

if [ -z "$MODULE_NAME" ]; then
    echo "❌ Usage: $0 <ModuleName>"
    exit 1
fi

echo "🧪 Testing module: $MODULE_NAME"

# Run module-specific tests
php artisan test --filter="Modules\\\\$MODULE_NAME"

# PHPStan module analysis
./vendor/bin/phpstan analyze "Modules/$MODULE_NAME" --level=10

# Check module documentation
if [ ! -f "Modules/$MODULE_NAME/docs/README.md" ]; then
    echo "⚠️ Warning: Missing docs/README.md"
fi

echo "✅ Module $MODULE_NAME tests completed!"
```

---

## 🔄 Task di Sviluppo Comuni

### 1. Creazione Nuova Feature

```bash
# 1. Create feature branch
git checkout -b feature/new-feature

# 2. Create/update module
../bashscripts/setup-module.sh MyFeature

# 3. Generate components
php artisan module:make-model MyModel MyFeature -m -f
php artisan module:make-action CreateMyModelAction MyFeature
php artisan module:make-data MyData MyFeature
php artisan module:make-filament-resource MyResource MyFeature

# 4. Run quality checks
../bashscripts/quality-check.sh

# 5. Run tests
../bashscripts/test-module.sh MyFeature

# 6. Commit changes
git add .
git commit -m "feat: add MyFeature module with basic CRUD"

# 7. Push and create PR
git push origin feature/new-feature
```

### 2. Aggiornamento Modulo Esistente

```bash
# 1. Checkout module branch
git checkout -b update/module-update

# 2. Update module
../bashscripts/update-module.sh MyModule

# 3. Run tests
../bashscripts/test-module.sh MyModule

# 4. Quality checks
../bashscripts/quality-check.sh

# 5. Update documentation
# Edit docs/ files

# 6. Commit
git add .
git commit -m "update: improve MyModule with new features"
```

### 3. Fix di Bug

```bash
# 1. Create bugfix branch
git checkout -b fix/bug-description

# 2. Identify and fix issue
# Edit files...

# 3. Write test for bug
# Add test case

# 4. Verify fix
../bashscripts/test-module.sh RelatedModule

# 5. Quality checks
../bashscripts/quality-check.sh

# 6. Commit
git add .
git commit -m "fix: resolve issue with bug description"
```

---

## 📋 Task Automation con Makefile

```makefile
# Makefile
.PHONY: test quality build deploy clean

# Run all tests
test:
	php artisan test --parallel

# Run quality checks
quality:
	./vendor/bin/phpstan analyze
	./vendor/bin/pint
	./vendor/bin/phpinsights analyse

# Build application
build: quality test
	composer install --no-dev --optimize-autoloader
	npm run build
	php artisan config:cache
	php artisan route:cache
	php artisan view:cache

# Deploy to staging
deploy: build
	php artisan deploy:staging

# Clean up
clean:
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear
	php artisan cache:clear
	composer clear-cache

# Setup new module
module:
	@if [ -z "$(NAME)" ]; then echo "Usage: make module NAME=ModuleName"; exit 1; fi
	../bashscripts/setup-module.sh $(NAME)

# Test specific module
test-module:
	@if [ -z "$(NAME)" ]; then echo "Usage: make test-module NAME=ModuleName"; exit 1; fi
	../bashscripts/test-module.sh $(NAME)
```

---

## 🚀 Deployment Tasks

### 1. Staging Deployment

```bash
#!/bin/bash
# ../bashscripts/deploy-staging.sh

set -e

echo "🚀 Deploying to staging..."

# Pull latest changes
git pull origin develop

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Clear caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Run migrations
php artisan migrate --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Warm up caches
curl -s http://staging.ptvx.local > /dev/null

echo "✅ Staging deployment completed!"
```

### 2. Production Deployment

```bash
#!/bin/bash
# ../bashscripts/deploy-production.sh

set -e

ENVIRONMENT=$1

if [ -z "$ENVIRONMENT" ]; then
    echo "❌ Usage: $0 <environment>"
    exit 1
fi

echo "🚀 Deploying to $ENVIRONMENT..."

# Maintenance mode
php artisan down --message="Deploying new version..."

# Backup database
../bashscripts/maintenance/backup.sh

# Pull latest changes
git pull origin main

# Install dependencies
composer install --no-dev --optimize-autoloader
npm ci && npm run build

# Clear and rebuild caches
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Run migrations
php artisan migrate --force

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart services
sudo supervisorctl restart laravel-worker*

# Bring application back up
php artisan up

echo "✅ Production deployment completed!"
```

---

## 🔧 Development Environment Setup

### 1. Initial Setup

```bash
#!/bin/bash
# ../bashscripts/setup/initial-setup.sh

echo "🏗️ Initial PTVX Development Setup"

# Clone repository
git clone git@github.com:provtv/base_ptv_fila5_mono.git laravel
cd laravel

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup database
php artisan migrate:fresh --seed

# Create storage links
php artisan storage:link

# Install modules
php artisan module:enable User Performance Gdpr Activity

# Optimize for development
composer dump-autoload
php artisan optimize:clear

echo "✅ Initial setup completed!"
echo "📝 Next steps:"
echo "   - Configure .env file"
echo "   - Run npm run dev"
echo "   - Visit http://localhost:8000"
```

### 2. Daily Development Workflow

```bash
#!/bin/bash
# ../bashscripts/development/daily-start.sh

echo "🌅 Starting daily development..."

# Pull latest changes
git pull origin develop

# Update dependencies
composer update
npm update

# Clear caches
php artisan optimize:clear

# Start services
npm run dev &
php artisan serve &

# Run quick tests
php artisan test --testsuite=Feature --parallel

echo "✅ Development environment ready!"
echo "🌐 Application: http://localhost:8000"
echo "📊 PHPMyAdmin: http://localhost:8080"
```

---

## 📊 Performance Monitoring

### 1. Performance Test Script

```bash
#!/bin/bash
# ../bashscripts/maintenance/performance-test.sh

echo "📊 Running performance tests..."

# Test application response time
echo "🕐 Testing response times..."
for i in {1..10}; do
    response_time=$(curl -o /dev/null -s -w '%{time_total}' http://localhost:8000)
    echo "Request $i: ${response_time}s"
done

# Test database queries
echo "🗄️ Testing database performance..."
php artisan tinker --execute="
    \$start = microtime(true);
    \$users = App\Models\User::count();
    \$end = microtime(true);
    echo 'User count query: ' . (\$end - \$start) . 's' . PHP_EOL;
"

# Test PDF generation
echo "📄 Testing PDF generation..."
php artisan tinker --execute="
    \$start = microtime(true);
    \$pdf = app(\Modules\Xot\Actions\Pdf\ContentPdfAction::class)->execute('test', ['content' => 'Test']);
    \$end = microtime(true);
    echo 'PDF generation: ' . (\$end - \$start) . 's' . PHP_EOL;
"

echo "✅ Performance tests completed!"
```

---

## 📋 Development Checklist

### Before Commit
- [ ] Code follows PSR-12 standards
- [ ] PHPStan Level 10 passes
- [ ] Tests pass with adequate coverage
- [ ] Documentation updated
- [ ] No hardcoded secrets
- [ ] Performance considered

### Before Deploy
- [ ] All tests pass
- [ ] Database migrations tested
- [ ] Caches cleared and rebuilt
- [ ] Assets optimized
- [ ] Backup performed
- [ ] Rollback plan ready

### Module Development
- [ ] Module structure correct
- [ ] Service provider registered
- [ ] Dependencies declared
- [ ] Documentation complete
- [ ] Tests comprehensive
- [ ] Quality checks pass

---

## 📚 Riferimenti Correlati

- [Code Quality](code-quality.md) - Tools e standard qualità
- [Module Structure](module-structure.md) - Architettura moduli
- [Architecture Rules](architecture-rules.md) - Pattern architetturali
- [Core Rules](core.md) - Regole fondamentali

---

**Versione**: 3.0 (Refactor DRY + KISS)  
**Priorità**: 📡 MEDIA - Automazione sviluppo  
**Aggiornamento**: Dicembre 2025

> **💡 Principio**: "Automating repetitive tasks frees developers to focus on creative problem-solving."