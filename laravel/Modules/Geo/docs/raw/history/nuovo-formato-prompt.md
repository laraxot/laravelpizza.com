# Nuovo Formato Proposto per il File di Prompt

Il seguente formato propone una ristrutturazione completa del file di prompt `docs.txt` per migliorarne la leggibilità, l'organizzazione e l'efficacia:

```











# SISTEMA DI DOCUMENTAZIONE MODULARE

## 1. PRINCIPI FONDAMENTALI

- Il sistema di documentazione è una struttura gerarchica modulare
- Le cartelle `docs` dei moduli contengono memoria tecnica specializzata
- La cartella `docs` nella root è un indice centrale con collegamenti bidirezionali
- Prima di ogni intervento, analizza tutte le cartelle docs per comprendere l'architettura

## 2. PROCEDURA DI AGGIORNAMENTO

1. ANALIZZA la documentazione esistente nei moduli coinvolti
2. AGGIORNA prima la documentazione nei moduli appropriati
3. CREA/AGGIORNA collegamenti bidirezionali nella root
4. AGGIORNA le configurazioni IDE (.windsurf/rules, .cursor/rules, .cursor/memories)
5. VERIFICA la coerenza della documentazione aggiornata

## 3. REGOLE PER I PERCORSI

- UTILIZZA SEMPRE PERCORSI RELATIVI nei link di documentazione
- MAI utilizzare percorsi assoluti come '/var/www/html/...'
- MAI includere il nome del progetto nei percorsi

### Formati corretti:
- Dalla root a modulo: `./laravel/Modules/Xot/docs/README.md`
- Da modulo ad altro modulo: `../../../AltroModulo/docs/README.md`
- Da modulo a root: `../../../../docs/README.md`

## 4. ORGANIZZAZIONE DEI CONTENUTI

Distribuisci documenti per competenza:
- Documentazione generica: Modulo Xot
- Specifiche progetto: Root (solo indice con link)
- Frontend: Modulo Cms
- Componenti UI: Modulo UI
- Gestione utenti: Modulo User
- Multitenant: Modulo Tenant
- Traduzioni: Modulo Lang
- Media: Modulo Media
- Notifiche: Modulo Notify
- Reportistica: Modulo Reporting
- Conformità GDPR: Modulo Gdpr
- Job asincroni: Modulo Job
- Grafici: Modulo Chart

## 5. NAMESPACE E STRUTTURA

- Segui PSR-4 con namespace modulari: `Modules\\{Nome}\\`
- NON usare: `Modules\\{Nome}\\app\\`
- Il namespace per componenti Filament è: `Modules\\{Nome}\\Filament`
- NON usare: `Modules\\{Nome}\\App\\Filament`
- Il percorso corretto per Provider nei moduli è `/app/Providers/`

## 6. REGOLE FILAMENT E COMPONENTI UI

### XotBaseResource:
- Non ridefinire $navigationIcon, $navigationGroup, $navigationSort
- Non ridefinire getNavigationLabel(), getPluralModelLabel(), getModelLabel()
- Rimuovi getRelations() se restituisce array vuoto
- Rimuovi getPages() se contiene solo route standard
- getFormSchema() deve usare array associativi con chiavi stringa

### XotBaseListRecords:
- Rimuovi getActions() se restituisce solo createAction()
- Rimuovi getTableBulkActions() se restituisce solo DeleteBulkAction
- Includi sempre ...parent::getTableActions() se aggiungi azioni personalizzate

### Traduzioni e Label:
- NON usare mai ->label() in Filament
- Usa traduzioni in lang/{locale}
- Segui la convenzione: modulo::risorsa.fields.campo.label

### Componenti Frontend:
- Usa sempre componenti nativi Filament
- Dropdowns: NON usare componenti inesistenti come x-filament::dropdown.list.separator
- Per separatori in dropdown: <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
- Layout corretti: <x-layouts.app> e <x-layouts.guest>
- La direttiva @volt deve essere SEMPRE la prima cosa nel file Folio

## 7. URL E ROUTING

- Usa mcamara/laravel-localization con LaravelLocalization::getCurrentLocale()
- Tutti gli URL devono includere il prefisso lingua: /{locale}/{sezione}/{risorsa}
- MAI creare rotte aggiungendole in web.php
- Filament e Folio gestiscono automaticamente le rotte
- MAI creare controller personalizzati
- Per business logic asincrona usa spatie/laravel-queueable-action

## 8. BEST PRACTICES

- Documenta decisioni architetturali enfatizzando il "perché"
- Ogni modifica al codice richiede aggiornamento della documentazione
- Mantieni coerenza tra codice e docs
- Garantisci retrocompatibilità quando possibile
- Documenta breaking changes
- Ottimizza per accessibilità, sicurezza e prestazioni
- Il percorso pubblico corretto è public_html/ nella root
- In vite.config.js: emptyOutDir: false, manifest: 'manifest.json', build.outDir: './public'
- Usa Modules\\Xot\\Contracts\\UserContract invece di riferimenti diretti a User
- Per ottenere la classe User configurata usa XotData::make()->getUserClass()

## 9. CONFIGURAZIONE IDE

- Prima di implementare correzioni, verifica e aggiorna:
  1. Le regole in .windsurf/rules e .cursor/rules
  2. Le memorie in .cursor/memories
  3. Documenta in modo permanente la soluzione
```

## Implementazione

Questo formato:

1. Organizza le informazioni in **sezioni tematiche** con intestazioni chiare
2. Utilizza **elenchi puntati** e numerati per migliorare la leggibilità
3. **Raggruppa le informazioni correlate** in sezioni logiche
4. Elimina le **ridondanze** e ripetizioni
5. Include una sezione dedicata alle **configurazioni IDE**
6. Fornisce un chiaro **flusso di lavoro** per l'aggiornamento della documentazione

## Collegamenti Correlati

- [Analisi e Miglioramento del Sistema di Prompt](./ANALISI_MIGLIORAMENTO_PROMPT.md)
- [Sistema di Prompt](./PROMPTS_DOCUMENTATION_SYSTEM.md)
- [Percorsi Relativi nella Documentazione](./PERCORSI_RELATIVI_DOCUMENTAZIONE.md)
- [Regole per la Configurazione degli IDE](./REGOLE_IDE_CONFIGURAZIONE.md)
