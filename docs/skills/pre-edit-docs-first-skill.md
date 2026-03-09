# Skill Operativa: Pre-Edit Docs-First

## Trigger

Usare questa skill prima di qualunque modifica al codice in moduli/temi.

## Procedura

1. Ragionare sul task e sui rischi.
2. Studiare `laravel/Modules/*/docs` del modulo impattato.
3. Studiare `laravel/Themes/*/docs` del tema impattato.
4. Aggiornare/migliorare prima le docs locali del modulo e del tema impattati.
5. Aggiornare documentazione globale minima:
   - `docs/rules/*`
   - `docs/memory/*`
   - `docs/skills/*`
6. Valutare aggiornamento/creazione GitHub Issue e GitHub Discussion per tracciare decisioni e avanzamento.
7. Solo dopo modificare codice.
8. Se il problema nasce da un refactor che ha rimosso API usate ancora a runtime, studiare il contratto via `git log`/`git show` e reintrodurre wrapper compatibili minimi nel codice corrente, senza restore di file storici.

## Checklist minima

- [ ] Letti gli indici docs del modulo/tema (`00-index.md`, `rules-index.md`)
- [ ] Aggiornata almeno una regola globale se cambia il comportamento operativo
- [ ] Aggiornata almeno una memory globale con snapshot decisionale
- [ ] Aggiornata almeno una docs locale nel modulo e nel tema toccati
- [ ] Migliorata la documentazione locale, non solo consultata
- [ ] Valutato aggiornamento o creazione di GitHub Issue/Discussion
- [ ] Se cambia l'infrastruttura test: documentato il workflow `migrate --env=testing` centralizzato in `Modules/Xot/tests/XotBaseTestCase.php` (una sola volta per processo, mai `--force`/`migrate:fresh`)
- [ ] Se l'obiettivo e coverage/stabilita test: classificati i test legacy non recuperabili e rinominati in `.old`
- [ ] Se tocchi migration che estendono `XotBaseMigration`: verificato che `tableCreate()` non sia avvolto da guard ridondanti su `tableExists()`
- [ ] Nessun file markdown nuovo/rinominato contiene date nel filename (regola: mai date nei nomi `.md`)
- [ ] Se hai studiato codice rimosso con git, hai documentato il contratto legacy e hai evitato restore wholesale dei file storici
