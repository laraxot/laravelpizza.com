# Documentazione Centralizzata - Rifattorizzazione DRY + KISS

## Obiettivo
Questa rifattorizzazione radicale elimina la duplicazione di contenuto e semplifica la struttura della documentazione seguendo i principi DRY (Don't Repeat Yourself) e KISS (Keep It Simple, Stupid).

## Principi Fondamentali

### DRY (Don't Repeat Yourself)
- **Un solo punto di verità**: Ogni argomento è documentato in un solo posto
- **Collegamenti bidirezionali**: Ogni file ha almeno 2 backlink
- **Eliminazione duplicati**: Nessuna ripetizione di contenuto

### KISS (Keep It Simple, Stupid)
- **Struttura piatta**: Massimo 3 livelli di profondità
- **Nomi intuitivi**: File e cartelle con nomi chiari e descrittivi
- **Organizzazione logica**: Contenuti raggruppati per funzionalità

### Convenzioni Naming
- **Tutto in minuscolo**: File e cartelle solo in minuscolo
- **Separatori con trattini**: `nome-file.md` invece di `NomeFile.md`
- **Eccezione README.md**: Solo i file README possono avere maiuscole

## Struttura

```
docs/
├── architecture/          # Architettura del sistema
│   ├── modules/          # Struttura moduli
│   ├── patterns/         # Pattern architetturali
│   └── standards/        # Standard e convenzioni
├── development/          # Guide di sviluppo
│   ├── filament/         # Filament specifico
│   ├── phpstan/          # PHPStan e qualità codice
│   ├── translations/     # Sistema traduzioni
│   └── best-practices/   # Best practices generali
├── modules/              # Documentazione moduli
│   ├── xot/             # Modulo Xot
│   ├── user/            # Modulo User
│   └── [altri moduli]/  # Altri moduli
├── troubleshooting/      # Risoluzione problemi
│   ├── conflicts/        # Conflitti Git
│   ├── errors/           # Errori comuni
│   └── fixes/            # Fix e correzioni
└── guides/              # Guide utente
    ├── installation/     # Installazione
    ├── configuration/    # Configurazione
    └── deployment/       # Deployment
```

## Migrazione da Vecchia Struttura

### File Migrati
- `docs/` → `docs_new/` (struttura centralizzata)
- `laravel/docs/` → `docs_new/development/`
- `laravel/Modules/*/docs/` → `docs_new/modules/*/`
- `_docs/` → Eliminati (contenuto duplicato)

### Regole di Migrazione
1. **Eliminazione duplicati**: Un solo file per argomento
2. **Rinomina in minuscolo**: Tutti i file rinominati in minuscolo
3. **Aggiornamento collegamenti**: Tutti i link interni aggiornati
4. **Documentazione processo**: Ogni migrazione documentata

## Collegamenti Bidirezionali

Ogni file deve avere almeno 2 collegamenti in ingresso:
- Link dalla documentazione principale
- Link da documentazione correlata
- Link da guide specifiche

## Manutenzione

### Aggiornamenti
- Modificare solo il file principale per ogni argomento
- Aggiornare i collegamenti bidirezionali
- Mantenere la coerenza della struttura

### Controlli
- Verificare che non ci siano duplicati
- Controllare i collegamenti bidirezionali
- Mantenere i nomi in minuscolo

## Benefici della Rifattorizzazione

1. **Riduzione complessità**: Da 84 cartelle docs a 1 struttura centralizzata
2. **Eliminazione duplicati**: Contenuto unificato e non ripetuto
3. **Facilità manutenzione**: Un solo punto di modifica per ogni argomento
4. **Navigazione migliorata**: Struttura logica e intuitiva
5. **Coerenza**: Convenzioni uniformi in tutto il progetto

---

## Aggiornamenti Recenti

### Gennaio 2025
- **Risoluzione Conflitti Git**: Completata risoluzione sistematica di conflitti nei file di backup
- **Workflow Module Setup**: Aggiornato a versione 2.1 con compatibilità Laravel 11+
- **Documentazione Moduli**: Unificata struttura con Quick Reference per AI e Blog
- **Best Practices**: Consolidate regole per risoluzione conflitti manuale

### Collegamenti Correlati
- [Risoluzione Conflitti Backup](./riepilogo-risoluzione-conflitti-backup.md)
- [Risoluzione Conflitti Git](./riepilogo-risoluzione-conflitti-git.md)
- [Rifattorizzazione Completata](./rifattorizzazione-completata.md)

---

*Ultimo aggiornamento: Gennaio 2025*
*Responsabile: Rifattorizzazione DRY + KISS + Risoluzione Conflitti* 