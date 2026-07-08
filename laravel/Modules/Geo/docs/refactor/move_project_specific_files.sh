#!/usr/bin/env bash

# Script per spostare file specifici del progetto <nome progetto> dalla cartella bashscripts condivisa
# alla posizione appropriata nel modulo specifico

set -euo pipefail

PROJECT_ROOT="/var/www/html/_bases/base_<nome progetto>"
BASHSCRIPTS_DIR="${PROJECT_ROOT}/bashscripts"
LARAVEL_DIR="${PROJECT_ROOT}/laravel"

echo "🔧 Spostamento file specifici progetto <nome progetto>..."
echo "======================================================"

# Crea le directory di destinazione se non esistono
mkdir -p "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding"
mkdir -p "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding"
mkdir -p "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/generators"

# 1. Sposta script di seeding specifici da bashscripts/database/seeding/
echo "📁 Spostamento script di seeding..."

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-database-seeding.php" ]; then
    echo "  ➜ Spostando <nome progetto>-database-seeding.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-database-seeding.php" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-1000-records.php" ]; then
    echo "  ➜ Spostando <nome progetto>-1000-records.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-1000-records.php" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-20-studios-66010.php" ]; then
    echo "  ➜ Spostando <nome progetto>-20-studios-66010.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-20-studios-66010.php" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-mass-seeding.php" ]; then
    echo "  ➜ Spostando <nome progetto>-mass-seeding.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/<nome progetto>-mass-seeding.php" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/tinker-1000-records.php" ]; then
    echo "  ➜ Spostando tinker-1000-records.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/tinker-1000-records.php" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/tinker-20-studios-66010.php" ]; then
    echo "  ➜ Spostando tinker-20-studios-66010.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/tinker-20-studios-66010.php" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/"
fi

if [ -f "${BASHSCRIPTS_DIR}/database/seeding/tinker-commands.php" ]; then
    echo "  ➜ Spostando tinker-commands.php..."
    mv "${BASHSCRIPTS_DIR}/database/seeding/tinker-commands.php" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/"
fi

# 2. Sposta script generatori specifici da bashscripts/<nome progetto>/
echo "📁 Spostamento script generatori..."

if [ -f "${BASHSCRIPTS_DIR}/<nome progetto>/generate_<nome progetto>_factories_and_seeders.sh" ]; then
    echo "  ➜ Spostando generate_<nome progetto>_factories_and_seeders.sh..."
    mv "${BASHSCRIPTS_DIR}/<nome progetto>/generate_<nome progetto>_factories_and_seeders.sh" \
       "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/generators/"
fi

# 3. Rimuovi cartelle vuote
echo "🗑️  Pulizia cartelle vuote..."

if [ -d "${BASHSCRIPTS_DIR}/<nome progetto>" ] && [ -z "$(ls -A "${BASHSCRIPTS_DIR}/<nome progetto>")" ]; then
    echo "  ➜ Rimuovendo cartella vuota bashscripts/<nome progetto>/"
    rmdir "${BASHSCRIPTS_DIR}/<nome progetto>"
fi

# 4. Aggiorna il file QUICK_START.md per riflettere i nuovi percorsi
if [ -f "${BASHSCRIPTS_DIR}/database/seeding/QUICK_START.md" ]; then
    echo "📝 Aggiornamento QUICK_START.md..."
    cat > "${BASHSCRIPTS_DIR}/database/seeding/QUICK_START.md" << 'EOF'
# Quick Start per Script di Seeding Database

## Panoramica
Questa cartella contiene script di seeding generici che possono essere utilizzati in qualsiasi progetto Laravel con moduli.

## Script Generici Disponibili
- Script di utilità generale per seeding database
- Template riutilizzabili per progetti diversi
- Funzioni helper comuni

## Script Specifici del Progetto
Gli script specifici per <nome progetto> sono stati spostati nelle cartelle appropriate:

### Script <nome progetto>
- **Posizione**: `laravel/Modules/<nome progetto>/scripts/seeding/`
- **Contenuto**: Script di seeding specifici per il modulo <nome progetto>
  - `<nome progetto>-mass-seeding.php` - Seeding massivo completo
  - `<nome progetto>-1000-records.php` - Seeding 1000 record
  - `<nome progetto>-20-studios-66010.php` - 20 studi con CAP 66010
  - `tinker-*.php` - Script per Tinker

### Script <nome progetto>
- **Posizione**: `laravel/Modules/<nome progetto>/scripts/seeding/`
- **Contenuto**: Script di seeding specifici per il modulo <nome progetto>
  - `<nome progetto>-database-seeding.php` - Seeding database <nome progetto>

### Script Generatori
- **Posizione**: `laravel/Modules/<nome progetto>/scripts/generators/`
- **Contenuto**: Script per generare factory e seeder
  - `generate_<nome progetto>_factories_and_seeders.sh` - Generatore automatico

## Utilizzo
Per utilizzare gli script specifici del progetto:

```bash
# Script <nome progetto>
php laravel/Modules/<nome progetto>/scripts/seeding/<nome progetto>-mass-seeding.php

# Script <nome progetto>  
php laravel/Modules/<nome progetto>/scripts/seeding/<nome progetto>-database-seeding.php

# Generatori
bash laravel/Modules/<nome progetto>/scripts/generators/generate_<nome progetto>_factories_and_seeders.sh
```

## Principi di Organizzazione
1. **Bashscripts generici**: Script riutilizzabili tra progetti
2. **Script modulo-specifici**: Nella cartella `scripts/` del modulo
3. **Nessun riferimento specifico**: I file in bashscripts/ non devono riferirsi a progetti specifici
4. **Portabilità**: Tutti gli script devono essere portabili tra ambienti

*Ultimo aggiornamento: Gennaio 2025*
EOF
fi

# 5. Crea file README nei nuovi percorsi
echo "📝 Creazione README nei nuovi percorsi..."

# README per <nome progetto> seeding
cat > "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/README.md" << 'EOF'
# Script di Seeding - Modulo <nome progetto>

## Panoramica
Questa cartella contiene script di seeding specifici per il modulo <nome progetto> del sistema sanitario.

## Script Disponibili

### Script Principali
- **`<nome progetto>-mass-seeding.php`** - Seeding massivo completo del sistema
  - Crea utenti, studi, appuntamenti, team
  - Popola database con dati realistici
  - Supporta ~1000+ record totali

- **`<nome progetto>-1000-records.php`** - Seeding veloce 1000 record
  - Versione ottimizzata per testing rapido
  - Dataset bilanciato per sviluppo

- **`<nome progetto>-20-studios-66010.php`** - 20 studi medici CAP 66010
  - Crea esattamente 20 studi con CAP 66010 (Chieti)
  - Include dottori collegati per ogni studio
  - Dati realistici per zona specifica

### Script Tinker
- **`tinker-commands.php`** - Comandi Tinker predefiniti
- **`tinker-1000-records.php`** - Seeding via Tinker
- **`tinker-20-studios-66010.php`** - Studi CAP 66010 via Tinker

## Utilizzo

### Esecuzione Diretta
```bash
cd /var/www/html/_bases/base_<nome progetto>

# Seeding completo
php laravel/Modules/<nome progetto>/scripts/seeding/<nome progetto>-mass-seeding.php

# Seeding veloce
php laravel/Modules/<nome progetto>/scripts/seeding/<nome progetto>-1000-records.php

# Studi specifici
php laravel/Modules/<nome progetto>/scripts/seeding/<nome progetto>-20-studios-66010.php
```

### Via Tinker
```bash
cd laravel
php artisan tinker

# Carica e esegui script
include 'Modules/<nome progetto>/scripts/seeding/tinker-commands.php'
runDatabaseSeeding()
```

## Dati Generati

### Utenti
- **Admin**: Super admin del sistema
- **Dottori**: 150+ medici con specializzazioni
- **Pazienti**: 500+ pazienti con dati completi
- **Receptionist**: 30+ operatori front-office

### Studi Medici
- **Studi standard**: 50 studi generici
- **Studi specializzati**: Ortodonzia, servizi completi
- **Distribuzione geografica**: Principali città italiane
- **CAP specifici**: Focus su zone particolari

### Appuntamenti
- **Distribuzione temporale**: Passato, presente, futuro
- **Stati diversi**: Confermati, completati, emergenze
- **Dati realistici**: Orari lavorativi, specializzazioni

### Team e Collaborazioni
- **Team studio**: Uno per ogni studio medico
- **Team specializzati**: Ortodonzia, implantologia, etc.
- **Team personali**: Per dottori individuali

## Note Tecniche
- Tutti gli script utilizzano i factory esistenti del modulo
- Gestione automatica delle foreign key constraints
- Error handling robusto con rollback
- Performance ottimizzate per grandi dataset
- Compatibile con sistema multi-tenant

*Ultimo aggiornamento: Gennaio 2025*
EOF

# README per <nome progetto> seeding
if [ -d "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding" ]; then
    cat > "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/seeding/README.md" << 'EOF'
# Script di Seeding - Modulo <nome progetto>

## Panoramica
Questa cartella contiene script di seeding specifici per il modulo <nome progetto> (Salute Modena), estensione specializzata per la gestione sanitaria nella provincia di Modena.

## Script Disponibili

### Script Principali
- **`<nome progetto>-database-seeding.php`** - Seeding database <nome progetto>
  - Dati specifici per pazienti gestanti
  - Integrazione con sistema sanitario modenese
  - Specializzazioni ginecologia e ostetricia

## Utilizzo

```bash
cd /var/www/html/_bases/base_<nome progetto>

# Seeding <nome progetto>
php laravel/Modules/<nome progetto>/scripts/seeding/<nome progetto>-database-seeding.php
```

## Dati Generati
- Pazienti gestanti con dati specifici
- Specializzazioni mediche per gravidanza
- Strutture sanitarie modenesi
- Protocolli specifici <nome progetto>

*Ultimo aggiornamento: Gennaio 2025*
EOF
fi

# README per generatori
cat > "${LARAVEL_DIR}/Modules/<nome progetto>/scripts/generators/README.md" << 'EOF'
# Script Generatori - Modulo <nome progetto>

## Panoramica
Questa cartella contiene script per la generazione automatica di factory e seeder per il modulo <nome progetto>.

## Script Disponibili

### Generatori Principali
- **`generate_<nome progetto>_factories_and_seeders.sh`** - Generatore automatico
  - Scansiona tutti i modelli del modulo <nome progetto>
  - Genera factory mancanti per ogni modello
  - Genera seeder con template ottimizzato
  - Crea master seeder per orchestrare tutto

## Utilizzo

```bash
cd /var/www/html/_bases/base_<nome progetto>

# Esegui generatore
bash laravel/Modules/<nome progetto>/scripts/generators/generate_<nome progetto>_factories_and_seeders.sh
```

## Funzionalità
- **Auto-detection**: Rileva automaticamente tutti i modelli
- **Skip intelligente**: Salta modelli base e policy
- **Template robusti**: Genera codice con error handling
- **Master orchestrator**: Crea seeder principale che coordina tutti gli altri
- **Configurazione flessibile**: Counts personalizzabili per tipo modello

## Output
- Factory in `Modules/<nome progetto>/database/factories/`
- Seeder in `Modules/<nome progetto>/database/seeders/`
- Master seeder `<nome progetto>ModelsSeeder.php`

*Ultimo aggiornamento: Gennaio 2025*
EOF

echo ""
echo "✅ Spostamento completato!"
echo "======================================================"
echo "📊 Riepilogo azioni:"
echo "  ✓ Script di seeding spostati in Modules/<nome progetto>/scripts/seeding/"
echo "  ✓ Script <nome progetto> spostati in Modules/<nome progetto>/scripts/seeding/"
echo "  ✓ Script generatori spostati in Modules/<nome progetto>/scripts/generators/"
echo "  ✓ QUICK_START.md aggiornato con nuovi percorsi"
echo "  ✓ README creati per tutte le nuove cartelle"
echo "  ✓ Cartelle vuote rimosse"
echo ""
echo "🎯 Risultato:"
echo "  • bashscripts/database/seeding/ ora contiene solo script generici"
echo "  • Script specifici <nome progetto> ora in posizione appropriata"
echo "  • Documentazione aggiornata per i nuovi percorsi"
echo ""
echo "📋 Prossimi passi:"
echo "  1. Testare gli script nei nuovi percorsi"
echo "  2. Aggiornare eventuali riferimenti in altri file"
echo "  3. Committare le modifiche"
