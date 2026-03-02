# Documentazione

Questo documento serve come indice centrale per tutta la documentazione del progetto.

## Linee Guida Generali
Le linee guida complete per la documentazione sono disponibili in:
- [Linee Guida per la Documentazione](../../../xot/project_docs/guidelines/documentation.md)

## Documentazione per Modulo

### Core
- [Xot Module](../../../xot/docs/readme.md)
- [UI Module](../../../ui/docs/readme.md)
- [CMS Module](../../../cms/docs/readme.md)

### Business
- [Patient Module](../../../patient/docs/readme.md)
- [Dental Module](../../../dental/docs/readme.md)

### Supporto
- [Reporting Module](../../../reporting/docs/readme.md)
- [User Module](../../../user/docs/readme.md)

## Documentazione Tecnica
- [Architettura](../../../xot/docs/architecture/readme.md)
- [API Documentation](../../../xot/docs/api/readme.md)
- [Testing](../../../xot/docs/testing/readme.md)

## Guide e Tutorial
- [Guida all'Installazione](../../../xot/docs/installation.md)
- [Guida allo Sviluppo](../../../xot/docs/development/readme.md)
- [Troubleshooting](../../../xot/docs/troubleshooting/readme.md)

## Risorse Aggiuntive
- [Changelog](../../../xot/docs/changelog/readme.md)
- [Contributing](../../../xot/docs/contributing.md)
- [Security](../../../xot/docs/security.md)
- [Xot Module](../../../xot/project_docs/readme.md)
- [UI Module](../../../ui/project_docs/readme.md)
- [CMS Module](../../../cms/project_docs/readme.md)

### Business
- [Patient Module](../../../patient/project_docs/readme.md)
- [Dental Module](../../../dental/project_docs/readme.md)

### Supporto
- [Reporting Module](../../../reporting/project_docs/readme.md)
- [User Module](../../../user/project_docs/readme.md)

## Documentazione Tecnica
- [Architettura](../../../xot/project_docs/architecture/readme.md)
- [API Documentation](../../../xot/project_docs/api/readme.md)
- [Testing](../../../xot/project_docs/testing/readme.md)

## Guide e Tutorial
- [Guida all'Installazione](../../../xot/project_docs/installation.md)
- [Guida allo Sviluppo](../../../xot/project_docs/development/readme.md)
- [Troubleshooting](../../../xot/project_docs/troubleshooting/readme.md)

## Risorse Aggiuntive
- [Changelog](../../../xot/project_docs/changelog/readme.md)
- [Contributing](../../../xot/project_docs/contributing.md)
- [Security](../../../xot/project_docs/security.md)
# Regole di Documentazione

## Panoramica
Questo documento descrive le regole fondamentali per la creazione e la manutenzione della documentazione tecnica nel progetto.

## Collegamenti

### Documentazione Correlata
- [README](../readme.md) - Panoramica del modulo Xot
- [Convenzioni di Naming](./naming_conventions.md) - Regole di naming per campi, classi e directory
- [Struttura dei Moduli](./module_structure.md) - Convenzioni di struttura dei moduli
- [Prompt di Documentazione](./prompts/documentation_prompts.md) - Regole e best practices per i prompt

## Validazione dei Collegamenti

### Regole Fondamentali
- MAI usare percorsi assoluti nei collegamenti
- MAI includere il nome del progetto nei percorsi
- MAI usare percorsi che iniziano con `documento.md)
[Documento in Sottodirectory](./sottodirectory/documento.md)
[Documento in Modulo Altro](../../altromodulo/docs/documento.md)
[Documento in Root](../../../../../../../../docs/documento.md)
```

### Formato Non Corretto
```markdown

# Collegamenti Non Corretti
[Documento Correlato](../xot/docs/documento.md)
[Documento Correlato](../xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/<nome progetto>/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](c:\progetti\<nome progetto>\laravel\modules\xot\docs\documento.md)
```

### Checklist di Validazione
- [ ] Il percorso è relativo alla posizione del file corrente
- [ ] Non contiene riferimenti al nome del progetto
- [ ] Non contiene percorsi assoluti
- [ ] Usa la notazione corretta per i percorsi relativi
- [ ] I percorsi sono compatibili con diversi sistemi operativi

- [Prompt di Documentazione](./prompts/documentation_prompts.md) - Regole e best practices per i prompt

## Validazione dei Collegamenti

### Regole Fondamentali
- MAI usare percorsi assoluti nei collegamenti
- MAI includere il nome del progetto nei percorsi
- MAI usare percorsi che iniziano con `documento.md)
[Documento in Sottodirectory](./sottodirectory/documento.md)
[Documento in Modulo Altro](../../altromodulo/docs/documento.md)
[Documento in Root](../../../../../../../../docs/documento.md)
```

### Formato Non Corretto
```markdown

# Collegamenti Non Corretti
[Documento Correlato](../xot/docs/documento.md)
[Documento Correlato](../xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/<nome progetto>/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](c:\progetti\<nome progetto>\laravel\modules\xot\docs\documento.md)
```

### Checklist di Validazione
- [ ] Il percorso è relativo alla posizione del file corrente
- [ ] Non contiene riferimenti al nome del progetto
- [ ] Non contiene percorsi assoluti
- [ ] Usa la notazione corretta per i percorsi relativi
- [ ] I percorsi sono compatibili con diversi sistemi operativib6f667c (.)

- [Prompt di Documentazione](./prompts/documentation_prompts.md) - Regole e best practices per i prompt

## Validazione dei Collegamenti

### Regole Fondamentali
- MAI usare percorsi assoluti nei collegamenti
- MAI includere il nome del progetto nei percorsi
- MAI usare percorsi che iniziano con `documento.md)
[Documento in Sottodirectory](./sottodirectory/documento.md)
[Documento in Modulo Altro](../../altromodulo/docs/documento.md)
[Documento in Root](../../../../../../../../docs/documento.md)
```

### Formato Non Corretto
```markdown

# Collegamenti Non Corretti
[Documento Correlato](../xot/docs/documento.md)
[Documento Correlato](../xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/<nome progetto>/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](c:\progetti\<nome progetto>\laravel\modules\xot\docs\documento.md)
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
