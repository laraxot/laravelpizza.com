# Gestione dei Contenuti Tramite File JSON in <nome progetto>

## Introduzione

<nome progetto> utilizza un approccio innovativo per la gestione dei contenuti statici, memorizzandoli in file JSON anziché in tabelle del database. Questo documento spiega il funzionamento di questo sistema, con particolare attenzione alla gestione della homepage.

## Architettura del Sistema

### Componenti Principali

1. **Trait SushiToJsons**
   - Estende il pacchetto Sushi per utilizzare file JSON come fonte di dati
   - Gestisce il caricamento e il salvataggio dei contenuti

2. **TenantService**
   - Determina il percorso corretto dei file in base al tenant attivo
   - Supporta configurazioni specifiche per ogni ambiente

3. **Modello Page**
   - Utilizza SushiToJsons per caricare i contenuti delle pagine
   - Gestisce la struttura dei blocchi di contenuto

### Struttura dei File

I contenuti sono organizzati secondo questa struttura:

```
/var/www/html/<nome progetto>/laravel/config/
└── local/
    └── <nome progetto>/
        └── database/
            └── content/
                ├── pages/
                │   ├── 1.json  # Homepage
                │   ├── 2.json  # Altre pagine
                │   └── ...
                └── menus/
                    └── 1.json  # Menu principale
```

## Gestione della Homepage

La homepage è gestita attraverso il file `/var/www/html/<nome progetto>/laravel/config/local/<nome progetto>/database/content/pages/1.json`.

### Struttura del File

```json
{
    "id": "1",
    "title": {
        "it": "<nome progetto> - Promozione della salute orale per le gestanti"
    },
    "slug": "home",
    "content_blocks": {
        "it": [
            {
                "type": "hero",
                "data": {
                    "view": "ui::components.blocks.hero.simple",
                    "title": "Promozione della salute orale per le gestanti",
                    "subtitle": "Un progetto dedicato alla salute orale delle gestanti in condizioni di vulnerabilità socio-economica",
                    "image": "/img/hero-bg.jpg",
                    "cta_text": "Scopri di più",
                    "cta_link": "#about"
                }
            },
            // Altri blocchi di contenuto...
        ]
    }
}
```

### Processo di Rendering

1. L'utente visita la homepage (`/`)
2. Il controller carica il modello `Page` con slug "home"
3. Il trait `SushiToJsons` legge il file JSON corrispondente
4. I blocchi di contenuto vengono estratti e passati al componente di rendering
5. Ogni blocco viene renderizzato utilizzando il template specificato

## Vantaggi di Questo Approccio

1. **Separazione tra Codice e Contenuti**
   - I contenuti sono separati dal codice applicativo
   - Facilita la manutenzione e l'aggiornamento

2. **Versionamento Semplificato**
   - I contenuti possono essere versionati con git insieme al codice
   - Facilita il rollback in caso di problemi

3. **Performance**
   - Riduce le query al database per contenuti statici
   - Migliora i tempi di risposta per pagine frequentemente visitate

4. **Flessibilità Multiambiente**
   - Ogni ambiente può avere la propria versione dei contenuti
   - Supporta configurazioni diverse per tenant diversi

5. **Facilità di Deployment**
   - I contenuti vengono deployati insieme al codice
   - Non richiede migrazione del database per aggiornare i contenuti

## Modifica dei Contenuti

### Tramite Interfaccia Amministrativa

Il metodo consigliato per modificare i contenuti è utilizzare l'interfaccia amministrativa di Filament:

1. Accedere al pannello di amministrazione
2. Navigare alla sezione "Pagine"
3. Selezionare la homepage
4. Modificare i blocchi di contenuto utilizzando l'editor visuale
5. Salvare le modifiche

### Modifica Diretta dei File JSON

In casi eccezionali, è possibile modificare direttamente i file JSON:

1. Aprire il file JSON corrispondente
2. Modificare i contenuti rispettando la struttura esistente
3. Salvare il file
4. Pulire la cache dell'applicazione

**Attenzione**: La modifica diretta dei file JSON è sconsigliata a meno che non si comprenda completamente la struttura e le implicazioni.

## Best Practices

1. **Utilizzare l'interfaccia amministrativa** per modificare i contenuti quando possibile
2. **Mantenere la coerenza** tra i file JSON e il codice che li utilizza
3. **Testare le modifiche** in ambiente di sviluppo prima di applicarle in produzione
4. **Versionare i contenuti** insieme al codice
5. **Documentare la struttura** dei blocchi di contenuto per facilitare la manutenzione

## Risoluzione dei Problemi

### Contenuti Non Visualizzati

Se i contenuti non vengono visualizzati correttamente:

1. Verificare che il file JSON esista nel percorso corretto
2. Controllare la struttura del file JSON per errori di sintassi
3. Verificare che lo slug della pagina sia corretto
4. Pulire la cache dell'applicazione

### Errori di Rendering

Se i blocchi di contenuto non vengono renderizzati correttamente:

1. Verificare che il componente specificato nel campo `view` esista
2. Controllare che tutti i campi richiesti dal componente siano presenti nel blocco
3. Verificare i permessi di accesso ai file

## Conclusione

Il sistema di gestione dei contenuti tramite file JSON offre un approccio flessibile e performante per gestire i contenuti statici in <nome progetto>. Comprendere questo meccanismo è fondamentale per sviluppare e mantenere efficacemente l'applicazione.
