# Organizzazione Script - Regole Fondamentali

## Regola Assoluta

**TUTTI gli script** (PHP, Bash, Python, etc.) devono essere posizionati **SEMPRE** nella cartella `bashscripts` del progetto, **MAI** nella directory Laravel o in altre posizioni.

## Struttura Corretta

```
bashscripts/
├── database/
│   ├── seeding/          # Script per popolamento database
│   │   ├── <nome progetto>-seeding.php
│   │   ├── <nome modulo>-seeding.php
│   │   ├── <nome progetto>-seeding.php
│   │   ├── <nome progetto>-seeding.php
│   │   └── mass-seeding.php
│   ├── migration/        # Script per gestione migrazioni
│   └── backup/          # Script per backup database
├── maintenance/
│   ├── cleanup/          # Script di pulizia
│   └── optimization/     # Script di ottimizzazione
├── deployment/
│   ├── staging/          # Script per ambiente staging
│   └── production/       # Script per ambiente produzione
└── utilities/
    ├── monitoring/       # Script di monitoraggio
    └── reporting/        # Script di reporting
```

## Motivazione

- **Separazione chiara** tra codice applicativo e script di utilità
- **Facilità di manutenzione** e backup
- **Organizzazione logica** per tipo di operazione
- **Rispetto dell'architettura modulare** Laraxot
- **Versioning separato** degli script rispetto al codice applicativo

## Categorizzazione Script

### Database
- **Seeding**: Popolamento database con dati di test/produzione
- **Migration**: Gestione avanzata delle migrazioni
- **Backup**: Backup e restore del database

### Maintenance
- **Cleanup**: Pulizia file temporanei, log, cache
- **Optimization**: Ottimizzazione database, file system

### Deployment
- **Staging**: Preparazione ambiente di test
- **Production**: Deploy in produzione

### Utilities
- **Monitoring**: Controllo stato sistema
- **Reporting**: Generazione report automatici

## Anti-pattern da Evitare

- ❌ Posizionare script nella directory Laravel
- ❌ Creare script in posizioni casuali
- ❌ Mescolare script con codice applicativo
- ❌ Non categorizzare gli script per tipo
- ❌ Usare nomi generici per gli script

## Esempi di Naming Corretto

### Script di Seeding
```
<nome progetto>-mass-seeding.php          # Popolamento massivo <nome progetto>
<nome modulo>-database-seeding.php       # Popolamento <nome modulo>
<nome progetto>-mass-seeding.php          # Popolamento massivo <nome progetto>
<nome progetto>-database-seeding.php       # Popolamento <nome progetto>
user-role-seeding.php               # Popolamento ruoli utente
```

### Script di Maintenance
```
cleanup-temp-files.php              # Pulizia file temporanei
optimize-database.php               # Ottimizzazione database
clear-cache-all.php                 # Pulizia cache completa
```

## Utilizzo degli Script

### Esecuzione Diretta
```bash
# Dalla root del progetto
cd ..
php bashscripts/database/seeding/<nome progetto>-mass-seeding.php
php bashscripts/database/seeding/<nome progetto>-mass-seeding.php
```

### Esecuzione via Tinker
```bash
# Dalla directory Laravel
cd laravel
php artisan tinker

# Incolla il contenuto dello script
include_once('../bashscripts/database/seeding/<nome progetto>-mass-seeding.php');
include_once('../bashscripts/database/seeding/<nome progetto>-mass-seeding.php');
```

## Documentazione Obbligatoria

Ogni script deve includere:

1. **Header con descrizione** dello scopo
2. **Istruzioni di esecuzione** chiare
3. **Parametri richiesti** e opzionali
4. **Esempi di utilizzo**
5. **Note di sicurezza** se applicabili
6. **Collegamenti** alla documentazione correlata

## Checklist Creazione Script

- [ ] Script posizionato in `bashscripts/` con sottocartella appropriata
- [ ] Nome file descrittivo e coerente
- [ ] Documentazione completa nell'header
- [ ] Categorizzazione corretta
- [ ] Test di esecuzione completato
- [ ] Documentazione aggiornata

## Collegamenti

- [Regole Cursor](../.cursor/rules/script-positioning-rule.mdc)
- [Memorie Cursor](../.cursor/memories/script-positioning.mdc)
- [Struttura Progetto](project-structure.md)
- [Database Seeding](database-seeding.md)

*Ultimo aggiornamento: 2025-01-06*
