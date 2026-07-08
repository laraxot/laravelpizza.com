---
title: "filosofia della ridondanza nel monorepo Laraxot"
module: Xot
type: concept
status: approved
tags: [redundancy, dry, kiss, architecture, laraxot]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - redundancy-catalog.md
  - ../redundancy-audit.md
  - ../../../../../docs/wiki/concepts/second-brain-operating-model.md
  - ../../../../../docs/wiki/how-to/module-docs-deduplication.md
issue: "https://github.com/provtv/base_ptv_fila5_mono/issues/151"
---

# Filosofia della ridondanza — scopo, zen, politica

## Scopo (perché esiste questo documento)

Il monorepo **PTVX** accumula decine di moduli dominio, temi Filament, migrazioni storiche e documentazione agent. La ridondanza non è solo «file doppi»: è **debito cognitivo** — due verità possibili per lo stesso comportamento, panel Filament che registrano la stessa risorsa, backup `.php.up` che sembrano codice vivo.

Questo documento fissa **come decidere** cosa tenere, cosa fondere e cosa archiviare, senza purga cieca.

## Religione (invarianti non negoziabili)

1. **Un owner per concetto** — es. autenticazione → modulo `User`; colonne tabella → trait `HasXotTable` in Xot, non copie locali.
2. **XotBase, non Filament diretto** — duplicare `Resource`/`Widget` Laravel è peccato architetturale; estendere `XotBase*`.
3. **Forward-only sul codice** — non `git checkout` al passato; si corregge avanti con commit e wiki.
4. **Docs atomiche** — una idea per file; la ridondanza va **indicizzata** ([redundancy-catalog.md](redundancy-catalog.md)), non riscritta in ogni modulo.
5. **Niente path assoluti nel repo** — stesso principio di `llm-wiki.txt`: `${PWD}`, non `/var/www/_bases/base_*`.

## Politica (chi decide cosa)

| Livello | Chi | Cosa decide |
|---------|-----|-------------|
| Framework | Modulo **Xot** | Classi base, panel provider pattern, catalogo trasversale |
| Trasversale | **User**, **Lang**, **UI**, **Media** | Auth, traduzioni, componenti UI, media |
| Dominio | **Ptv**, **Performance**, **Notify**, … | Regole HR/PA; possono **omonimare** (`UserResource`) ma namespace diversi |
| Presentazione | **Themes/One**, **Themes/Zero** | Blade/login; **non** duplicare business logic |
| Documentazione | Wiki owner + root `docs/wiki/` | Stub + link; epic GitHub per esecuzione |

**Regola:** prima di aggiungere una classe, cercare in QMD `redundancy` + modulo owner. Se esiste già un pattern Xot, **non** crearne un secondo.

## Filosofia (cosa è ridondanza «buona» vs «cattiva»)

### Ridondanza accettabile (intenzionale)

- **Due modelli template** in Notify (`MailTemplate` vs `NotificationTemplate`) se i canali e il lifecycle differiscono — ma va **documentato** l’ADR.
- **Stesso short name** in namespace diversi (`Modules\Ptv\...\UserResource` vs `Modules\User\...`) — accettabile in PHP, pericoloso per umani: serve indice wiki.
- **Temi One/Zero** con login blade simili — accettabile se il «vestito» è tema; estrarre partial condiviso quando il diff è byte-identico.

### Ridondanza cattiva (da eliminare)

- File `*.php.up`, `*.bak`, `*~HEAD` — non autoloadati, ingannano IDE e agent.
- **Due classi stesso ruolo** (`LoginWidget` in `Widgets/` vs `Widgets/Auth/`).
- **Due alberi Filament** Passport/Socialite (root `Resources/` + `Clusters/`).
- **composer.json** fuori posto (`User/resources/views/composer.json`, `Xot/app/Services/composer.json`).
- **Docs migrazione Filament** ×50 con titoli quasi uguali — caricare on-demand, non pre-inject.

## Zen (come lavorare senza ansia)

- **Non** cercare zero ridondanza assoluta in un monorepo da 30+ moduli: è irrealistico.
- **Sì** a «ridondanza visibile»: ogni audit va in un file datato (`redundancy-audit-YYYY-MM-DD.md`) e nel log owner.
- **Un passo alla volta:** P0 = file spuri e rischi runtime; P1 = merge Filament; P2 = docs.
- Dopo ogni fix: PHPStan L10 + gate modulo; **non** dichiarare «pulito» senza prova.

## Dubbi e perplessità (aperti — da risolvere in issue)

| # | Perplessità | Modulo | Azione proposta |
|---|-------------|--------|-----------------|
| 1 | `MailTemplateResource` vs `NotificationTemplateResource` — convergenza futura? | Notify | ADR + product owner |
| 2 | `Theme_One/` vs `Themes/One/` — alias o copia morta? | Themes | Inventario directory + delete o redirect doc |
| 3 | Merge Composer: `Themes/*/composer.json` **non** nel merge root | Xot/DevOps | **Risolto 2026-06-30**: autoload runtime Xot + [theme-psr4-autoload-without-merge.md](./theme-psr4-autoload-without-merge.md) |
| 4 | Test su `Widgets\LoginWidget` mentre runtime usa `Widgets\Auth\LoginWidget` | User | Allineare test al path canonico |
| 5 | Risorse `CriteriOptionResource` ×3 (Ptv, Performance, Progressioni) — estrarre base Ptv? | Ptv | Spike refactor o documentare differenze |
| 6 | 51 file `Notify/docs/*filament*` — quali sono ancora verità? | Notify | Script dedup + `_archive` wiki |

## Consigli operativi (per agenti e umani)

1. Prima di edit: `qmd search "redundancy <modulo>" -n 5`.
2. Non creare nuovo `.md` se esiste audit recente — **append** al log e aggiorna audit datato.
3. Preferire **delete** di backup `.up` dopo diff con file canonico (nessun autoload).
4. Per Filament: una risorsa, un namespace, un cluster — seguire regola Passport «solo sotto `Clusters/`».
5. Collegare ogni epic a [GitHub provtv/base_ptv_fila5_mono](https://github.com/provtv/base_ptv_fila5_mono).

## Collegamenti

- [Catalogo indice](redundancy-catalog.md)
- [Audit 2026-05-26](../redundancy-audit.md)
- [Regole Filament ridondanza](../../filament/redundancy-rules.md)
- [Deduplica docs root](../../../../../docs/wiki/how-to/module-docs-deduplication.md)
