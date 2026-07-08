# Script di Setup

## Descrizione
Questa cartella contiene gli script per la configurazione iniziale del progetto, inclusi:
- Installazione delle dipendenze
- Configurazione dell'ambiente
- Setup del database
- Configurazione dei moduli

## Script Disponibili

### 1. setup_environment.sh
Configura l'ambiente di sviluppo con:
- Installazione dipendenze PHP
- Installazione dipendenze Node.js
- Configurazione variabili d'ambiente

### 2. setup_database.sh
Configura il database con:
- Creazione database
- Esecuzione migrazioni
- Popolamento dati iniziali

### 3. setup_modules.sh
Configura i moduli con:
- Installazione moduli base
- Configurazione dipendenze
- Setup permessi

## Utilizzo

```bash

# Setup completo
./setup_environment.sh
./setup_database.sh
./setup_modules.sh

# Setup specifico
./setup_environment.sh --php-only
./setup_database.sh --migrate-only
```

## Best Practices
- Eseguire gli script in ordine corretto
- Verificare i requisiti di sistema
- Mantenere backup della configurazione 
