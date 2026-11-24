---
<<<<<<< HEAD
title: "Contratti"
type: index
tags: [contracts, actions, interfaces]
created: 2026-11-18
updated: 2026-11-18
---

# Contratti

Cosa promette la superficie pubblica di questo pacchetto: le Action che scrivono dati, chiamano servizi esterni o hanno
effetti collaterali, e le interfacce (`app/Contracts`). Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.
=======
title: "Contratti — Xot"
type: index
tags: [contracts, actions, interfaces, xot]
created: 2026-11-18
updated: 2026-11-24
---

# Contratti — Xot

## Metodo Harness

Un contratto descrive una singola operazione pubblica con effetti collaterali, chiamate esterne o invarianti di dominio. Documenta il comportamento osservabile, inclusi errori e non-goals, senza trasformare ogni metodo interno in un contratto.

Ogni invariante ha un ID stabile nel formato `XOT-INV-N`; il test Pest corrispondente usa lo stesso ID come group. La classe implementatrice deve contenere `@contract docs/contracts/<file>.md`; contratto, codice e test cambiano nello stesso commit.

Cosa promette la superficie pubblica di questo pacchetto: le classi base `XotBase*` che gli altri moduli estendono,
le Action che scrivono dati, chiamano servizi esterni o hanno effetti collaterali, e le interfacce (`app/Contracts`).
Regola: `Modules/Xot/docs/rules/action-behavioral-contract.md`.

Xot è la base di tutti i moduli: qui stanno i contratti delle sue Action con effetti collaterali **chiamate dagli
altri moduli** — scrittura di array su file (traduzioni, config dei tenant, model su JSON), esecuzione di comandi
Artisan dal pannello, invio di mail con PDF. Un cambiamento qui si propaga a Lang, Tenant, User, Notify e a tutto ciò
che le usa.

**Quando leggerli**: prima di chiamare una di queste Action da un modulo, di cambiarne il comportamento, o di
scrivere un'Action simile (che invece di imitare il codice dovrebbe riusarle).

Formato (6 sezioni, tabella invarianti con ID e group Pest, `@contract` nel docblock):
[action-behavioral-contract](../rules/action-behavioral-contract.md). Un'invariante con group si verifica con
`vendor/bin/pest Modules/Xot/tests --group=<ID>`; `—` è debito dichiarato.

## Classi base

- [Contratto delle classi XotBase](xotbase-classes.md) — cosa garantiscono a chi le estende, cosa pretendono in
  cambio, le due trappole note (`registerConfig()` non ricorsiva, `tableUpdate()` che crea la tabella) e come si
  verifica una modifica che le tocca.
>>>>>>> laraxot/dev

## Contratto di comportamento di un'Action

Un file per Action, nome in kebab-case della classe (`create-ticket-action.md`), frontmatter `type: contract` e
`action: <FQCN>`, e queste sei sezioni nell'ordine:

```markdown
## Input
## Output
## Invarianti
## Effetti collaterali
## Errori
## Non fa
```

<<<<<<< HEAD
Il docblock dell'Action rimanda al file con la riga `Contratto di comportamento: docs/contracts/<file>.md`.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

## Contratti

=======
Il docblock dell'Action rimanda al file con il marker machine-readable
`@contract docs/contracts/<file>.md`. La frase descrittiva legacy può restare,
ma il marker è il collegamento verificato dai test.
Chi cambia il comportamento aggiorna il contratto nello stesso commit.

Ogni invariante ha un ID stabile nel formato `<OWNER>-<OPERAZIONE>-INV-<N>` e
indica il group Pest omonimo. Il test dell'invariante usa
`->group('<OWNER>-<OPERAZIONE>-INV-<N>')`, così la conferma mirata è
`vendor/bin/pest --group=<ID>`. Il [template operativo](behavioral-contract-template.md)
contiene la tabella minima di mapping fra regola, group e test.

## Contratti

- [Standard di authoring dei contratti](contract-authoring-standard.md)
- [Template per Behavioral Contract](behavioral-contract-template.md) — IDs, gruppi Pest e comando di conferma
- [Story: file route in ogni modulo](../stories/module-route-files-exist-in-all-modules.story.md) — `routes/web.php` e
  `routes/api.php` devono esistere in tutti i moduli, anche con il solo `<?php`, senza `require` (l'[ADR degli entrypoint
  vuoti](../adr/route-entrypoints-canonical-empty.md) e' superato).
- [Bootstrap provider registry](bootstrap-provider-registry.md) — `bootstrap/providers.php` contiene solo `AppServiceProvider`; i provider dei moduli si scoprono via Composer e `AppServiceProvider` tiene la registrazione dei pannelli Filament (`BOOTSTRAP-PROVIDERS-001..003`).
- [SaveArrayAction](save-array-action.md) — scrive un array su file PHP (default) o JSON, sovrascrivendo; punto unico usato da Lang, Tenant e Xot.
- [SavePhpArrayAction](save-php-array-action.md) — file PHP con `strict_types`, una chiave per riga, rileggibile con `require`.
- [SaveJsonArrayAction](save-json-array-action.md) — file JSON pretty-print, crea la cartella se manca.
- [ExecuteArtisanCommandAction](execute-artisan-command-action.md) — esegue `php artisan <cmd>` solo per comandi identici all'allowlist.
- [SendMailByRecordAction](send-mail-by-record-action.md) — PDF del record via SMTP all'email del record, poi log `sendMail`.

## Indici e template

- [INDEX.md](INDEX.md) — inventario machine-readable dei contratti Xot, con classe e ID delle invarianti.
- [0000-template.md](0000-template.md) — template inglese del contratto (owner, input, output, invarianti, effetti, errori, non-goals).
- [_template.md](_template.md) — template minimo `type: contract` con `action: <FQCN>` e le sei sezioni italiane.
>>>>>>> laraxot/dev
