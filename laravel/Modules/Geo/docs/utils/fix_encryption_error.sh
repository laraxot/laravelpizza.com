#!/bin/bash

# Script per risolvere l'errore di crittografia Laravel
# Errore: "Unsupported cipher or incorrect key length"

set -e  # Exit on error

echo "🔧 Risoluzione Errore Crittografia Laravel"
echo "=========================================="

# Colori per output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Funzione per stampare messaggi colorati
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Verifica se siamo nella directory corretta
if [ ! -f "artisan" ]; then
    print_error "File artisan non trovato. Assicurati di essere nella directory Laravel."
    exit 1
fi

print_status "Verifica ambiente Laravel..."

# 1. Verifica file .env
print_status "Verifica file .env..."
if [ ! -f ".env" ]; then
    print_warning "File .env non trovato. Creazione da .env.example..."
    if [ -f ".env.example" ]; then
        cp .env.example .env
        print_success "File .env creato da .env.example"
    else
        print_error "File .env.example non trovato. Creazione file .env vuoto..."
        touch .env
        echo "APP_NAME=Laravel" >> .env
        echo "APP_ENV=local" >> .env
        echo "APP_KEY=" >> .env
        echo "APP_DEBUG=true" >> .env
        echo "APP_URL=http://localhost" >> .env
        print_success "File .env creato con configurazione base"
    fi
else
    print_success "File .env trovato"
fi

# 2. Verifica APP_KEY
print_status "Verifica APP_KEY..."
if ! grep -q "APP_KEY=base64:" .env; then
    print_warning "APP_KEY non configurata o non valida. Generazione nuova chiave..."
    
    # Rimuovi APP_KEY esistente se presente
    sed -i '/APP_KEY=/d' .env
    
    # Genera nuova APP_KEY
    php artisan key:generate --force
    
    if [ $? -eq 0 ]; then
        print_success "APP_KEY generata con successo"
    else
        print_error "Errore nella generazione APP_KEY"
        exit 1
    fi
else
    print_success "APP_KEY già configurata"
fi

# 3. Verifica cipher
print_status "Verifica configurazione cipher..."
CIPHER=$(grep -o "'cipher' => '[^']*'" config/app.php | cut -d"'" -f4)
if [ "$CIPHER" = "AES-256-CBC" ]; then
    print_success "Cipher configurato correttamente: $CIPHER"
else
    print_warning "Cipher non standard: $CIPHER"
fi

# 4. Verifica estensioni PHP
print_status "Verifica estensioni PHP necessarie..."
if php -m | grep -q "openssl"; then
    print_success "Estensione OpenSSL trovata"
else
    print_error "Estensione OpenSSL mancante!"
    exit 1
fi

if php -m | grep -q "mbstring"; then
    print_success "Estensione MBString trovata"
else
    print_warning "Estensione MBString mancante (potrebbe causare problemi)"
fi

# 5. Verifica versione PHP
print_status "Verifica versione PHP..."
PHP_VERSION=$(php -r "echo PHP_VERSION;")
PHP_MAJOR=$(echo $PHP_VERSION | cut -d. -f1)
PHP_MINOR=$(echo $PHP_VERSION | cut -d. -f2)

if [ "$PHP_MAJOR" -ge 8 ] && [ "$PHP_MINOR" -ge 2 ]; then
    print_success "Versione PHP OK: $PHP_VERSION"
else
    print_error "Versione PHP non supportata: $PHP_VERSION (richiesto 8.2+)"
    exit 1
fi

# 6. Clear cache
print_status "Pulizia cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
print_success "Cache pulita"

# 7. Verifica permessi
print_status "Verifica permessi file..."
chmod 644 .env
chmod -R 755 storage
chmod -R 755 bootstrap/cache
print_success "Permessi impostati correttamente"

# 8. Test crittografia
print_status "Test crittografia..."
if php artisan tinker --execute="echo encrypt('test');" > /dev/null 2>&1; then
    print_success "Test crittografia superato"
else
    print_error "Test crittografia fallito"
    exit 1
fi

# 9. Verifica finale
print_status "Verifica finale configurazione..."
echo ""
echo "📋 Riepilogo configurazione:"
echo "============================"
echo "APP_KEY: $(grep APP_KEY .env | cut -d'=' -f2 | cut -c1-20)..."
echo "Cipher: $CIPHER"
echo "PHP Version: $PHP_VERSION"
echo "OpenSSL: $(php -m | grep openssl | wc -l) estensioni"
echo ""

# Test finale
if curl -s http://127.0.0.1:8001 > /dev/null 2>&1; then
    print_success "✅ Applicazione accessibile su http://127.0.0.1:8001"
else
    print_warning "⚠️  Applicazione non accessibile (potrebbe essere normale se non in esecuzione)"
fi

echo ""
print_success "🎉 Risoluzione errore crittografia completata!"
echo ""
echo "Se il problema persiste, controlla:"
echo "1. Log Laravel: tail -f storage/logs/laravel.log"
echo "2. Debug: APP_DEBUG=true in .env"
echo "3. Server: php artisan serve"
echo "" 