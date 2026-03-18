# Configurazione .env.development - Ambiente di Sviluppo

## Panoramica

Il file `.env.development` è la configurazione di sviluppo standard per l'ambiente locale di Quaeris Fila5 Mono. Questa configurazione è ottimizzata per lo sviluppo rapido e zero-setup, differenziandosi significativamente dalla configurazione di produzione.

## Differenze Chiave con .env.example

### 1. Database Configuration

#### SQLite per Sviluppo (`.env.development`)
```bash
# SQLite per development - Zero setup required
DB_CONNECTION=sqlite
DB_DATABASE=$PROJECT_ROOT/database/database.sqlite
```

#### MySQL per Produzione (`.env.example`)
```bash
# MySQL per produzione
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Cache e Queue Configuration

#### Sviluppo
```bash
# Cache e Queue per development
CACHE_DRIVER=array
QUEUE_CONNECTION=sync
```

#### Produzione
```bash
CACHE_STORE=database
CACHE_PREFIX=
QUEUE_CONNECTION=database
```

### 3. Session Configuration

#### Sviluppo
```bash
# Session development
SESSION_DRIVER=array
SESSION_LIFETIME=120
```

#### Produzione
```bash
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

### 4. Mail Configuration

#### Sviluppo
```bash
# Development mail
MAIL_MAILER=log
MAIL_FROM_ADDRESS="${APP_NAME}"
MAIL_FROM_NAME="${APP_NAME}"
```

#### Produzione
```bash
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

## Perché Questa Configurazione?

### 1. Zero Setup per Sviluppo
- **SQLite**: Nessuna configurazione del database richiesta
- **Array Cache**: Cache in-memory per performance durante lo sviluppo
- **Sync Queue**: Esecuzione immediata delle attività senza coda

### 2. Ottimizzazione per Sviluppo
- **Session Array**: Maggiore velocità per sessioni di test
- **Log Mailer**: Output mail in log per debugging
- **Array Cache**: Performance ottimizzata per sviluppo rapido

### 3. Compatibilità con Laravel 12.x
- Configurazione conforme alle best practices Laravel 12.x
- Variabili d'ambiente ottimizzate per ambiente di sviluppo
- Supporto completo per tutte le funzionalità di Laravel

## Struttura del File .env.development

```bash
# Development Environment - Laraxot Standard
# Database: SQLite per sviluppo locale immediato

APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# SQLite per development - Zero setup required
DB_CONNECTION=sqlite
DB_DATABASE=$PROJECT_ROOT/database/database.sqlite

# Cache e Queue per development
CACHE_DRIVER=array
QUEUE_CONNECTION=sync

# Development mail
MAIL_MAILER=log
MAIL_FROM_ADDRESS="${APP_NAME}"
MAIL_FROM_NAME="${APP_NAME}"

# Session development
SESSION_DRIVER=array
SESSION_LIFETIME=120

# Redis per development
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Broadcasting
BROADCAST_DRIVER=log
```

## Variabili di Ambiente Importanti

### 1. $PROJECT_ROOT
```bash
DB_DATABASE=$PROJECT_ROOT/database/database.sqlite
```
- Riferimento automatico alla directory di progetto
- Permette setup uniforme in ambienti diversi
- Facilita il deployment e la portabilità

### 2. CACHE_DRIVER=array
- Cache in-memory per performance sviluppo
- Riduce overhead file system
- Ottimizzato per cicli di test rapidi

### 3. QUEUE_CONNECTION=sync
- Esecuzione immediata attività
- Debug più semplice
- Performance durante lo sviluppo

## Quando Usare .env.development

### ✅ Per Sviluppo Locale
- Setup rapido senza configurazione database
- Testing funzionalità senza dipendenze esterne
- Debugging più efficiente

### ✅ Per Testing
- Test unitari e integration test
- Cicli di sviluppo rapidi
- Debugging locale

### ❌ Per Produzione
- Usare sempre `.env` con configurazione MySQL
- Configurazione Redis per cache e sessioni
- Database connection pooling per performance

## Best Practices per l'Utilizzo

### 1. Setup Iniziale
```bash
# Copiare il file di sviluppo come configurazione base
cp .env.development .env

# Generare la chiave applicazione
php artisan key:generate

# Eseguire le migrazioni
php artisan migrate
```

### 2. Sviluppo Continuo
```bash
# Svuotare cache dopo modifiche
php artisan optimize:clear

# Eseguire test
php artisan test
```

### 3. Debugging
```bash
# Abilitare debugbar per debugging
DEBUGBAR_ENABLED=true

# Verificare log dettagliati
LOG_LEVEL=debug
```

## Compatibilità con Laravel 12.x

### ✅ Compatibile
- Tutte le funzionalità Laravel 12.x
- Configurazione database SQLite standard
- Supporto completo per Redis
- Compatibilità con Filament 5.x

### 🔄 Configurazioni Automatiche
- Laravel 12.x riconosce automaticamente SQLite
- Configurazione Redis ottimizzata
- Supporto per tutte le funzionalità di sviluppo

## Migrazioni da .env.development a Produzione

### 1. Database
```bash
# Da
DB_CONNECTION=sqlite
DB_DATABASE=$PROJECT_ROOT/database/database.sqlite

# A
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=Quaeris_data
DB_USERNAME=marco
DB_PASSWORD=marco
```

### 2. Cache e Queue
```bash
# Da
CACHE_DRIVER=array
QUEUE_CONNECTION=sync

# A
CACHE_STORE=database
CACHE_PREFIX=
QUEUE_CONNECTION=database
```

### 3. Sessioni
```bash
# Da
SESSION_DRIVER=array
SESSION_LIFETIME=120

# A
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
```

## Conclusione

Il file `.env.development` rappresenta la configurazione ottimale per lo sviluppo rapido e efficiente di Quaeris Fila5 Mono. La sua struttura differenzia significativamente dalla produzione per favorire setup zero-setup, performance ottimizzate e debugging più semplice. Questa configurazione è essenziale per mantenere un ambiente di sviluppo fluido e produttivo.
