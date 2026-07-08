# Percorsi Relativi nella Documentazione

## Errore Comune da Evitare

Un errore grave nella documentazione è l'uso di **percorsi assoluti** come:
```markdown
[Nome Link](../../percorso/al/file.md)
```

Questi percorsi **non sono portabili** e causeranno errori quando il progetto viene spostato o distribuito ad altri sviluppatori.

## Soluzione: Percorsi Relativi

Usa **sempre** percorsi relativi, calcolati in base alla posizione del file sorgente e destinazione.

### Esempi di Percorsi Relativi Corretti

1. **Stesso modulo, stessa cartella**:
   ```markdown
   [Link File](./ALTRO_FILE.md)
   ```

2. **Stesso modulo, sottocartella**:
   ```markdown
   [Link File](./subcartella/ALTRO_FILE.md)
   ```

3. **Stesso modulo, cartella superiore**:
   ```markdown
   [Link File](../ALTRO_FILE.md)
   ```

4. **Da un modulo ad un altro modulo**:
   ```markdown
   [Link File](../../../AltroModulo/docs/FILE.md)
   ```

5. **Da un modulo alla root docs**:
   ```markdown
   [Link File](../../../../docs/FILE.md)
   ```

6. **Dalla root docs a un modulo**:
   ```markdown
   [Link File](../laravel/Modules/NomeModulo/docs/FILE.md)
   ```

## Come Calcolare i Percorsi Relativi

1. Identifica la posizione del file sorgente (dove stai aggiungendo il link)
2. Identifica la posizione del file destinazione (dove vuoi linkare)
3. Calcola quante cartelle "su" devi andare (`../`) per raggiungere un punto comune
4. Aggiungi il percorso verso il file destinazione

### Esempio Pratico

Se stai creando un link da:
- `./docs/PROMPTS_DOCUMENTATION_SYSTEM.md`

a:
- `../../laravel/Modules/Xot/docs/DOCUMENTATION_PROMPT_SYSTEM.md`

Il calcolo è:
1. Risalire fino alla root del progetto (richiede `../../`)
2. Scendere in `laravel/Modules/Xot/docs/DOCUMENTATION_PROMPT_SYSTEM.md`

Quindi il link corretto sarà:
```markdown
[Sistema di Prompt in Xot](../../laravel/Modules/Xot/docs/DOCUMENTATION_PROMPT_SYSTEM.md)
```

## Tag e Categorizzazione

Oltre ai percorsi relativi, usa tag appropriati per categorizzare:
- `#modulo-{nomemodulo}` per contenuti specifici del modulo
- `#categoria-{nomecategoria}` per categorie specifiche
- `#root-{nomecategoria}` per collegamenti alla documentazione root

## Collegamenti Bidirezionali

Assicurati sempre che i link siano bidirezionali:
1. Se crei un link da A a B, crea anche un link da B ad A
2. Utilizza titoli coerenti in entrambe le direzioni

## Verifica dei Percorsi

Prima di committare modifiche alla documentazione:
1. Verifica che tutti i link utilizzino percorsi relativi
2. Clicca sui link nella tua IDE per assicurarti che funzionino correttamente
3. Considera l'impatto di un eventuale spostamento dei file

## Analisi dell'Errore Comune

### Perché si verifica l'errore dei percorsi assoluti?

1. **Mancata analisi del contesto**: Non studiare a fondo la struttura della documentazione esistente prima di effettuare modifiche
2. **Copy-paste acritico**: Copiare link senza adattarli al contesto
3. **Facilità apparente**: I percorsi assoluti sembrano più semplici perché non richiedono calcoli relativi
4. **IDE automatica**: Alcuni suggerimenti automatici propongono percorsi assoluti

### Come prevenire questo errore

1. **Studio preliminare**: Prima di qualsiasi modifica, esaminare attentamente la struttura della documentazione e le convenzioni esistenti
2. **Verifica degli esempi**: Cercare esempi di collegamenti simili già implementati nel progetto
3. **Calcolo consapevole**: Prendere il tempo di contare i livelli di directory e calcolare i percorsi relativi
4. **Test dei link**: Verificare che i link funzionino cliccandoli nell'IDE prima di committare

### Procedura per la correzione di link errati

1. Identificare tutti i file che contengono percorsi assoluti
2. Per ciascun file, calcolare i percorsi relativi corretti
3. Aggiornare i link mantenendo il testo descrittivo originale
4. Documentare la correzione nella cartella docs più vicina
5. Aggiornare i link bidirezionali correlati

## Collegamenti Correlati

- [Sistema di Prompt](./PROMPTS_DOCUMENTATION_SYSTEM.md)
- [Collegamenti della Documentazione](../../docs/collegamenti-documentazione.md)
- [Linee Guida per la Documentazione di Xot](../../laravel/Modules/Xot/docs/DOCUMENTATION-GUIDELINES.md)
