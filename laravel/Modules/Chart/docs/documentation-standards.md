# Standard di Documentazione <nome progetto>

## Collegamenti Correlati
- [Collegamenti Documentazione](./collegamenti-documentazione.md)
- [Regole Documentazione](./regole-documentazione.md)
- [Linee Guida Documentazione](./linee-guida-documentazione.md)
- [Convenzioni Collegamenti](./convenzioni_collegamenti.md)

## Regole Fondamentali

### 1. Struttura della Documentazione
- **Root docs**: Documentazione generale e indice `/var/www/html/<nome progetto>/docs/`
- **Docs moduli**: Documentazione specifica per modulo `/var/www/html/<nome progetto>/laravel/Modules/*/docs/`
- **Docs temi**: Documentazione specifica per tema `/var/www/html/<nome progetto>/laravel/Themes/*/docs/`

### 2. Collegamenti Bidirezionali
- Ogni documento deve avere collegamenti bidirezionali ai documenti correlati
- Tutti i documenti devono essere referenziati nel file centrale [collegamenti-documentazione.md](./collegamenti-documentazione.md)
- I collegamenti tra documenti correlati devono essere mantenuti sincronizzati

### 3. Percorsi Relativi
- **MAI utilizzare percorsi assoluti** come `/var/www/html/<nome progetto>/...`
- Utilizzare sempre percorsi relativi per i collegamenti tra documenti:
  - Stesso modulo, stessa cartella: `./ALTRO_FILE.md`
  - Stesso modulo, sottocartella: `./subcartella/ALTRO_FILE.md`
  - Stesso modulo, cartella superiore: `../ALTRO_FILE.md`
  - Da un modulo ad un altro: `../../AltroModulo/docs/FILE.md`
  - Da un modulo alla root docs: `../../../../docs/FILE.md`
  - Dalla root docs a un modulo: `../laravel/Modules/NomeModulo/docs/FILE.md`

### 4. README.md di Ogni Modulo
- Deve contenere una panoramica del modulo
- Deve includere collegamenti a tutti i documenti principali del modulo
- Deve avere collegamenti alla documentazione centrale e agli altri moduli
- Deve seguire la struttura standardizzata (vedere [struttura README](#struttura-readme))

### 5. Aggiornamento della Documentazione
- La documentazione deve essere aggiornata ogni volta che viene modificato il codice correlato
- Verificare che tutti i collegamenti funzionino dopo ogni aggiornamento
- Aggiornare sia la documentazione specifica che quella centrale

## Struttura README

Ogni file README.md di un modulo deve seguire questa struttura:

```markdown

# Modulo NomeModulo

## Panoramica
Breve descrizione del modulo e delle sue responsabilità principali.

## Struttura
Descrizione della struttura del modulo (componenti principali, file, directory).

## Documentazione
Lista dei documenti disponibili, organizzati per categorie.

### Core
- [Struttura del Modulo](./structure.md)
- [Eventi](./events.md)
- ...

### [Altre Categorie]
- ...

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Collegamenti alla documentazione centrale]

### Collegamenti ai Moduli
- [Collegamenti ad altri moduli correlati]

## Standard e Convenzioni
- [Standard specifici del modulo]

## Regole e Best Practices
- [Regole specifiche del modulo]
```

## Implementazione

1. Esaminare ogni cartella docs dei moduli
2. Aggiornare i README.md secondo lo standard
3. Verificare e correggere tutti i collegamenti
4. Aggiornare il file collegamenti-documentazione.md centrale
5. Consolidare i documenti duplicati o obsoleti

## Regole di Manutenzione

- Aggiornare la documentazione prima di implementare modifiche al codice
- Verificare i collegamenti dopo ogni aggiornamento
- Mantenere la struttura standardizzata
- Seguire le convenzioni di naming e formattazione
