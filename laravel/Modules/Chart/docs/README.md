# Modulo Chart

Il modulo **Chart** gestisce la visualizzazione e l'analisi di dati tramite grafici e dashboard interattivi. Offre componenti riutilizzabili, API per la generazione di grafici, e strumenti di personalizzazione per dashboard avanzate.

- **Namespace:** `Modules\Chart`
- **Dipendenze:** [Xot](../../Xot/docs/README.md), [Cms](../../Cms/docs/README.md), [UI](../../UI/docs/README.md), [Lang](../../Lang/docs/README.md)

---

## Collegamenti correlati
- [Documentazione <nome progetto>](/docs/README.md)
- [Mappa Documentazione](/docs/collegamenti-documentazione.md)
- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo Cms](../../Cms/docs/README.md)
- [Modulo UI](../../UI/docs/README.md)
- [Tema One](/laravel/Themes/One/docs/README.md)

## Indice Documentazione

- **[jpgraph-deep-dive-and-alternatives.md](./jpgraph-deep-dive-and-alternatives.md)**: ⭐ **NUOVO** - Analisi approfondita JpGraph 4.4.3 (PHP 8.5), caratteristiche complete, confronto con librerie alternative (pChart, ChartDirector, Image-Charts, SVG Charts, ChartLogix), pattern di utilizzo nel progetto, e best practices
- **[jpgraph-complete-guide.md](./jpgraph-complete-guide.md)**: Guida completa JpGraph con esempi pratici, pattern Actions, e workflow completo
- **[jpgraph-step-by-step-guide.md](./jpgraph-step-by-step-guide.md)**: Guida passo-passo per creare grafici JpGraph
- **[filament-5-installation-guide.md](./filament-5-installation-guide.md)**: ⭐ **NUOVO** - Guida completa installazione Filament 5.x e Chart.js plugins
- **[chartjs-datalabels-multiple-labels-complete-guide.md](./chartjs-datalabels-multiple-labels-complete-guide.md)**: ⭐ **NUOVO** - Guida completa "a prova di stupido" per multiple labels con chartjs-plugin-datalabels in Filament 5.x
- **[chart-assets-centralization-rule.md](./chart-assets-centralization-rule.md)**: ⚠️ **CRITICO** - Regola architetturale: centralizzazione asset Chart.js nel modulo Chart (NON registrare in altri moduli)
- [aggiornamenti.md](./aggiornamenti.md): Guida agli aggiornamenti e comandi utili.
- [algolia-docsearch.md](./algolia-docsearch.md): Integrazione e configurazione Algolia DocSearch.
- [bottlenecks.md](./bottlenecks.md): Colli di bottiglia e soluzioni nel modulo Chart.
- [ci.md](./ci.md): Continuous Integration per il modulo Chart.
- [echart.md](./echart.md): Integrazione con ECharts.
- [errori.md](./errori.md): Errori comuni e relative soluzioni.
- [filament.md](./filament.md): Best practice e risorse per l'integrazione con Filament.
- [filament-charts-professional-guide.md](./filament-charts-professional-guide.md): Guida completa Chart.js e JpGraph (aggiornato per Filament 5.x)
- [git-conflicts.md](./git-conflicts.md): Gestione dei conflitti git e best practices.
- [installazione.md](./installazione.md): Guida all'installazione e setup.
- [introduzione.md](./introduzione.md): Introduzione e overview del modulo.
- [lang-link.md](./lang-link.md): Collegamento alle regole di traduzione e risorse Lang.
- **phpstan/:** Configurazioni e fix avanzati per static analysis.
- **phpstan/chart-model-fixes.md:** Correzioni specifiche per errori PHPStan nel modello Chart.
- **query.md:** Ottimizzazione e uso delle query per i grafici.
- [roadmap.md](./roadmap.md): Roadmap di sviluppo e milestone.
- [translations.md](./translations.md): Struttura e best practice per i file di traduzione.

Altri file e directory:
- `/advanced/`, `/components/`: Componenti avanzati e custom.

---

## Descrizione Sintetica dei Documenti Principali

- **aggiornamenti.md:** Comandi per aggiornare il modulo e gestire la cache.
- **algolia-docsearch.md:** Configurazione della ricerca documentale Algolia.
- **ci.md:** Pipeline CI/CD e best practice.
- **echart.md:** Utilizzo di ECharts con Chart.
- **errori.md:** Riferimento rapido agli errori noti.
- **filament.md:** Integrazione con Filament.
- **installazione.md:** Setup e prerequisiti.
- **introduzione.md:** Visione d'insieme del modulo.
- **lang-link.md:** Regole di localizzazione e riferimenti incrociati con Lang.
- **query.md:** Ottimizzazione e uso delle query per i grafici.
- **translations.md:** Esempi e struttura delle traduzioni.

---

## Gestione dei Conflitti Git

Il modulo Chart segue un approccio strutturato per la gestione dei conflitti git. Per dettagli completi, consultare [git-conflicts.md](./git-conflicts.md).

### Principi Chiave
1. Prioritizzazione basata sull'impatto funzionale
2. Coerenza con le convenzioni del progetto
3. Approccio conservativo nella risoluzione
4. Documentazione dettagliata delle decisioni

### File Recentemente Risolti
- `.gitignore`: Unificazione e organizzazione delle regole di esclusione
- `vite.config.js`: Configurazione build e asset management
- `README.md`: Documentazione e collegamenti bidirezionali
## Gestione build assets e output

Gli asset del modulo Chart devono essere generati nella directory `./resources/dist` del modulo. La configurazione di Vite deve includere `emptyOutDir: false` e `manifest: "manifest.json"` per garantire la coerenza con le regole di progetto <nome progetto>.

**Motivazione architetturale:**
- Ogni modulo deve essere autonomo nella gestione degli asset
- Si evitano conflitti con la root del progetto
- Si facilita la manutenzione e la distribuzione modulare

I percorsi storici (es. `Resources/assets/sass/app.scss`) possono essere lasciati commentati nel codice per riferimento, ma non devono essere usati attivamente.

**Collegamenti:**
- [Regole Filament Resources](/docs/regole/filament-resources.md)
- [Collegamenti documentazione](/docs/collegamenti-documentazione.md)

---

## Collegamenti Bidirezionali

Tutti i documenti elencati sopra devono contenere una sezione di ritorno a questo README e agli altri documenti principali:

- [README Chart](./README.md)
- [aggiornamenti.md](./aggiornamenti.md)
- [algolia-docsearch.md](./algolia-docsearch.md)
- [bottlenecks.md](./bottlenecks.md)
- [ci.md](./ci.md)
- [echart.md](./echart.md)
- [errori.md](./errori.md)
- [filament.md](./filament.md)
- [git-conflicts.md](./git-conflicts.md)
- [installazione.md](./installazione.md)
- [introduzione.md](./introduzione.md)
- [lang-link.md](./lang-link.md)
- [query.md](./query.md)
- [roadmap.md](./roadmap.md)
- [translations.md](./translations.md)

> **Nota:** Aggiorna sempre l'indice e i collegamenti incrociati quando aggiungi nuovi file nella cartella docs/.

---

## Collegamenti ad altri moduli

- [Modulo Xot](../../Xot/docs/README.md)
- [Modulo Cms](../../Cms/docs/README.md)
- [Modulo UI](../../UI/docs/README.md)
- [Modulo Lang](../../Lang/docs/README.md)

---

_Per contribuire alla documentazione:_
1. Segui le convenzioni di naming e struttura.
2. Aggiorna sempre i collegamenti bidirezionali.
3. Documenta le modifiche in modo chiaro.
4. Mantieni alta la qualità e la leggibilità.
## Panoramica
Il modulo Chart fornisce funzionalità avanzate per la creazione e gestione di grafici all'interno dell'applicazione. Supporta diversi tipi di grafici e si integra con Filament per una gestione semplificata.

## Indice
- [Installazione](./installazione.md)
- [Filament Integration](./filament.md)
- [Bottlenecks](./bottlenecks.md)
- [Roadmap](./roadmap.md)
- [PHPStan](./phpstan/README.md)
- [PHPStan Usage](./phpstan-usage.md)
- [Gestione Conflitti Git](./git-conflicts.md)
- [Errori Comuni](./errori.md)
- [Soluzioni](./solutions.md)

## Struttura
```
Chart/
├── app/
│   ├── Actions/         # Azioni per la generazione grafici
│   ├── Filament/       # Risorse e widget Filament
│   ├── Models/         # Modelli dati
│   └── Providers/      # Service providers
├── config/            # Configurazione modulo
├── database/         # Migrazioni e seeders
├── resources/        # Asset e viste
└── docs/            # Documentazione
```

## Funzionalità Principali

### Tipi di Grafici Supportati
- Line Charts
- Bar Charts
- Pie Charts
- Area Charts
- Mixed Charts
- Custom Charts

### Integrazione Filament
- Resources per gestione grafici
- Widget per dashboard
- Form components
- Custom actions

### Personalizzazione
- Temi personalizzabili
- Configurazione avanzata
- Export in vari formati
- Responsive design

## Dipendenze
- Modulo Xot
- Modulo UI
- Modulo Lang
- Laravel Framework >= 11.28
- PHP >= 8.2
- Filament v5.0+
- **Tailwind CSS v4.1+** (⚠️ CRITICO - Filament 5.x richiede v4.1+, NON compatibile con v3.x)

## Configurazione

### Installazione
```bash
composer require modules/chart
php artisan module:enable Chart
php artisan migrate
```

### Pubblicazione Assets
```bash
php artisan vendor:publish --tag=chart-config
php artisan vendor:publish --tag=chart-views
```

## Best Practices

### Creazione Grafici
1. Utilizzare le Actions dedicate
2. Implementare caching dove possibile
3. Ottimizzare query dati
4. Seguire convenzioni naming

### Performance
1. Lazy loading dei dati
2. Caching risultati
3. Ottimizzazione assets
4. Monitoraggio metriche

## Testing

### Unit Tests
```bash
php artisan test --filter=ChartTest
```

### Feature Tests
```bash
php artisan test --filter=ChartFeatureTest
```

## Sicurezza
- Validazione input
- Sanitizzazione output
- Rate limiting
- Permessi granulari

## Troubleshooting
- [Errori Comuni](./errori.md)
- [Soluzioni](./solutions.md)
- [PHPStan](./phpstan/README.md)
- [PHPStan Usage](./phpstan-usage.md)

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Modulo UI](../UI/docs/README.md)
- [Modulo Lang](../Lang/docs/README.md)
- [Modulo Xot](../Xot/docs/README.md)

### Collegamenti Interni
- [Documentazione API](./advanced/api.md)
- [Contribuire](./advanced/contributing.md)

## Contribuire
- Fork del repository
- Creazione branch (`git checkout -b feature/amazing-charts`)
- Commit modifiche (`git commit -am 'Add: nuovi tipi di grafici'`)
- Push branch (`git push origin feature/amazing-charts`)
- Creazione Pull Request

## Licenza
Questo modulo è rilasciato sotto licenza MIT.

## Autori
- Team di sviluppo principale
- Contributori della community

## Supporto
Per supporto e domande, contattare il team di sviluppo.
## Analisi Funzionalità Mancanti

Per un'analisi completa delle funzionalità mancanti rispetto a LimeSurvey upstream, consultare:

- **[missing-features-analysis.md](./missing-features-analysis.md)** - Analisi dettagliata funzionalità mancanti nel modulo Chart

**Principali aree da implementare**:
1. Chart Types Completi (radar, scatter, heatmaps, etc.)
2. Chart Customization Avanzata (temi, palette, animazioni)
3. Chart Export Avanzato (PDF, Excel, PowerPoint)
4. Chart Analytics & Insights (trend detection, anomaly detection)
5. Real-time Charts (WebSocket, live updates)
6. Chart Performance Optimization (lazy loading, virtualization)
7. Chart Accessibility (WCAG 2.1, screen reader, keyboard navigation)

## 🔗 Collegamenti
- [Documentazione Xot](../Xot/docs/README.md)
- [Documentazione Cms](../Cms/docs/README.md)
- [Documentazione UI](../UI/docs/README.md)
- [Documentazione Traduzioni](../Lang/docs/README.md) 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

---

## Server MCP consigliati per Chart

Per il modulo Chart, si consiglia di utilizzare i seguenti server MCP:

- **sequential-thinking**: per orchestrare pipeline di generazione grafici, analisi step-by-step e automazione di processi di visualizzazione dati.
- **memory**: per mantenere una knowledge base di dataset, configurazioni di grafici e risultati di analisi.
- **filesystem**: per esportare grafici, importare dataset o salvare configurazioni di visualizzazione.
- **postgres**: se il modulo utilizza un database PostgreSQL per archiviare dati da visualizzare o analizzare.
- **puppeteer**: per automatizzare la generazione di screenshot di grafici, esportazione in PDF o scraping di dati da dashboard web.

**Nota:**
- Usa solo server MCP Node.js disponibili su npm e avviabili con `npx`.
- Configura sempre gli argomenti obbligatori (es. directory per filesystem, stringa di connessione per postgres).
- Non usare fetch, mysql o redis se non attivo.

Per dettagli e best practice consulta la guida generale MCP nel workspace.
