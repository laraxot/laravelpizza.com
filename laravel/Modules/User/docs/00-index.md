---
title: "User, indice dei documenti e a cosa servono"
type: index
status: active
updated: 2026-10-27
tags: [docs, user, indice, scopo]
qmd: "indice documentazione modulo user scopo gruppi cartelle quale documento e fonte di verita archivio storia stories bmad wiki"
related:
  - ./README.md
  - ./scopo.md
  - ./purpose.md
  - ./stories/dcp-442-ordine-dei-docs-del-modulo-user-link-nomi-e-scopo.story.md
---
# 📚 **Indice Documentazione Modulo User**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.5.0

## 🎯 **Lettura Essenziale**
1. [README.md](./README.md) - Panoramica completa del sistema di identità.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Biometric Auth & AI Moderation.
3. [philosophy.md](./philosophy.md) - "Essere Unici": la gestione dell'identità digitale.

## 🏗️ **Architettura & Auth**
- 🔐 **[Authentication Flow](./authentication.md)** - Dettagli sul ciclo di vita della sessione.
- 📜 **[Permissions System](./permissions.md)** - Gestione ruoli e permessi con Spatie.
- 🎫 **[Passport & SSO](./passport-integration.md)** - Integrazione OAuth2 e Single Sign-On.
- 🧷 **[Passport Model Wrappers](./passport-model-wrappers.md)** - Mappa obbligatoria tra model vendor Passport e wrapper `Oauth*` locali.
- 🛡️ **[2FA Guide](./2fa-guide.md)** - Implementazione dell'autenticazione a due fattori.

## 🪮 **Ponytail audit**
- 📋 **[Over-engineering audit](./ponytail-audit-over-engineering.md)** - Policy stub e contracts inutilizzati.
- 🗄️ **[Archiviazione Contracts orfani e backup lang](./wiki/decisions/contracts-and-lang-backup-archival-.deprecated.md)** - `ModelContract`, `PassportHasApiTokensContract` archiviati (`.bak`); 281 backup lang → `lang/{locale}/*.php.bak` in-place ([regola no-Legacy](../../../../docs/wiki/concepts/no-legacy-folders-code.md)).

## 👤 **Profilo & Moderazione**
- 🧑‍🎨 **[Profile Management](./profile-management.md)** - Gestione estesa dei dati utente (EAV).
- ⚖️ **[Moderation Strategy](./user-moderation-strategy.md)** - Workflow per approvazione e ban (dentisti, cliniche, utenti).
- 🧬 **[BaseUser Architecture](./baseuser.md)** - La classe base che unifica l'identità nel sistema.

## ⚙️ **Integrazioni Filament**
- 🏗️ **[Filament Resources](./filament-resources-updated.md)** - Gestione utenti, ruoli e permessi in v5.
- 🔑 **[Passport Cluster](./passport-cluster-summary.md)** - Gestione centralizzata delle chiavi API.
- ⚡ **[Auth Widgets](./login-widget-fix.md)** - Componenti di login/registrazione riutilizzabili.
- 🔐 **[Socialite + Microsoft OAuth](./socialite-microsoft-integration.md)** - Integrazione autenticazione Microsoft (NEW)

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Level 10 Fix Plan](./PHPSTAN_FIX_PLAN.md)** - Piano e stato di conformità Level 10.
- 🧭 **[IDE Helper Models Wave 2026-03-10](./ide-helper-models-wave.md)** - Distinzione tra errori sandbox e reali durante `php artisan ide-helper:models -W`.
- 🔬 **[Testing Identity](./testing.md)** - Test di autenticazione e autorizzazione (Pest).
- 🛡️ **[Autorizzazione delle azioni sugli utenti](./stories/user-actions-authorization.story.md)** - Password, verifica email, disattiva e ruolo super-admin passano dalla policy (story in review).
- 🌐 **[Niente testi fissi nelle Blade](./stories/blade-i18n-no-hardcoded-text.story.md)** - Testi delle viste in `user::` (it, en, de, es): regola, numeri e residui.
- 🧬 **[Model Inheritance](./model-inheritance-rules.md)** - Regole per estendere il modello User.
- 🧪 **PSR-4 Test Helpers** - Nei test trait/helper preferire anonymous classes o fixture dedicate sotto `tests/` con percorso coerente PSR-4.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./todo.md)** - Strategia per gestire i 550+ documenti accumulati.

## 📦 **Pacchetti Composer**
- [Riferimento completo](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md)
- `laravel/passport` - OAuth2 API
- `socialiteproviders/microsoft`, `socialiteproviders/auth0` - OAuth
- `flowframe/laravel-trend` - Statistiche
- `jenssegers/agent` - User-Agent
- `spatie/laravel-personal-data-export` - Export GDPR

## 🔗 **Moduli Correlati**
- [Xot](../../Xot/docs/README.md) - Core per la gestione dei trait `HasTeams`.
- [Tenant](../../Tenant/docs/README.md) - Risoluzione del Tenant corrente per l'utente.


# User, indice dei documenti

## A cosa serve questa cartella

Il modulo User risponde a tre domande: chi sei, cosa ti e' permesso, per conto di quale organizzazione. Le prove sono in [scopo.md](./scopo.md), il riassunto in [purpose.md](./purpose.md).

I documenti qui hanno due compiti. Il primo e' spiegare a chi arriva come e perche' il modulo e' fatto cosi' (identita', ruoli, team, tenant, OAuth). Il secondo e' conservare la cronologia: decisioni, fix, esperimenti. Chi cerca con `qmd search` trova a pari merito il documento vero e la sua copia stantia. Per questo questo indice dice, gruppo per gruppo, che cosa e' fonte di verita' e che cosa e' solo storia.

## Da dove partire

| Domanda | Documento |
|---------|-----------|
| Che cosa fa il modulo e dove finiscono i suoi confini? | [scopo.md](./scopo.md) |
| Panoramica del modulo | [README.md](./README.md) |
| Perche' e' stato deciso cosi'? | [bmad/decision-log.md](./bmad/decision-log.md) |
| Come e' strutturato? | [architecture/README.md](./architecture/README.md), [baseuser.md](./baseuser.md) |
| Login e sessione | [authentication.md](./authentication.md), [2fa-guide.md](./2fa-guide.md) |
| Ruoli e permessi | [permissions.md](./permissions.md) |
| OAuth e Passport | [passport-integration.md](./passport-integration.md), [passport-model-wrappers.md](./passport-model-wrappers.md) |
| Profilo utente | [profile-management.md](./profile-management.md) |
| Estendere il modello User | [model-inheritance-rules.md](./model-inheritance-rules.md) |
| Test | [testing.md](./testing.md) |
| Dove sta andando | [roadmap.md](./roadmap.md), [roadmap/00-index.md](./roadmap/00-index.md) |
| Dipendenze e pacchetti | [dependency-intelligence.md](./dependency-intelligence.md) |
| Debito da pulire | [todo.md](./todo.md), [ponytail-audit-over-engineering.md](./ponytail-audit-over-engineering.md) |

Moduli vicini: [Xot](../../Xot/docs/README.md) (trait `HasTeams`, base Filament) e [Tenant](../../Tenant/docs/README.md) (tenant corrente dell'utente).

## A cosa servono i gruppi di documenti

I conteggi sono file `.md` misurati il 2026-10-27 (totale 2300, piu' 532 file `.md.old` ritirati).

| Gruppo | File | Perche' esiste | Come usarlo |
|--------|-----:|----------------|-------------|
| Radice `docs/*.md` | 1294 | Note accumulate nel tempo: analisi, guide, fix, copie con nome diverso. Non e' una struttura, e' memoria. | Non cercare qui a mano. Partire dalla tabella sopra; il resto e' storia, spesso `draft`, `stub` o `superseded`. |
| `stories/` | 148 | Story BMAD del modulo: obiettivo, criteri, stato (`backlog`, `done`, ...). Dicono che cosa e' stato fatto e perche'. | Fonte di verita' sul lavoro. Non si rinominano ne' si rinumerano. |
| `bmad/` | 122 | Kit BMAD del modulo (brief, PRD, architettura, epics, decision log, blueprint Filament) piu' 30 story di fix in `bmad/stories/`. | Fonte di verita' sulle decisioni. Partire da `bmad/README.md`. |
| `wiki/` | 221 | Base di conoscenza in stile llm-wiki: concetti, entita', decisioni, how-to, regole, glossario. | Leggere `wiki/index.md`. `wiki/integrations/` (80 file) contiene consolidamenti; `_da-riconciliare/` (13 file) aspetta una revisione umana. |
| `roadmap/` e `development/` | 57 | Evoluzione prevista, rischi, fasi. | Dato di pianificazione, non di stato del codice. |
| `product/`, `prompts/`, `decisions/` | 12 | Strategia di prodotto, prompt di lavoro, singole decisioni. | Contesto, da verificare col codice prima di fidarsi. |
| Cartelle tematiche (`architecture/`, `models/`, `filament/`, `database/`, `oauth/`, `testing/`, `widgets/`, `traits/`, `contracts/`, ...) | 87 | Un tema per cartella: come funziona quel pezzo del modulo. | Primo posto dove guardare quando la domanda e' di quell'area. |
| Cronaca dei bug (`fixes/`, `bug-fixes/`, `bugfix/`, `bugs/`, `bug-tracking/`, `errori/`, ...) | 38 | Che cosa si e' rotto e come si e' risolto. | Valore storico. Cercare qui il sintomo, non la regola. |
| `best-practices/` | 33 | Regole d'uso per componenti e widget di autenticazione. | Regole, ma da confrontare con `wiki/rules/`. |
| `_integration/` e `-integration/` | 47 | Appunti di ricerca su pacchetti esterni (EAV, Filament, Spatie). Due cartelle gemelle. | Ricerca grezza, non decisioni. |
| `commands/`, `console-commands/`, `console_commands/` | 19 | Comandi Artisan del modulo, in tre cartelle con lo stesso argomento. | Leggere `console-commands/`: alcune copie delle altre due sono gia' `superseded` verso di essa. Unificazione da decidere. |
| `archive/` | 180 | Documenti ritirati (`historical/`, `old_tasks/`). | Solo storia. Non usarli come fonte. |
| `raw/` | 19 | Materiale importato, immutabile. | Non modificare. |
| Strumenti (`llm-wiki/`, `html2pdf/`, `img/`, `screenshots/`, `playwright/`, `outputs/`) | 23 | Supporto: indice wiki, immagini con la loro nota, note su strumenti. | Rari da consultare. |

## Stato dei documenti

Stato dichiarato nel frontmatter (2300 `.md`): `draft` 1396, `stub` 312, `superseded` 280, `done` 65, `backlog` 47, `deprecated` 32, `active` 27, senza `status` 43 (23 in `stories/`, 19 in `raw/`, 1 in radice). Le story usano il proprio ciclo di stato. `draft` significa non rivisto, non sbagliato. Solo `active` afferma che il contenuto e' stato verificato sul codice.

## Regole per chi scrive qui

- Nessuna data o timestamp nel nome del file, nessun suffisso `-1`, `-2`: la data va nel frontmatter (`created`, `updated`). Controllo: `python3 -I bashscripts/tools/docs/md-filenames.py name <percorso>`.
- Prima di creare un file cercare con `qmd search "<tema>"`: se il tema esiste, aggiornare quel file e collegarlo, senza una copia con maiuscole, underscore o cartella diversi.
- Le story vanno in `stories/` e non si rinumerano. I file non si spostano senza migration map e revisione umana (regola DOC-006).
- Un file che ne sostituisce un altro lo dichiara: `status: superseded` e `superseded_by` con il percorso del canone. Non si cancella.
- I link relativi devono risolversi: `python3 bashscripts/tools/docs/docs-organizer.py links laravel/Modules/User/docs`.

## Debito noto

Misure e decisioni aperte sono nella story [dcp-442](./stories/dcp-442-ordine-dei-docs-del-modulo-user-link-nomi-e-scopo.story.md): link non risolti, 407 file con un rinvio a `Themes/docs/shared-components/` che non esiste (285 sono solo quel rinvio), cartelle gemelle, collisioni di maiuscole, 33 nomi con suffisso numerico o data in `archive/`.


---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
- [Scopo, confini e come servirlo meglio](./scopo.md)
- [Cosa manca per completare](./completion-status.md): indicatori misurati, problemi noti e story aperte (2026-10-28)
