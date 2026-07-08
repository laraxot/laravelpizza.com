# 🚀 Toolkit di Automazione Git

[![GitHub](https://img.shields.io/badge/GitHub-100000?style=for-the-badge&logo=github&logoColor=white)](https://github.com)
[![Bash](https://img.shields.io/badge/Bash-4EAA25?style=for-the-badge&logo=gnu-bash&logoColor=white)](https://www.gnu.org/software/bash/)
[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)

> **⚠️ ATTENZIONE: Questo toolkit è stato progettato per sviluppatori esperti che lavorano con repository Git complessi e strutture monorepo.**

## 📋 Panoramica

Questo toolkit è una suite completa di script Bash progettata per automatizzare e semplificare la gestione di repository Git complessi, con particolare attenzione alle strutture monorepo e alla sincronizzazione tra organizzazioni. È stato sviluppato per ottimizzare il flusso di lavoro degli sviluppatori e ridurre gli errori umani nelle operazioni Git complesse.

## 📚 Documentazione Correlata

> **Nota:** I seguenti link puntano esclusivamente a moduli e documenti tecnici realmente necessari come dipendenza per l'utilizzo e la manutenzione degli script Bash di questo toolkit.

### Moduli Core e Dipendenze Tecniche
- [Xot Module](../../laravel/Modules/Xot/docs/README.md)
  > Framework core e utilities condivise: fornisce convenzioni di struttura e helpers usati dagli script Bash.
- [Lang Module](../../laravel/Modules/Lang/docs/README.md)
  > Gestione multilingua e sincronizzazione file di traduzione, utile per script di validazione e deploy.
- [Job Module](../../laravel/Modules/Job/docs/README.md)
  > Esempi di automazione tramite job/queue, utile per script di sincronizzazione e manutenzione.

### Documentazione Tecnica Generale
- [Convenzioni di Codice](../../docs/conventions/README.md)
  > Standard di scrittura e naming per mantenere coerenza tra script e moduli.
- [Standard di Sviluppo](../../docs/standards/README.md)
  > Linee guida generali per lo sviluppo e la manutenzione del progetto.
- [Guida alla Manutenzione](../../docs/moduli/manutenzione/README.md)
  > Procedure consigliate per la manutenzione periodica tramite script Bash.
- [Struttura Moduli](../../docs/moduli/struttura/README.md)
  > Descrizione della struttura dei moduli, utile per comprendere dove e come agiscono gli script.
- [Comandi Disponibili](../../docs/moduli/comandi/README.md)
  > Elenco dei comandi Bash disponibili e la loro documentazione contestuale.

## 🎯 Caratteristiche Principali

### 🔄 Sincronizzazione Avanzata
- Sincronizzazione automatica tra organizzazioni Git
- Gestione intelligente dei submodule
- Supporto per strutture monorepo complesse
- Risoluzione automatica dei conflitti

### 🛠️ Strumenti di Manutenzione
- Pulizia automatica dei repository
- Gestione avanzata dei branch
- Strumenti per la risoluzione dei conflitti
- Backup automatizzato

### 🔍 Controlli e Validazione
- Verifica dello stato del database MySQL
- Controlli pre-commit
- Validazione della struttura del progetto
- Analisi statica del codice PHP

## 📁 Struttura del Toolkit

```
bashscripts/
├── git/                 # Script per la gestione Git
├── maintenance/         # Script di manutenzione
├── checks/             # Script di verifica
└── prompt/             # Template per prompt personalizzati
```

## 🚀 Script Principali

### Git Sync & Organization
- `git_sync_org.sh`: Sincronizza repository tra organizzazioni
- `git_sync_subtree.sh`: Gestisce la sincronizzazione dei subtree
- `git_change_org.sh`: Cambia l'organizzazione del repository

### Manutenzione
- `fix_directory_structure.sh`: Corregge la struttura delle directory
- `resolve_git_conflict.sh`: Risolve automaticamente i conflitti Git
- `backup.sh`: Esegue backup automatizzati

### Verifica
- `check_before_phpstan.sh`: Esegue controlli pre-phpstan
- `check_mysql.sh`: Verifica lo stato del database MySQL

## 💡 Best Practices

1. **Sicurezza**: Tutti gli script includono controlli di sicurezza e validazione
2. **Logging**: Sistema di logging dettagliato per tracciare le operazioni
3. **Conferma**: Richiesta di conferma per operazioni critiche
4. **Rollback**: Supporto per il ripristino in caso di errori

## 🛠️ Requisiti

- Bash 4.0+
- Git 2.0+
- PHP 8.0+ (per alcuni script)
- MySQL (per gli script di verifica database)

## ⚠️ Avvertenze

- Utilizzare con cautela in ambienti di produzione
- Eseguire sempre backup prima di operazioni critiche
- Verificare le modifiche in ambiente di test

## 🤝 Contribuire

Le contribuzioni sono benvenute! Per favore, leggi le linee guida per i contributori prima di inviare pull request.

## 📄 Licenza

Questo progetto è distribuito sotto la licenza MIT. Vedi il file `LICENSE` per maggiori dettagli.

---

<div align="center">
  <sub>Built with ❤️ by the development team</sub>
</div> 