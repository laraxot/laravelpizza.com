---
title: Orientamento verificato sullo stato del progetto
status: done
module: Xot (owner dei documenti trasversali di stato)
created: 2026-10-27
---

# Orientamento verificato sullo stato del progetto

## Fase BMAD

Analisi (lettura e verifica, nessuna modifica al codice).

## Obiettivo

Costruire una conoscenza del progetto verificata nel codice, non ereditata dai documenti,
e lasciarla nel second brain per le sessioni successive.

## Fonti lette

- `bashscripts/ai/wiki/memories/agent-standing-order.md` (quattordici pilastri)
- `bmad-output/handoff-zero-phpstan-ripresa.story.md` (dossier di ripresa)
- `bmad-output/architecture.md`
- Memoria `perimetro-del-progetto` (confine di dominio)

## Verificato nel codice

| Affermazione | Esito | Prova |
|---|---|---|
| Laravel 13, Filament 5, nwidart modules 13 | Confermato | `laravel/composer.json` |
| PHP runtime | 8.4.17 (CLAUDE.md dice 8.3+, soddisfatto) | `php -v` |
| PHPStan `level: max` su `Modules/` | Confermato | `laravel/phpstan.neon` |
| 18 moduli su disco, ognuno con `.git` proprio | Confermato | `ls laravel/Modules` |
| `docs/purpose.md` in ogni modulo (CLAUDE.md e standing order) | Non confermato: presente in 9 moduli su 18 | `ls Modules/*/docs/purpose.md` |
| `Gdpr` rimosso dal tracking (`54e7e4b937`) | Confermato, ma restano 3 file con riferimenti nel codice | `git log -S`, grep su `Modules` |
| Pest bloccato dal guard DB | Guard presente, causa non riprodotta in questa sessione | `Modules/Xot/tests/Support/TestDatabaseGuard.php` |
| Lock di modulo | 194 file `.lock` sotto `Modules/` | `find Modules -name '*.lock'` |
| `bmad-output/architecture.md` | Obsoleto: parla di "7477 moduli" e di un refactor `Arrays/` → `Arr/` non attuale | lettura del file |

## Discrepanze da trattare

1. `purpose.md` mancante in 9 moduli: Sigma, IndennitaCondizioniLavoro, Pdnd, IndennitaResponsabilita,
   Performance, Progressioni, Ptv, UI, Xot. Il confine di dominio di Sigma e Ptv è quindi solo in memoria.
2. Riferimenti residui a `Modules\Gdpr` in tre file: il test di registrazione, il widget
   `User/app/Filament/Widgets/Auth/RegisterWidget.php` (solo commento) e un terzo file. Il dossier
   ne cita uno solo.
3. `bmad-output/architecture.md` non descrive lo stato attuale e non va usato come fonte.
4. Il dossier di ripresa dichiara `bmad-output/` come punto di ripresa, ma la regola attuale vieta
   `bmad-output/` per i documenti. Il dossier va migrato nel modulo owner in una storia separata.

## Decisioni

- Nessun tool installato: lo stato non lo richiede ancora.
- Nessun reset, checkout o rollback. Nessun dato toccato.
- PHPStan non rilanciato in questa fase: il dossier chiede di rilanciarlo con `TMPDIR` isolato prima di fidarsi
  di un numero, e il tempo di esecuzione va messo in una storia dedicata.

## Prossimi passi proposti (ordinati)

1. Migrare `bmad-output/handoff-zero-phpstan-ripresa.story.md` in `Modules/Xot/docs/stories/` (storia separata).
2. Aggiungere `purpose.md` ai nove moduli che non lo hanno, partendo da `docs/mappa-dei-moduli.md`.
3. Verificare e ripulire i tre riferimenti residui a `Modules\Gdpr`.
4. Rilanciare PHPStan con cache isolata e registrare il numero reale nel dossier.

## Verifica

Lettura e grep eseguiti sopra. Nessun test eseguito: questa storia non modifica codice.

## Esiti del passo parallelo (2026-10-27)

| Voce | Esito | Prova |
|---|---|---|
| PHPStan `analyse Modules`, cache isolata (`TMPDIR`) | Verde: `[OK] No errors`, exit 0 | `/tmp/claude-1000/phpstan-modules-20261027.txt` |
| `purpose.md` scritti | Sigma, Progressioni, Xot, IndennitaResponsabilita, IndennitaCondizioniLavoro, Pdnd, UI | `ls Modules/*/docs/purpose.md` |
| `purpose.md` mancante | Ptv, per `Modules/Ptv/docs.lock` (agente-4, 5 ottobre) | `cat Modules/Ptv/docs.lock` |
| Gdpr residui | Nessun riferimento runtime in PHP; restano config, script e commenti | Subagent read-only, classificazione in tabella |
| Test `AuthFlowRedirectsTest` | Nessun riferimento a Gdpr: il dato del dossier è superato | `grep -n Gdpr` restituisce vuoto |
| Dossier copiato | Copia canonica in questo modulo; originale in `bmad-output/` non marcato (guard) | `ls Modules/Xot/docs/stories/handoff-zero-phpstan-ripresa.story.md` |

## Violazioni di confine (da decidere, non corrette)

- Sigma importa Ptv in 293 file (es. `Modules/Sigma/app/Models/Anag.php:9`).
- Xot importa moduli di dominio in 31 file, con `module.json` a `"requires": []`.
- Indennità Responsabilità e Ptv si importano a vicenda.
- Ptv importa Indennità Condizioni Lavoro (`CreateStabiDirigente.php:13`).

## Processo

- `Modules/Pdnd/docs/purpose.md` è stato scritto senza verificare `bashscripts/lock/Pdnd.lock`
  (LOCKED 2026-10-06, swarm-cluster1). Il file è nuovo e non sovrascrive nulla, ma la procedura
  non è stata rispettata. Segnalato.
- `bashscripts/lock/IndennitaResponsabilita-phpstan-fix.lock` è vuoto e dell'6 ottobre: non
  rimosso, né usato come prova di stale.

## Approfondimento: dipendenze reali contro dipendenze di tipo (2026-10-27)

Strumento riusabile: `bashscripts/tools/audit/module-coupling.py <root-laravel>`. Conta, per
coppia di moduli, i file che usano nel corpo del codice una classe importata da un altro
modulo. Esclude commenti, docblock e righe `use`.

**Correzione ai numeri precedenti.** Il conteggio dei 293 file Sigma→Ptv e dei 31 file Xot→dominio
contava anche `use` e docblock. Il conteggio a livello di codice dà:

- Sigma→Ptv: 2 file (il resto sono `use Modules\Ptv\Models\Profile` e docblock di audit).
- Xot→User: 10 file con riferimento nel corpo, per esempio `XotAction.php` usa
  `Modules\User\Models\Tenant`. Dipendenza reale del framework verso un modulo di dominio.
- Xot→Tenant (8), Xot→Lang (7), Xot→Notify (4), Xot→UI (3), Xot→Media (1): anch'esse reali.
- Ptv→Sigma: 28 file (Repart, Rep00f, Qua00f, GgFilterData, Tqu00f). Il confine "Ptv può dipendere
  da Sigma" è quindi rispettato nella direzione, ma è la dipendenza più forte del dominio.
- Coppie più forti verticali: Progressioni→Ptv (64), IR→Ptv (51), ICL→Ptv (36).

**Ipotesi da verificare, non conclusioni.** Xot→User è il punto più grave: il framework non
dovrebbe conoscere il modulo User. `Xot/app/Contracts/UserContract.php` e `ProfileContract.php`
mostrano già il pattern corretto (contratto e classe risolta da config, come `XotData::getProfileClass()`).
Il rimedio è spostare i riferimenti concreti dietro quel contratto, non aggiungere dipendenze.
