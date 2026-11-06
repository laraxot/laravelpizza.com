---
title: "Progetto: cosa manca per completarlo"
type: status
module: Xot
updated: 2026-10-28
repository: "https://github.com/provtv/base_ptv_fila5_mono"
github_issue: "https://github.com/provtv/base_ptv_fila5_mono/issues"
github_discussion: "https://github.com/provtv/base_ptv_fila5_mono/discussions"
---

# Progetto: cosa manca per completarlo

Fotografia misurata il 2026-10-28 su 18 moduli e 3 temi (sola lettura). Il dettaglio sta in
`docs/completion-status.md` di ogni modulo e tema.

## Problemi trasversali, in ordine di priorita'

| Priorita' | Problema | Azione |
|---|---|---|
| BLOCCANTE | `public_html/info.php` contiene `phpinfo()` ed e' raggiungibile dal web (versionato in git): espone configurazione e variabili d'ambiente. | Rimuoverlo (decisione dell'utente: file di produzione). |
| BLOCCANTE | `public_html/hot` (dal 2026-08-26, versionato) punta a `http://127.0.0.1:5173`: `@vite` carica gli asset da un dev server inesistente per gli utenti (layout del tema Zero, log viewer di Activity). | Rimuoverlo e aggiungerlo a `.gitignore` (decisione dell'utente). |
| BLOCCANTE | 505 blade troncate in testa in 7 moduli (5 caratteri persi); Progressioni riparato. | Story `truncated-blade-repair.story.md` nei moduli coinvolti; procedura `bashscripts/docs/blade-truncation-repair.md`. |
| ERRORE | Pest non si esegue su 10.100.200.15 (produzione): i test scritti non sono verificati. | Ambiente di sviluppo/CI con DB di test dedicato. |
| AVVISO | Traduzioni inglesi incomplete in quasi tutti i moduli (file presenti in `lang/it` e assenti in `lang/en`). | Allineare o dichiarare l'inglese fuori scope. |

## Per modulo e tema

| Nome | PHPStan | Blade troncate | Test | Solo it | Story aperte | Dettaglio |
|---|---|---|---|---|---|---|
| Activity | 6 | 0 | 100 | 2 | 32 | [completion-status](../../Activity/docs/completion-status.md) |
| Incentivi | 0 | 0 | 36 | 5 | 9 | [completion-status](../../Incentivi/docs/completion-status.md) |
| IndennitaCondizioniLavoro | 0 | 125 | 19 | 9 | 32 | [completion-status](../../IndennitaCondizioniLavoro/docs/completion-status.md) |
| IndennitaResponsabilita | 0 | 59 | 41 | 19 | 84 | [completion-status](../../IndennitaResponsabilita/docs/completion-status.md) |
| Job | 0 | 0 | 44 | 22 | 15 | [completion-status](../../Job/docs/completion-status.md) |
| Lang | 0 | 0 | 25 | 0 | 24 | [completion-status](../../Lang/docs/completion-status.md) |
| Media | 0 | 0 | 41 | 18 | 18 | [completion-status](../../Media/docs/completion-status.md) |
| Notify | 0 | 0 | 132 | 44 | 31 | [completion-status](../../Notify/docs/completion-status.md) |
| Pdnd | 0 | 4 | 14 | 14 | 9 | [completion-status](../../Pdnd/docs/completion-status.md) |
| Performance | 0 | 51 | 20 | 122 | 15 | [completion-status](../../Performance/docs/completion-status.md) |
| Progressioni | 0 | 6 | 26 | 137 | 35 | [completion-status](../../Progressioni/docs/completion-status.md) |
| Ptv | 0 | 30 | 49 | 76 | 46 | [completion-status](../../Ptv/docs/completion-status.md) |
| Rating | 0 | 0 | 29 | 23 | 89 | [completion-status](../../Rating/docs/completion-status.md) |
| Sigma | 0 | 22 | 41 | 15 | 42 | [completion-status](../../Sigma/docs/completion-status.md) |
| Tenant | 0 | 0 | 42 | 4 | 19 | [completion-status](../../Tenant/docs/completion-status.md) |
| UI | 0 | 0 | 49 | 52 | 13 | [completion-status](../../UI/docs/completion-status.md) |
| User | 0 | 0 | 172 | 138 | 101 | [completion-status](../../User/docs/completion-status.md) |
| Xot | 1 | 0 | 194 | 76 | 107 | [completion-status](completion-status.md) |
| One (tema) | 0 | 0 | 0 | 0 | 4 | [completion-status](../../../Themes/One/docs/completion-status.md) |
| Three (tema) | 0 | 0 | 0 | 0 | 1 | [completion-status](../../../Themes/Three/docs/completion-status.md) |
| Zero (tema) | 0 | 0 | 0 | 0 | 1 | [completion-status](../../../Themes/Zero/docs/completion-status.md) |

Story aperte totali: 727. Migrazioni pendenti: 0 (`module:migrate-status`). Marker di conflitto git: 0 nel codice, 20 file `.md` in docs.

## Ordine consigliato

1. Sicurezza e produzione: `info.php`, `hot`, credenziali in chiaro (Sigma, Pdnd), accesso alla SettingPage di Notify.
2. Blade troncate nei 6 moduli rimasti (procedura gia' provata su Progressioni).
3. Ambiente di test (Pest) fuori dalla produzione, per verificare i test scritti.
4. Bug funzionali con story `ready-for-dev` (form con colonne reali, operatore criteri, force_ssl, rating_morph Performance).
5. Classificare le story senza `status` e chiudere quelle superate.
6. Pulizia: Pint, codice morto, traduzioni inglesi.
