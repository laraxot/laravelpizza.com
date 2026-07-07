---
module: Xot
concept: services-to-actions-migration
last_updated: 2026-06-30
---

# Migrazione app/Services -> Spatie QueueableAction (sessione 2026-06-30)

Contesto: audit ponytail ha trovato 33 classi in `Modules/Xot/app/Services/`,
in contrasto con la regola viva del progetto "niente Services/Jobs per logica
di dominio, usare sempre Spatie QueueableAction". Xot e' il modulo base:
ogni Service puo' essere chiamato da QUALSIASI altro modulo, quindi ogni
migrazione e' stata preceduta da un grep repo-wide (`laravel/Modules/*`,
`laravel/Themes/*`, `bashscripts/`) sulla FQCN esatta
(`Modules\Xot\Services\NomeClasse`), non solo sul nome breve della classe
(per evitare falsi positivi con classi omonime in altri moduli, es.
`ThemeService` esiste anche in `Modules/UI` e `Themes/Sixteen` come classi
distinte e non e' stato toccato nulla li').

## Migrati a QueueableAction (chiamanti aggiornati)

| Service (.bak) | Azione/i create | Chiamanti aggiornati |
|---|---|---|
| `UrlService::checkValidUrl()` | `Actions/Url/IsValidUrlAction` | Nessun chiamante esterno (solo test interno Xot, riscritto) |
| `ThemeService::{setTheme,getTheme,isTheme,getThemePath}()` | `Actions/Theme/{SetThemeAction,GetThemeAction,IsThemeAction,GetThemePathAction}` | `Modules/Cms/app/Http/Livewire/Page/Show.php` (2 call site), test interno Xot riscritto |
| `HtmlService::toPdf()` | `Actions/Html/HtmlToPdfAction` | `Modules/Notify/app/Actions/NotifyTheme/Attachment/Pdf.php`, relativo `PdfTest.php` (asserzione sul testo del file sorgente aggiornata) |

Nota tecnica: `HtmlToPdfAction` e' un porting 1:1 della logica Spipu
Html2Pdf gia' presente in `HtmlService`, NON un wrapper verso
`Actions/Pdf/PdfByHtmlAction` gia' esistente: quest'ultimo ha un proprio
problema preesistente non in scope (doppio `PdfEngineEnum` con lo stesso
nome in `Actions/Pdf/PdfEngineEnum.php` e in `Enums/PdfEngineEnum.php`),
da sistemare separatamente prima di farci dipendere altro codice.

`ThemeService` usava sia una proprieta' statica privata sia
`Config::set('theme.active', ...)` come doppio stato ridondante; le nuove
Action usano solo `Config` come unica fonte di verita' (comportamento
equivalente per tutti i chiamanti reali trovati).

## Archiviati in .bak senza creare una nuova Action (codice morto/duplicato, zero chiamanti reali)

| Service (.bak) | Motivazione |
|---|---|
| `ConfigService` | Solo boilerplate singleton (`getInstance`/`make`), nessuna logica, zero chiamanti reali nel repo (solo esempi in doc obsoleti) |
| `XotService::getTenantClass()` | Duplicato morto di `XotData::getTenantClass()`, che e' il metodo realmente usato ovunque (`User`, `Filament`, ecc.). Esisteva gia' un `XotService.php.no` accanto al file attivo, segno di un tentativo di disattivazione precedente mai completato |
| `ArrayService` | 2 metodi statici (`rangeIntersect`, `diff_assoc_recursive`) con zero chiamate attive nel repo; i 6 file che lo importavano lo fanno con `// use ...` commentato, nessuna chiamata reale |
| `ProfileTest` | Classe di debug (`hello()`, `hasArea()`, `isSuperAdmin()` hardcoded a `true`) senza alcun chiamante, non e' logica di dominio |

## Lasciati intatti (da pianificare separatamente)

| Service | Chiamanti trovati | Motivo per cui NON e' stato forzato |
|---|---|---|
| `ArtisanService` (308 righe) + `Artisan/CommandRegistry`, `Artisan/Contracts/CommandHandlerInterface`, `Artisan/Handlers/*` (8 handler) | Solo interno a Xot (8 Handlers + test), nessun chiamante esterno trovato, ma accoppiamento interno alto (pattern Handler/Registry gia' in atto) | Esplicitamente segnalato come rischioso nel task; 308 righe, troppo per una sessione "quality over quantity" |
| `RouteService` (353 righe, `inAdmin()`, `urlAct()`, ecc.) | `Modules/Tenant/app/Services/Config/Resolvers/MorphMapConfigResolver.php` (`RouteService::inAdmin()`), piu' riferimenti `RouteService::inAdmin()` documentati in `Modules/Tenant/docs/helper-functions-dependency.md` come wrapper di helper globali | Multi-responsabilita', chiamato da modulo esterno critico (Tenant/morph_map), nessun caso di test che copra `urlAct()`: rischio alto di rottura silenziosa |
| `ModuleService::getModels()` | Zero chiamanti esterni, ma 2 file di test interni Xot (`tests/Unit/ModuleServiceTest.php` + `tests/Feature/ModuleServiceIntegrationTest.php`, ~25 test) verificano direttamente forma/costruttore della classe `ModuleService` | Riscrivere ~25 test per adattarli a una Action e' un lavoro a se', fuori budget "5-8 conversioni di qualita'" di questa sessione |
| `Services/Translators/*` (`BaseTranslator`, `Apertium`, `DeepL`, `Google`, `MyMemory`, `Systran`) | Zero chiamanti trovati ovunque nel repo, nemmeno internamente a Xot | Probabile codice morto/mai cablato; va verificato con un grep dedicato su config/binding dinamici prima di archiviare, non e' bastato il tempo in questa sessione |
| `Services/Trend/Adapters/*` (`AbstractAdapter`, `MySqlAdapter`, `PgsqlAdapter`, `SqliteAdapter`) | Zero chiamanti trovati ovunque nel repo | Stesso discorso di Translators: probabile codice morto, da verificare a parte |

## Blocco infrastrutturale incontrato

Durante la sessione il disco root dell'host (`/dev/nvme0n1p6`, 460G) e'
arrivato al 100% di utilizzo (free sceso fino a pochi MB, in oscillazione),
verosimilmente per attivita' parallela di altri agenti sullo stesso host
(Geo/Notify/User/Predict in lavoro contemporaneo, come da contesto del
task). Questo ha causato fallimenti intermittenti `ENOSPC` su tool di
scrittura/esecuzione. Per prudenza la quality gate completa
(PHPStan livello 10, PHPMD, PHPInsights, Pest) NON e' stata eseguita in
questa sessione: i file toccati sono stati verificati solo con `php -l`
(nessun errore di sintassi). **Va rieseguita la quality gate completa su
`Modules/Xot`, `Modules/Notify`, `Modules/Cms` non appena lo spazio disco
torna disponibile**, prima di considerare questo lavoro mergeable.
