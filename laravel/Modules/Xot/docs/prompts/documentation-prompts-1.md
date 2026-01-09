# Prompt di Documentazione

## Panoramica
Questo documento descrive le regole e le best practices per i prompt di documentazione utilizzati nel progetto.

## Struttura dei Prompt

### Formato
- I prompt devono essere una singola stringa continua
- Non devono contenere formattazione o a capo
- Non devono contenere riferimenti specifici al progetto
- Devono essere generici e riutilizzabili

### Posizione
- I prompt sono collocati in `bashscripts/prompts/`
- Ogni prompt deve avere una documentazione corrispondente
- La documentazione deve essere aggiornata in tempo reale

## Regole di Modifica

### Processo
1. Analizzare l'impatto della modifica
2. Aggiornare la documentazione nei moduli interessati
3. Verificare la coerenza con altre regole
4. Testare l'applicabilità delle modifiche

### Documentazione
- Ogni modifica al prompt deve essere documentata
- La documentazione deve spiegare il "perché" delle regole
- Deve essere aggiornata nelle cartelle docs appropriate
- Deve mantenere i collegamenti bidirezionali

## Best Practices

### Genericità
- Mantenere i prompt generici e riutilizzabili
- Evitare riferimenti specifici al progetto
- Usare termini generici come "il progetto", "l'applicazione", "il sistema"

### Manutenzione
- Documentare le decisioni e le motivazioni
- Aggiornare la documentazione in tempo reale
- Verificare la coerenza con le convenzioni esistenti

### Collegamenti
- Mantenere collegamenti bidirezionali con altri documenti
- Aggiornare i collegamenti quando si sposta o rinomina un documento
- Verificare periodicamente la validità dei collegamenti

## Validazione dei Collegamenti

### Regole Fondamentali
- MAI usare percorsi assoluti nei collegamenti
- MAI includere il nome del progetto nei percorsi
- MAI usare percorsi che iniziano con `/var/www/html/` o simili
- MAI usare percorsi che includono `<nome progetto>` o altri nomi specifici
- MAI usare percorsi che includono `<nome progetto>` o altri nomi specifici

### Formato Corretto
```markdown

# Collegamenti Corretti
[Documento Correlato](../documento.md)
[Documento in Sottodirectory](./sottodirectory/documento.md)
[Documento in Modulo Altro](../../AltroModulo/docs/documento.md)
[Documento in Root](../../../docs/documento.md)
```

### Formato Non Corretto
```markdown

# Collegamenti Non Corretti
[Documento Correlato](/var/www/html/<nome progetto>/laravel/Modules/Xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/<nome progetto>/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](C:\progetti\<nome progetto>\laravel\Modules\Xot\docs\documento.md)
[Documento Correlato](/var/www/html/<nome progetto>/laravel/Modules/Xot/docs/documento.md)
[Documento Correlato](/var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Xot/docs/documento.md)
[Documento in Sottodirectory](https://github.com/<nome progetto>/progetto/blob/main/docs/documento.md)
[Documento in Modulo Altro](C:\progetti\<nome progetto>\laravel\Modules\Xot\docs\documento.md)
```

### Checklist di Validazione
- [ ] Il percorso è relativo alla posizione del file corrente
- [ ] Non contiene riferimenti al nome del progetto
- [ ] Non contiene percorsi assoluti
- [ ] Usa la notazione corretta per i percorsi relativi
- [ ] I percorsi sono compatibili con diversi sistemi operativi

## Esempi

### Prompt Corretto
```
Il sistema di documentazione è una struttura gerarchica modulare dove le cartelle docs dei moduli sono la memoria tecnica specializzata mentre la cartella docs nella root progetto serve come indice centrale con collegamenti bidirezionali...
```

### Prompt Non Corretto
```
Il sistema di documentazione di {nome-progetto} è una struttura gerarchica modulare
dove le cartelle docs dei moduli sono la memoria tecnica specializzata
mentre la cartella docs nella root progetto serve come indice centrale
con collegamenti bidirezionali...
```

## Collegamenti
- [Regole di Documentazione](../documentation_rules.md)
- [Gestione della Documentazione](../DOCUMENTATION_MANAGEMENT.md)
- [Best Practices](../best-practices.md)

## Validazione e Correzione dei Percorsi

### Processo di Validazione
1. **Analisi Iniziale**
   - Identificare tutti i file con percorsi assoluti
   - Verificare la coerenza dei percorsi relativi
   - Controllare i collegamenti bidirezionali

2. **Correzione**
   - Convertire i percorsi assoluti in relativi
   - Rimuovere riferimenti al nome del progetto
   - Aggiornare i collegamenti in tutti i file correlati

3. **Verifica**
   - Testare i collegamenti dopo la correzione
   - Verificare la compatibilità cross-platform
   - Controllare la coerenza della struttura

### Strumenti di Validazione
- markdown-link-check per verificare i collegamenti
- markdownlint per validare la sintassi
- pre-commit hooks per prevenire errori

### Prevenzione degli Errori
1. **Regole Base**
   - MAI usare percorsi assoluti
   - MAI includere il nome del progetto
   - Usare sempre percorsi relativi

2. **Controlli Automatici**
   - Implementare pre-commit hooks
   - Usare strumenti di validazione
   - Verificare periodicamente

3. **Documentazione**
   - Mantenere aggiornate le regole
   - Documentare le correzioni
   - Aggiornare gli esempi
