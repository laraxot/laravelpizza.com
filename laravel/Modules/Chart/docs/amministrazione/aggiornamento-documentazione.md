# Aggiornamento Documentazione

Questo documento descrive come mantenere aggiornata la documentazione del progetto il progetto, utilizzando lo script automatico fornito.

## Script di Aggiornamento

Il progetto include uno script automatico per aggiornare la documentazione: `update-docs.sh`.

### Cosa fa lo script

Lo script esegue le seguenti operazioni:

1. **Aggiorna l'elenco dei moduli installati**
   - Genera un file `moduli-installati.md` con tutti i moduli attualmente presenti
   - Include descrizioni e dipendenze estratte dai file `module.json`
   - Aggiunge link alla documentazione specifica dei moduli, se disponibile

2. **Crea un sommario aggiornato**
   - Genera un file `sommario.md` che elenca tutti i file di documentazione
   - Estrae automaticamente i titoli da ogni file
   - Organizza i link in ordine alfabetico

3. **Verifica link rotti**
   - Controlla tutti i link interni nella documentazione
   - Segnala eventuali link rotti nel file di log

4. **Aggiorna il README principale**
   - Aggiunge o aggiorna la data dell'ultimo aggiornamento
   - Mantiene il resto del contenuto invariato

5. **Genera un changelog**
   - Crea un nuovo file nella directory `changelog`
   - Registra tutte le modifiche effettuate
   - Include dettagli sui moduli installati

### Come utilizzare lo script

Per eseguire lo script e aggiornare automaticamente la documentazione:

```bash
cd /var/www/html/<nome progetto>
./docs/update-docs.sh
```

Lo script genererà un file di log dettagliato in `docs/aggiornamento_log.txt`.

## Quando aggiornare la documentazione

È consigliato aggiornare la documentazione nei seguenti casi:

1. **Dopo l'installazione di nuovi moduli**
   - Per mantenere aggiornato l'elenco dei moduli installati
   - Per generare link alla loro documentazione specifica

2. **Dopo modifiche significative al codice**
   - Per assicurarsi che la documentazione rifletta lo stato attuale del progetto
   - Per aggiornare eventuali informazioni obsolete

3. **Prima di un rilascio**
   - Per verificare che tutta la documentazione sia aggiornata
   - Per assicurarsi che non ci siano link rotti

4. **Periodicamente (ad es. settimanalmente)**
   - Per mantenere la documentazione sempre aggiornata
   - Per identificare eventuali problemi

## Manutenzione Manuale

Oltre all'aggiornamento automatico, è importante mantenere manualmente la documentazione:

1. **Aggiungere documentazione per nuove funzionalità**
   - Ogni nuova funzionalità dovrebbe essere documentata
   - Seguire le [Linee Guida Documentazione](linee-guida-documentazione.md)

2. **Aggiornare la documentazione esistente**
   - Quando vengono apportate modifiche a funzionalità esistenti
   - Quando vengono identificati errori o imprecisioni

3. **Rivedere la documentazione generata automaticamente**
   - Verificare che il sommario sia completo
   - Controllare l'elenco dei moduli installati
   - Risolvere eventuali link rotti segnalati

## Pianificazione degli Aggiornamenti

È possibile automatizzare ulteriormente l'aggiornamento della documentazione utilizzando un job cron:

```bash

# Esempio: aggiornamento settimanale ogni lunedì alle 9:00
0 9 * * 1 /var/www/html/<nome progetto>/docs/update-docs.sh >> /var/www/html/<nome progetto>/docs/cron_log.txt 2>&1
```

## Risoluzione dei Problemi

Se lo script di aggiornamento incontra problemi:

1. **Verificare i permessi**
   - Assicurarsi che lo script abbia i permessi di esecuzione
   - Controllare i permessi di scrittura nella directory `docs`

2. **Controllare il log**
   - Esaminare il file `aggiornamento_log.txt` per identificare errori specifici
   - Risolvere eventuali problemi segnalati

3. **Verificare la struttura dei file**
   - Assicurarsi che la struttura delle directory sia corretta
   - Controllare che i file module.json siano validi

4. **Aggiornamento manuale**
