---
title: "Ridondanze cross-cutting codebase e dove documentarle"
type: concept
tags: [dry, redundancy, xot, documentation]
created: "2026-05-21"
updated: "2026-05-25"
related:
  - ../../redundancy-report.md
  - ../../filament/redundancy-rules.md
  - ../redundancy/byte-identical-files-static-scan.md
  - ../redundancy/audit-profondo-ridondanze-holistic.md
  - ../../../../../Themes/docs/ridondanze-documentazione-temi.md
  - ../../../../../Themes/Sixteen/docs/wiki/concepts/ridondanze-documentazione-wizard.md
  - ../../../../../Themes/TwentyOne/docs/wiki/concepts/ridondanze-hub-twentyone-xot.md
  - ../../../../User/docs/wiki/concepts/ridondanze-docs-legacy-cluster.md
---

# Ridondanze cross-cutting (codice + documentazione)

## Scopo

Un solo punto di lettura che **aggrega tipi di ripetizioni** osservati nel monorepo (moduli Laraxot + temi Sixteen/TwentyOne) senza ricopiare lunghi estratti tecnici già pubblicati altrove.

**Audit documentazione:** 2026-05-21–22. **Audit statico file identici:** vedi baseline in [`byte-identical-files-static-scan.md`](../redundancy/byte-identical-files-static-scan.md); **audit olistico 2026-05-25**: [`audit-profondo-ridondanze-holistic.md`](../redundancy/audit-profondo-ridondanze-holistic.md). **Schede atomiche** (OAuth, widget auth, DTO, Rating, Fixcity, scaffold temi): [`redundancy-catalog.md`](./redundancy-catalog.md).

## Ridondanza byte-identica (checksum), moduli + temi

Pass SHA256 senza interprete AST: sintesi e pattern in **[byte-identical-files-static-scan.md](../redundancy/byte-identical-files-static-scan.md)** — include baseline 2026-05-23 e **riesame 2026-05-25**. Tracker [#89](https://github.com/laraxot/base_fixcity_fila5/issues/89) · [#90](https://github.com/laraxot/base_fixcity_fila5/issues/90).

## Volumi documentazione moduli (indicativo)

| Modulo | `.md` in `docs/` circa | Cluster principale |
|--------|------------------------|-------------------|
| Xot | 3263 | wizard Filament wiki, scaffold |
| User | 3071 | **`legacy/` ~723**, logout, phpstan |
| Notify | 1821 | scaffold + notify |
| Lang, Geo, Cms, UI | 784–947 | scaffold batch |
| Fixcity | 202 | dominio prodotto |

~**57%** dei `.md` modulo è in Xot + User + Notify. Dettaglio temi: **[ridondanze-documentazione-temi.md](../../../../../Themes/docs/ridondanze-documentazione-temi.md)**.

**Debito sintattico Markdown:** più file nei moduli (in particolare **Activity**) e alcuni punti **Xot/UI/Notify/Lang** contengono ancora **marker Git non risolti** (`<<<<<<<`) — bloccano parsing QMD/memorie e sono da trattare come **ridondanza/deriva della stessa pagina**. Inventario sintetico: [`audit-profondo-ridondanze-holistic.md`](../redundancy/audit-profondo-ridondanze-holistic.md).

## Ridondanze codice critiche (migrazioni e Filament)

Oltre a BaseModel/Filament già in [redundancy-report.md](../../redundancy-report.md):

| Tabella / area | Moduli | Problema |
|----------------|--------|----------|
| `users` | User | 6+ migration `create_users_table`; mirror `Database/Migrations/` vs `database/migrations/` |
| `profiles` | User + Blog | due moduli creano `profiles` |
| `mail_templates` | Notify | 7 migration stesso scopo |
| `consents` | Gdpr | 3 migration |
| `activity` | Activity | 5 migration |
| `cache` | Xot | 2 migration identiche |
| `notification_logs` | Notify | 2 migration |
| OAuth / Profile / Consent | User, Gdpr | resource cluster **e** standalone |
| Filament Tables typo | Geo, Activity, Media | `AddresssTable`, `ActivitysTable`, `MediasTable` |
| `lang/it/actions.php` | 9 moduli | chiavi Filament duplicate |
| Media UI | UI blocks + Media | `ImageSpatie`/`VideoSpatie` copy-paste; `HasMediaResource/` orfano |

**Azione:** una migration canonica per tabella; owner modulo unico per `profiles`; eliminare path migration legacy duplicati dopo backup.

## Inventario tecnico modulo Xot

Analisi strutturata con classi/File duplicati o path paralleli: **[redundancy-report.md](../../redundancy-report.md)** (ColumnBuilder gemello, AutoLabel vs Lang, ArticleData/BaseRating ospitati nel modulo sbagliato, doppioni `XotBaseRelationManager`/`XotBaseManageRelatedRecords`, note su `HasXotTable`/PHPStan).

Regole anti-ridondanza Filament progetto:

- **[redundancy-rules.md](../../filament/redundancy-rules.md)**

### Wizard Filament dopo refactor (`HasWizard`)

Wizard widget Laraxot: **SSoT contenuti** **[filament-wizard-refactoring.md](../filament-wizard-refactoring.md)** — uso di **`Filament\Resources\Pages\Concerns\HasWizard`** su `XotBaseWizardWidget`; **[XotBaseWizardWidget-HasWizard-refactor.md](../XotBaseWizardWidget-HasWizard-refactor.md)** resta puntatore storico.

Argomento concettuale (studio vendor — filtrare con SSoT sopra):

- **[filament-haswizard-vs-xotbasewizard.md](./filament-haswizard-vs-xotbasewizard.md)**

### Documentazione scaffold LLM-wiki ripetuta (byte-identiche)

Corpo lungo della policy **solo** in modulo Xot — **[second-brain-local-discipline.md](./second-brain-local-discipline.md)** (canonica); negli altri moduli (**Activity, Gdpr, Job, Media, Notify, Rating, Tenant, UI, User**) file omonimo = **stub** verso questa pagina (**Geo** può mantenere variante specifica se presente).

Variare sempre **solo il master Xot**, poi aggiornare l’indice dei moduli con stub quando se ne aggiungono altri.

## Report `redundancy-report.md` quasi ovunque

Molti moduli ospitano **`docs/redundancy-report.md`** con contenuto **diverso** per modulo — naming da template batch. Non è errore ma **ambiguità**: qualificare sempre il modulo in ricerca.

## Temi Sixteen / TwentyOne

- **Sixteen:** molte slice su wizard/parity — hub **[ridondanze-documentazione-wizard.md](../../../../../Themes/Sixteen/docs/wiki/concepts/ridondanze-documentazione-wizard.md)** + **[wizard-parity-documentation-map.md](../../../../../Themes/Sixteen/docs/wiki/concepts/wizard-parity-documentation-map.md)**.
- **TwentyOne:** **`analisi-metodi-duplicati.md`** + **`dry-kiss-analysis.md`** + **[ridondanze-hub-twentyone-xot.md](../../../../../Themes/TwentyOne/docs/wiki/concepts/ridondanze-hub-twentyone-xot.md)**.

## Modulo User — cluster legacy Markdown

In **[ridondanze-docs-legacy-cluster.md](../../../../User/docs/wiki/concepts/ridondanze-docs-legacy-cluster.md)** — revisioni quasi identiche (`redundancy-fixes*.md`), underscore vs hyphen, cartella **`docs/legacy/`**.

## Collegamenti utili progetto root

- [Trigger map](../../../../../../docs/wiki/rules/00-TRIGGER_MAP.md) — non duplicare regole lunghe qui.