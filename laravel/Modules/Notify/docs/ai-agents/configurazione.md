# Configurazione e Setup

## Requisiti
- PHP 8.2+
- Laravel 12.x
- Database MySQL/PostgreSQL
- Composer

## Installazione
```bash
# Installazione dipendenze
composer install

# Configurazione ambiente
cp .env.example .env
php artisan key:generate

# Esecuzione migrazioni
php artisan migrate

# Abilitazione moduli
php artisan module:enable User Performance Gdpr Activity
```

## Ambiente
Il sistema supporta connessioni multiple per ottimizzazione performance:
- `mysql` - Database principale
- `performance` - Database valutazioni performance
- `user` - Database dati sensibili (GDPR)

## Approfondimenti
- Come configurare le Actions: [Regole Critiche Laraxot](./regole-critiche.md#actions-vs-services)
- Gestione della configurazione dei moduli: [Moduli Principali](./moduli-principali.md)