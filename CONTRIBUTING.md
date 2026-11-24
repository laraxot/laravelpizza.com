# Contributing

Grazie per voler contribuire a **LaravelPizza** / Laraxot.

1. Leggi il [Code of Conduct](CODE_OF_CONDUCT.md).
2. Segui la guida completa: [docs/contributing.md](docs/contributing.md).
3. Preferisci **pull request da fork** (non push diretti): le PR merged da
   contributor esterni sono la prova di community reale per il programma
   open-source.
4. Segnala vulnerabilità come descritto in [SECURITY.md](SECURITY.md).

## Quick path (good first issue)

1. Scegli un issue con label `good first issue` o `help wanted`.
2. Fork → branch `fix/...` o `docs/...`.
3. Rispetta PHPStan level 10, Pint, Folio+Volt per il frontoffice.
4. Apri la PR con il template e collega l'issue.

## Checklist per la prima PR

Sei nuovo qui? Segui questa breve checklist per la tua prima pull request:

- [ ] Fai un fork del repository e clona il tuo fork; non fare mai push diretto sul branch predefinito.
- [ ] Crea un branch tematico (`docs/...`, `fix/...` o `feature/...`).
- [ ] Se hai modificato file PHP, esegui `vendor/bin/pint` e PHPStan livello 10 sui
      file modificati (vedi [Code Standards](docs/contributing.md#code-standards)).
- [ ] Compila il [template della pull request](.github/pull_request_template.md), collega
      l'issue (`Closes #...`) e apri la PR dal tuo fork.

## Perché le PR contano

Questo progetto vuole essere un starter riusabile per meetup Laravel.
Le contribution esterne merged sono la metrica più utile (e onesta) per
dimostrare impatto open-source: mira a contributor unici con PR merged,
non a push monolitici del solo maintainer.

## AI agent contributions

Se usi Claude Code / altri agent:

- non riscrivere la history (`reset` / force-push vietati sui branch condivisi);
- nei commit generati da agent, preferisci trailer `Co-Authored-By:` con
  identità reali (bot solo se è un account bot vero);
- le PR da umani esterni restano la metrica community: gli agent aiutano, non
  sostituiscono contributor unici.
