# Gestione degli Assets dei Temi

## Documentazione Dettagliata

- [Tema One - Gestione Assets](../../../Themes/One/docs/theme-assets.md)
- [Tema One - Processo di Build](../../../Themes/One/docs/build-process.md)
- [Tema One - Assets](../../../Themes/One/docs/ASSETS.md)

## Punti Critici

1. **Script di Build**
   - Lo script `copy` è FONDAMENTALE per il funzionamento dei temi
   - Non deve mai essere rimosso o modificato senza comprensione completa
   - È necessario per la sincronizzazione degli assets

2. **Struttura delle Directory**
   - Gli assets compilati devono essere in `public_html/themes/{ThemeName}`
   - La struttura deve essere mantenuta per il corretto funzionamento
   - I permessi devono essere configurati correttamente

3. **Processo di Build**
   - Seguire sempre il processo documentato
   - Verificare la corretta esecuzione degli script
   - Testare il caricamento degli assets

## Best Practices

1. **Sviluppo**
   - Utilizzare `npm run dev` seguito da `npm run copy`
   - Verificare il corretto caricamento degli assets
   - Mantenere la documentazione aggiornata

2. **Produzione**
   - Eseguire `npm run build` seguito da `npm run copy`
   - Verificare la presenza e l'accessibilità degli assets
   - Testare il funzionamento completo del tema

3. **Manutenzione**
   - Controllare regolarmente gli assets
   - Aggiornare la documentazione quando necessario
   - Mantenere i collegamenti tra i documenti

## Integrazione con il CMS

1. **Struttura degli Assets**
   - Gli assets dei temi devono essere in `public_html/themes/{ThemeName}`
   - Il CMS cerca gli assets in questa posizione
   - Lo script `copy` è FONDAMENTALE per mantenere questa struttura

2. **Caricamento degli Assets**
   - Il CMS utilizza i percorsi relativi per caricare gli assets
   - La struttura delle directory deve essere mantenuta
   - Gli assets devono essere accessibili via web

3. **Gestione dei Temi**
   - Ogni tema ha la sua pipeline di build
   - Gli assets vengono compilati separatamente
   - Lo script `copy` sincronizza gli assets con la directory pubblica

## Best Practices per il CMS

1. **Sviluppo Temi**
   - Seguire la struttura documentata
   - Utilizzare gli script di build corretti
   - Mantenere la sincronizzazione degli assets

2. **Integrazione**
   - Verificare i percorsi degli assets
   - Testare il caricamento nel CMS
   - Controllare la compatibilità

3. **Manutenzione**
   - Aggiornare regolarmente gli assets
   - Verificare l'integrità dei file
   - Mantenere la documentazione aggiornata

## Troubleshooting

1. **Assets non trovati**
   - Verificare l'esecuzione dello script `copy`
   - Controllare i permessi delle directory
   - Verificare i percorsi nel CMS

2. **Errori di Caricamento**
   - Controllare la struttura delle directory
   - Verificare la compilazione degli assets
   - Testare l'accessibilità via web

3. **Problemi di Cache**
   - Pulire la cache del browser
   - Aggiornare la cache del CMS
   - Verificare i timestamp dei file 

## Collegamenti tra versioni di assets.md
* [assets.md](laravel/Modules/Xot/docs/assets.md)
* [assets.md](laravel/Modules/Cms/docs/themes/assets.md)
* [assets.md](laravel/Themes/One/docs/assets.md)

