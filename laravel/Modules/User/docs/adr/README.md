---
title: "ADR — modulo User"
type: index
tags: [adr, decisioni, user, autenticazione]
created: 2026-11-18
updated: 2026-11-24
owner: User
qmd: "User ADR architecture decision record MADR formato decisioni identità ruoli"
---

# ADR del modulo User

Il **perché** delle scelte di autenticazione e identità: come si riconosce un utente che entra con SPID/CIE, dove si blocca un account cancellato, come si frenano i moduli aperti agli anonimi, perché l'audit degli accessi non può rompere il login, chi possiede la pagina di login del front office e chi possiede identità, ruoli e team.

Leggili prima di toccare `app/Actions/Auth/*`, i widget di login/registrazione o il provider utenti, e prima di "semplificare" un controllo che sembra ridondante.

## Metodo Harness

Scrivere un ADR solo per una scelta difficile da invertire, sorprendente o fondata su un trade-off reale. Un ADR deve rendere leggibili contesto, driver, alternative, decisione, conseguenze e una conferma ripetibile; non e' un diario ne' una spiegazione retroattiva inventata.

Le decisioni vanno verificate contro codice e test correnti. Una modifica sostanziale crea un nuovo ADR e collega il precedente come `superseded` o `deprecated`.

Il nome del file e' l'argomento in kebab-case, senza date ne' numeri (la data sta nella frontmatter). Questo README e' l'indice della cartella: ogni ADR compare qui come `[titolo](file.md)`; la tabella con lo stato di ciascuno e' in [INDEX.md](INDEX.md).

Regola canonica del formato: [action-behavioral-contract](../../../Xot/docs/rules/action-behavioral-contract.md); standard condivisi: [Xot ADR](../../../Xot/docs/adr/README.md).

## Formato

```markdown
---
title: "ADR — <decisione in una riga>"
type: decision
status: proposed | accepted | superseded | deprecated
created: AAAA-MM-GG
updated: AAAA-MM-GG
issues: []
---

# ADR: <decisione>

## Contesto
Fatti e vincoli che hanno reso necessaria la scelta (misure, norme, policy, incidenti).

## Driver
Facoltativa: vincoli, rischi e obiettivi che pesano sulla scelta.

## Decisione
Cosa si fa, in concreto, e dove sta nel codice.

## Alternative scartate
Ogni alternativa seria, con il motivo per cui non e' stata scelta.

## Conseguenze
Pro, contro, debito che resta, cosa misurare. Chi cambia la decisione scrive un nuovo ADR e segna questo `superseded`.

## Conferma
Facoltativa: controllo ripetibile (test, guard source-level, review). La presenza dell'ADR non prova l'implementazione.

## Verifica
Comandi e test che esistono davvero; i path `Modules/...php` citati devono esistere.
```

Almeno un ADR per pacchetto e' "sostanziale": ha anche `## Driver` e `## Conferma`.

## Decisioni

- [L'utente SPID/CIE si riconosce dal codice fiscale](digital-identity-upsert-by-fiscal-code.md) — CF prima, email solo se verificata, segnaposto `@noemail.local`.
- [L'account cancellato si blocca nel provider utenti](deleted-account-blocked-in-user-provider.md) — filtro `deleted_at` nel provider, niente `SoftDeletes`, token revocati.
- [Freno per IP ed email prima di validare](auth-submission-throttle-before-validation.md) — registrazione e recupero password contano ogni invio, chiavi hashate.
- [Il registro degli accessi non rompe mai il login](authentication-log-never-breaks-login.md) — connessione `user`, tabella assente = warning.
- [La pagina login del front office segue il tema](frontoffice-login-page-ownership.md) — logica nel `LoginWidget`, resa del tema attivo, fallback del modulo che monta lo stesso widget.
- [User possiede identità, ruoli e team](user-owns-identity-and-roles.md) — gli altri moduli usano policy e contratti User.
- [Gli account cancellati si escludono nel provider di autenticazione](deleted-accounts-are-filtered-by-auth-provider.md) — ADR in formato MADR sullo stesso tema dell'account cancellato (`deleted_at`, provider utenti).

## Decisioni precedenti (formato libero, non ancora ADR)

- [contracts-and-lang-backup-archival](../wiki/decisions/contracts-and-lang-backup-archival.md)
- [contracts-and-lang-backup-archival.deprecated](../wiki/decisions/contracts-and-lang-backup-archival.deprecated.md)
- [contracts-and-lang-backup-archival-](../wiki/decisions/contracts-and-lang-backup-archival-.md)
- [contracts-and-lang-backup-archival-.deprecated](../wiki/decisions/contracts-and-lang-backup-archival-.deprecated.md)
- [contracts-and-lang-backup-archival-30](../wiki/decisions/contracts-and-lang-backup-archival-30.md)
- [contracts-and-lang-backup-archival-30.deprecated](../wiki/decisions/contracts-and-lang-backup-archival-30.deprecated.md)
- [archiviazione orfani (ponytail audit)](../wiki/decisions/contracts-and-lang-backup-archival-archiviazione-orfani-ponytail-audit.md)

Policy trasversale su dati sacri e test isolati: [0013-dati-sacri-migrazioni-e-test](../../../Xot/docs/adr/0013-dati-sacri-migrazioni-e-test.md).
