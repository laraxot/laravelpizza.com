# Organizzazione Script Bash

## Struttura Organizzata

Gli script bash sono stati organizzati in sottocartelle tematiche per migliorare la manutenibilità e la navigazione.

### 📁 Categorie Principali

#### `git/` - Operazioni Git e Subtree
- Script per gestione repository Git
- Operazioni subtree e submodule
- Risoluzione conflitti
- Sincronizzazione con repository remoti

#### `phpstan/` - Analisi PHPStan
- Script per analisi statica del codice
- Generazione documentazione PHPStan
- Controlli di qualità del codice
- Report e summary

#### `docs/` - Documentazione e Script Docs
- Script per gestione documentazione
- Aggiornamento link e riferimenti
- Fix naming conventions
- Generazione documentazione

#### `translations/` - Script Traduzioni
- Gestione file di traduzione
- Fix e miglioramento traduzioni
- Controllo duplicati
- Aggiornamento enum

#### `mcp/` - Model Context Protocol
- Script per gestione MCP
- Connettori database
- Configurazione MCP
- Gestione MySQL per MCP

#### `composer/` - Gestione Composer
- Script per gestione dipendenze
- Inizializzazione Composer
- Aggiornamento autoload
- Configurazione Composer

#### `mysql/` - Script MySQL/Database
- Controlli connessione MySQL
- Script per Windows e Linux
- Verifica stato database
- Backup e restore

#### `maintenance/` - Script Manutenzione
- Script di backup
- Fix errori comuni
- Manutenzione struttura
- Pulizia sistema

#### `setup/` - Setup e Configurazione
- Configurazione ambiente
- Setup server
- Configurazione build tools
- File di configurazione

#### `utils/` - Utility Generali
- Script di utilità
- Parser e helper
- Script di organizzazione
- Utility comuni

#### `testing/` - Script Testing
- Script per test
- Controlli pre-deploy
- Validazione form
- Test di qualità

#### `prompts/` - File Prompts
- File di prompt per AI
- Template prompt
- Configurazione prompt
- Documentazione prompt

#### `logs/` - File di Log
- File di log vari
- Output script
- Debug logs
- Performance logs

#### `temp/` - File Temporanei
- File di test
- File temporanei
- Backup temporanei
- File di sviluppo

### 📁 Categorie Esistenti (Non Modificate)

#### `backup/` - Backup
- Script di backup specifici
- Backup configurazioni
- Backup dati

#### `config/` - Configurazione
- File di configurazione
- Template configurazione
- Configurazioni specifiche

#### `docker/` - Docker
- Script Docker
- Container management
- Docker compose

#### `docs_naming/` - Naming Documentazione
- Script per naming docs
- Fix convenzioni naming
- Organizzazione docs

#### `docs_update/` - Aggiornamento Docs
- Script aggiornamento docs
- Sincronizzazione docs
- Update automatici

#### `fix/` - Fix
- Script di fix specifici
- Correzione errori
- Fix automatici

#### `geo/` - Geografia
- Script geografici
- Gestione comuni
- Dati territoriali

#### `lib/` - Librerie
- Librerie comuni
- Funzioni condivise
- Utility library

#### `pdf/` - PDF
- Script per gestione PDF
- Analisi PDF
- Conversione PDF

#### `php/` - PHP
- Script PHP specifici
- Utility PHP
- Helper PHP

#### `submodules/` - Submodule
- Gestione submodule
- Sincronizzazione submodule
- Update submodule

#### `subtrees/` - Subtree
- Gestione subtree
- Operazioni subtree
- Configurazione subtree

#### `system/` - Sistema
- Script di sistema
- Controlli sistema
- Manutenzione sistema

#### `tools/` - Strumenti
- Strumenti vari
- Utility tools
- Helper tools

#### `webmin/` - Webmin
- Script Webmin
- Configurazione Webmin
- Gestione Webmin

## Regole di Organizzazione

### ✅ Cosa Fare
1. **Categorizzare sempre** i nuovi script nelle sottocartelle appropriate
2. **Mantenere coerenza** nella nomenclatura dei file
3. **Documentare** ogni nuovo script nella categoria appropriata
4. **Aggiornare** questo file quando si aggiungono nuove categorie

### ❌ Cosa Non Fare
1. **Non lasciare** script nella root di bashscripts
2. **Non duplicare** script tra categorie
3. **Non creare** categorie senza documentazione
4. **Non ignorare** le convenzioni di naming

## Convenzioni di Naming

### File Script
- `verb_noun.sh` - Script principali
- `check_*.sh` - Script di controllo
- `fix_*.sh` - Script di correzione
- `update_*.sh` - Script di aggiornamento
- `generate_*.sh` - Script di generazione

### Directory
- Nomi in minuscolo
- Separatori con underscore
- Nomi descrittivi e chiari
- Evitare abbreviazioni non standard

## Manutenzione

### Aggiornamento Organizzazione
1. Eseguire `utils/organize_scripts.sh` per organizzare nuovi file
2. Aggiornare questo file di documentazione
3. Verificare che tutti i file siano nelle categorie corrette
4. Rimuovere file duplicati o obsoleti

### Controlli Periodici
- Verificare che non ci siano script nella root
- Controllare che le categorie siano logiche
- Aggiornare la documentazione
- Rimuovere file temporanei

## Collegamenti Utili

- [README.md](README.md) - Documentazione principale
- [utils/organize_scripts.sh](utils/organize_scripts.sh) - Script di organizzazione
- [utils/organize_remaining.sh](utils/organize_remaining.sh) - Script per file rimanenti

---

*Ultimo aggiornamento: Giugno 2025*
*Organizzazione completata: 24 Giugno 2025* 