# Documentazione

Questo documento serve come indice centrale per tutta la documentazione del progetto.

## Linee Guida Generali
Le linee guida complete per la documentazione sono disponibili in:
- [Linee Guida per la Documentazione](../../../Xot/project_docs/guidelines/documentation.md)

## Documentazione per Modulo

### Core
- [Xot Module](../../../Xot/docs/README.md)
- [UI Module](../../../UI/docs/README.md)
- [CMS Module](../../../Cms/docs/README.md)

### Business
- [Patient Module](../../../Patient/docs/README.md)
- [Dental Module](../../../Dental/docs/README.md)

### Supporto
- [Reporting Module](../../../Reporting/docs/README.md)
- [User Module](../../../User/docs/README.md)

## Documentazione Tecnica
- [Architettura](../../../Xot/docs/architecture/README.md)
- [API Documentation](../../../Xot/docs/api/README.md)
- [Testing](../../../Xot/docs/testing/README.md)

## Guide e Tutorial
- [Guida all'Installazione](../../../Xot/docs/installation.md)
- [Guida allo Sviluppo](../../../Xot/docs/development/README.md)
- [Troubleshooting](../../../Xot/docs/troubleshooting/README.md)

## Risorse Aggiuntive
- [Changelog](../../../Xot/docs/changelog/README.md)
- [Contributing](../../../Xot/docs/contributing.md)
- [Security](../../../Xot/docs/security.md)
- [Xot Module](../../../Xot/project_docs/README.md)
- [UI Module](../../../UI/project_docs/README.md)
- [CMS Module](../../../Cms/project_docs/README.md)

### Business
- [Patient Module](../../../Patient/project_docs/README.md)
- [Dental Module](../../../Dental/project_docs/README.md)

### Supporto
- [Reporting Module](../../../Reporting/project_docs/README.md)
- [User Module](../../../User/project_docs/README.md)

## Documentazione Tecnica
- [Architettura](../../../Xot/project_docs/architecture/README.md)
- [API Documentation](../../../Xot/project_docs/api/README.md)
- [Testing](../../../Xot/project_docs/testing/README.md)

## Guide e Tutorial
- [Guida all'Installazione](../../../Xot/project_docs/installation.md)
- [Guida allo Sviluppo](../../../Xot/project_docs/development/README.md)
- [Troubleshooting](../../../Xot/project_docs/troubleshooting/README.md)

## Risorse Aggiuntive
- [Changelog](../../../Xot/project_docs/changelog/README.md)
- [Contributing](../../../Xot/project_docs/contributing.md)
- [Security](../../../Xot/project_docs/security.md)
# Regole di Documentazione

## Panoramica
Questo documento descrive le regole fondamentali per la creazione e la manutenzione della documentazione tecnica nel progetto.

## Collegamenti

### Documentazione Correlata
- [README](../README.md) - Panoramica del modulo Xot
- [Convenzioni di Naming](./NAMING_CONVENTIONS.md) - Regole di naming per campi, classi e directory
- [Struttura dei Moduli](./MODULE_STRUCTURE.md) - Convenzioni di struttura dei moduli
- [Prompt di Documentazione](./prompts/DOCUMENTATION_PROMPTS.md) - Regole e best practices per i prompt

## Validazione dei Collegamenti

### Regole Fondamentali
- MAI usare percorsi assoluti nei collegamenti
- MAI includere il nome del progetto nei percorsi
- MAI usare percorsi che iniziano con `/var/www/html/` o simili
- MAI usare percorsi che includono `saluteora` o altri nomi specifici

### Formato Corretto
```markdown

# Collegamenti Corretti
[Documento Correlato](./documento.md)
[Documento in Sottodirectory](./sottodirectory/documento.md)
[Documento in Modulo Altro](../../AltroModulo/docs/documento.md)
[Documento in Root](../../../docs/documento.md)
```

### Formato Non Corretto
```markdown

# Collegamenti Non Corretti
[Documento Correlato](/var/www/html/saluteora/laravel/Modules/Xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/saluteora/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](C:\progetti\saluteora\laravel\Modules\Xot\docs\documento.md)
```

### Checklist di Validazione
- [ ] Il percorso è relativo alla posizione del file corrente
- [ ] Non contiene riferimenti al nome del progetto
- [ ] Non contiene percorsi assoluti
- [ ] Usa la notazione corretta per i percorsi relativi
- [ ] I percorsi sono compatibili con diversi sistemi operativi

- [Prompt di Documentazione](./prompts/DOCUMENTATION_PROMPTS.md) - Regole e best practices per i prompt

## Validazione dei Collegamenti

### Regole Fondamentali
- MAI usare percorsi assoluti nei collegamenti
- MAI includere il nome del progetto nei percorsi
- MAI usare percorsi che iniziano con `/var/www/html/` o simili
- MAI usare percorsi che includono `saluteora` o altri nomi specifici

### Formato Corretto
```markdown

# Collegamenti Corretti
[Documento Correlato](./documento.md)
[Documento in Sottodirectory](./sottodirectory/documento.md)
[Documento in Modulo Altro](../../AltroModulo/docs/documento.md)
[Documento in Root](../../../docs/documento.md)
```

### Formato Non Corretto
```markdown

# Collegamenti Non Corretti
[Documento Correlato](/var/www/html/saluteora/laravel/Modules/Xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/saluteora/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](C:\progetti\saluteora\laravel\Modules\Xot\docs\documento.md)
```

### Checklist di Validazione
- [ ] Il percorso è relativo alla posizione del file corrente
- [ ] Non contiene riferimenti al nome del progetto
- [ ] Non contiene percorsi assoluti
- [ ] Usa la notazione corretta per i percorsi relativi
- [ ] I percorsi sono compatibili con diversi sistemi operativib6f667c (.)

- [Prompt di Documentazione](./prompts/DOCUMENTATION_PROMPTS.md) - Regole e best practices per i prompt

## Validazione dei Collegamenti

### Regole Fondamentali
- MAI usare percorsi assoluti nei collegamenti
- MAI includere il nome del progetto nei percorsi
- MAI usare percorsi che iniziano con `/var/www/html/` o simili
- MAI usare percorsi che includono `saluteora` o altri nomi specifici

### Formato Corretto
```markdown

# Collegamenti Corretti
[Documento Correlato](./documento.md)
[Documento in Sottodirectory](./sottodirectory/documento.md)
[Documento in Modulo Altro](../../AltroModulo/docs/documento.md)
[Documento in Root](../../../docs/documento.md)
```

### Formato Non Corretto
```markdown

# Collegamenti Non Corretti
[Documento Correlato](/var/www/html/saluteora/laravel/Modules/Xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/saluteora/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](C:\progetti\saluteora\laravel\Modules\Xot\docs\documento.md)
```

### Checklist di Validazione
- [ ] Il percorso è relativo alla posizione del file corrente
- [ ] Non contiene riferimenti al nome del progetto
- [ ] Non contiene percorsi assoluti
- [ ] Usa la notazione corretta per i percorsi relativi
- [ ] I percorsi sono compatibili con diversi sistemi operativib6f667c (.)

## 1. Regole Fondamentali

### Nomi di Progetto
- **Non menzionare mai il nome specifico del progetto nella documentazione tecnica**
- Utilizzare termini generici come "il progetto", "l'applicazione", "il sistema"
- Questo permette di riutilizzare la documentazione per progetti simili

### Nomi di Directory
- Utilizzare percorsi relativi senza riferimenti al nome del progetto
- Esempio corretto: `/laravel/config/local/database/content/`
- Esempio errato: `/laravel/config/local/{nome-progetto}/database/content/`

### Nomi di File
- Utilizzare nomi generici e descrittivi
- Evitare riferimenti specifici al progetto
- Esempio corretto: `homepage.json`
- Esempio errato: `{nome-progetto}-homepage.json`

### Prompt Condivisi
- I prompt in `bashscripts/prompts/` devono essere generici
- Non devono contenere riferimenti al nome del progetto
- Devono essere una singola stringa continua senza formattazione
- Non devono contenere a capo o formattazione speciale
- Devono essere documentati nelle cartelle docs appropriate
- Ogni modifica al prompt deve essere accompagnata da aggiornamenti alla documentazione
- La documentazione deve spiegare il "perché" delle regole, non solo il "come"

- Devono essere documentati nelle cartelle docs appropriate
- Ogni modifica al prompt deve essere accompagnata da aggiornamenti alla documentazione
- La documentazione deve spiegare il "perché" delle regole, non solo il "come"b6f667c (.)

- Devono essere documentati nelle cartelle docs appropriate
- Ogni modifica al prompt deve essere accompagnata da aggiornamenti alla documentazione
- La documentazione deve spiegare il "perché" delle regole, non solo il "come"b6f667c (.)

## 2. Struttura della Documentazione

### Documentazione Generica
- Va sempre collocata nella cartella `docs/` del modulo Xot
- Riguarda architettura, convenzioni, pattern generici
- Non contiene riferimenti specifici al progetto

### Documentazione Specifica
- Va collocata nella cartella `docs/` della root del progetto
- Può contenere riferimenti specifici al progetto
- Contiene roadmap, epiche, milestone specifiche

### Documentazione dei Moduli
- Ogni modulo ha la propria cartella `docs/`
- Contiene documentazione tecnica specifica del modulo
- Non deve contenere riferimenti al nome del progetto

## 3. Collegamenti Bidirezionali

### Importanza
- I collegamenti bidirezionali sono fondamentali per la navigabilità
- Ogni documento deve avere collegamenti ad altri documenti correlati
- I collegamenti devono essere mantenuti aggiornati

### Implementazione
- Utilizzare sezioni "Collegamenti" o "Documentazione Correlata"
- Includere collegamenti a moduli correlati
- Mantenere i collegamenti aggiornati quando si sposta o rinomina un documento

## 4. Best Practices

### Aggiornamento
- La documentazione deve essere aggiornata prima di ogni modifica al codice
- Quando si corregge un errore, aggiornare prima la documentazione

### Contenuto
- Concentrarsi sul "perché" e sul "cosa", non solo sul "come"
- Evitare dettagli implementativi che possono cambiare
- Documentare le decisioni architetturali e le motivazioni

### Organizzazione
- Utilizzare titoli e sottotitoli per organizzare il contenuto
- Includere esempi pratici quando possibile
- Mantenere la documentazione concisa e focalizzata

## Note Finali
- La documentazione è una parte fondamentale del progetto
- Una buona documentazione riduce il tempo di onboarding
- La documentazione deve evolversi insieme al codice
- I collegamenti bidirezionali sono essenziali per la navigabilità
