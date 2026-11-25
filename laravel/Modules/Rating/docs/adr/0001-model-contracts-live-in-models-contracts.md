---
title: "ADR — I contratti implementabili solo da un model stanno in app/Models/Contracts"
type: decision
status: accepted
created: 2026-09-09
updated: 2026-11-24
module: Rating
tags: [adr, contracts, namespace, phpstan, models]
related:
  - ../dove-vive-un-contratto.md
qmd: "model contracts live models contratti implementabili"
---

# ADR: dove vive un'interfaccia

## Contesto

Rating ha due cartelle di interfacce: `app/Models/Contracts/` (`RatingContract`, `HasRatingContract`) e
`app/Contracts/` (`RatingsFormCallerContract`, `HasLikeContract`). `RatingContract` esiste perché `Rating` è
consumato da più moduli, ciascuno con la propria classe concreta su una connessione diversa (docblock di
`app/Models/Contracts/RatingContract.php`), e porta `@phpstan-require-extends Model`. `RatingsFormCallerContract`
lo implementa una Page di Filament. Un agente che aggiunge un'interfaccia sceglie la cartella del file più vicino,
e un nome di namespace che mente ("Models" su qualcosa che non è un model) viene copiato. Dove si mette un'interfaccia nuova?

## Decisione

- Un'interfaccia che porta `@phpstan-require-extends Model` (implementabile solo da un model) sta in
  `app/Models/Contracts/` (`Modules\Rating\Models\Contracts\…`).
- Tutte le altre stanno in `app/Contracts/`.
- La regola estesa con gli esempi è in `../dove-vive-un-contratto.md`.

## Alternative scartate

- **Tutto in `app/Contracts/`**: un'unica cartella, ma perde l'informazione "solo un model può implementarla" che il
  namespace oggi dà prima di aprire il file.
- **Tutto in `app/Models/Contracts/`**: `RatingsFormCallerContract` direbbe di cercare un model che non esiste.

## Conseguenze

- Buono: il namespace dice chi può implementare l'interfaccia.
- Cattivo: due cartelle da conoscere; spostare un'interfaccia cambia il FQCN in tutti i moduli consumatori.

## Verifica

- PHPStan (`./vendor/bin/phpstan analyse Modules/Rating`) fallisce se una classe che non estende `Model` implementa
  un'interfaccia con `@phpstan-require-extends Model`: protegge il vincolo, non la cartella.
- Solo revisione: un'interfaccia nuova in `app/Models/Contracts/` deve portare `@phpstan-require-extends Model`, una in
  `app/Contracts/` non deve.
