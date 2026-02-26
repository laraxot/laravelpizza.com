# Organizzazione Cartella BashScripts

## Regola Fondamentale

La cartella `/var/www/html/_bases/base_<nome progetto>/bashscripts` deve contenere **SOLO** il file `README.md` nella root. Tutti gli altri file devono essere categorizzati e organizzati in sottocartelle tematiche.

## Struttura Organizzata

### Root Directory
```
bashscripts/
├── README.md          # UNICO file permesso nella root
├── .gitignore         # File di configurazione Git
└── [sottocartelle]/   # Tutte le sottocartelle tematiche
```

### Sottocartelle Tematiche

#### 1. **analysis/** - Script di Analisi
- `analyse_module.sh` - Analisi singolo modulo
- `analyze_all_modules.sh` - Analisi tutti i moduli
- `analyze_modules.sh` - Script di analisi modulare
- `bottlenecks.md` - Documentazione colli di bottiglia
- `analisi_miglioramento_prompt.md` - Analisi miglioramenti prompt

#### 2. **database/** - Script Database
- `check_mysql.sh` - Controllo connessione MySQL (Linux)
- `check_mysql_win.sh` - Controllo connessione MySQL (Windows)

#### 3. **development/** - Script di Sviluppo
- `check_form_schema.php` - Controllo schema form
- `composer_init.sh` - Inizializzazione Composer
- `get_composer.sh` - Download Composer

#### 4. **git-management/** - Gestione Git
- Script per gestione subtree, branch, merge
- Script per sincronizzazione repository
- Documentazione risoluzione conflitti
- Automazione push/pull operations

#### 5. **maintenance/** - Manutenzione Sistema
- `backup.sh` - Script di backup
- `restore_disk.md` - Documentazione ripristino
- `sync_to_disk.sh` - Sincronizzazione disco

#### 6. **phpstan/** - Analisi Statica PHPStan
- `run_phpstan.sh` - Esecuzione PHPStan
- `phpstan_analyze_modules.sh` - Analisi moduli
- `generate_phpstan_docs.php` - Generazione documentazione
- `check_before_phpstan.sh` - Controlli pre-analisi

#### 7. **quality-assurance/** - Qualità del Codice
- `code_quality.md` - Documentazione qualità
- `fix_errors.sh` - Correzione errori automatica

#### 8. **translations/** - Gestione Traduzioni
- `fix_all_english_translations.sh` - Fix traduzioni inglesi
- `fix_<nome progetto>_translations.sh` - Fix traduzioni <nome progetto>
- `verify_translations_syntax.sh` - Verifica sintassi traduzioni

#### 9. **utilities/** - Utilità Generali
- Script di utilità varia
- Tool di automazione
- Helper per operazioni comuni

### Sottocartelle Esistenti (Già Organizzate)

Le seguenti sottocartelle esistevano già e contengono script specifici:

- **backup/** - Script di backup avanzati
- **composer/** - Gestione Composer
- **config/** - File di configurazione
- **docker/** - Configurazioni Docker
- **docs/** - Documentazione script
- **fix/** - Script di correzione
- **geo/** - Script geografici
- **git/** - Script Git avanzati
- **lib/** - Librerie condivise
- **logs/** - Log di sistema
- **mcp/** - Model Context Protocol
- **mysql/** - Database MySQL
- **pdf/** - Gestione PDF
- **php/** - Script PHP
- **prompts/** - Template prompt
- **setup/** - Script di setup
- **submodules/** - Gestione submoduli
- **subtrees/** - Gestione subtree
- **system/** - Script di sistema
- **temp/** - File temporanei
- **testing/** - Script di test
- **tools/** - Strumenti vari
- **utils/** - Utilità varie
- **webmin/** - Configurazione Webmin

## Motivazione della Riorganizzazione

### Vantaggi
1. **Organizzazione Tematica**: Script raggruppati per funzionalità
2. **Facilità di Navigazione**: Struttura logica e intuitiva
3. **Manutenibilità**: Più facile trovare e aggiornare script
4. **Scalabilità**: Struttura che supporta crescita futura
5. **Conformità**: Rispetto delle regole di organizzazione del progetto

### Regole di Manutenzione
1. **Root Pulita**: Solo `README.md` e `.gitignore` nella root
2. **Categorizzazione**: Ogni nuovo script deve essere categorizzato
3. **Documentazione**: Aggiornare questa documentazione per nuove categorie
4. **Naming**: Usare nomi descrittivi per sottocartelle e script
5. **README**: Ogni sottocartella dovrebbe avere un `README.md` esplicativo

## Implementazione

La riorganizzazione è stata completata il **2025-01-29** seguendo questi passaggi:

1. **Creazione sottocartelle tematiche**
2. **Categorizzazione e spostamento file**
3. **Verifica struttura finale**
4. **Aggiornamento documentazione**

## Collegamenti

- [Struttura Generale Progetto](structure.md)
- [Script di Automazione](../tools/)
- [Documentazione Git](git/)
- [Documentazione PHPStan](phpstan/)

## Manutenzione Futura

Per mantenere questa organizzazione:

1. **Nuovi Script**: Categorizzare immediatamente in sottocartelle appropriate
2. **Review Periodiche**: Verificare che la struttura rimanga coerente
3. **Documentazione**: Aggiornare questa documentazione per modifiche significative
4. **Pulizia**: Rimuovere script obsoleti o duplicati

---

*Ultimo aggiornamento: 2025-01-29*
*Responsabile: Sistema di Automazione Laraxot*
