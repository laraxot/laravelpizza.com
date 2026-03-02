# Chaos Monkey Tenant Isolation Checklist (Tenant)

## Obiettivo
Mantenere isolamento tenant e coerenza connessioni DB sotto fault injection.

## Invarianti Critiche
1. Config tenant locale contiene solo `mysql`, `user`, `sqlite` (opzionale).
2. Connessioni modulo registrate dinamicamente da `TenantServiceProvider`.
3. `.env.testing` replica `.env`, cambiando solo nomi database con suffix `_test`.
4. Nessuna duplicazione config connessioni in TestCase/setUp().

## Checklist Incident
1. Verificare tenant risolto correttamente da host/context.
2. Verificare che la connessione attiva non punti al DB sbagliato.
3. Verificare mappatura test connection per moduli.
4. Verificare assenza di connessioni modulo hardcoded nei tenant config.
5. Eseguire test isolamento dati su due tenant distinti.

## Recovery
- Ripristinare configurazione standard, poi svuotare cache.
- Eseguire solo fix minimali durante incidente.
- Documentare root cause con riferimento file/config variabile.

## Comandi
```bash
php artisan optimize:clear
php artisan test --filter=Tenant --compact
./vendor/bin/phpstan analyze Modules/Tenant --level=10
```
