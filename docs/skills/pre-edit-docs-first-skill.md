# Skill Operativa: Pre-Edit Docs-First

## Trigger

Usare questa skill prima di qualunque modifica al codice in moduli/temi.

## Procedura

1. Ragionare sul task e sui rischi.
2. Studiare `docs` del modulo/tema impattato.
3. Aggiornare documentazione globale minima:
   - `docs/rules/*`
   - `docs/memory/*`
   - `docs/skills/*`
4. Solo dopo modificare codice.

## Checklist minima

- [ ] Letti gli indici docs del modulo/tema (`00-index.md`, `rules-index.md`)
- [ ] Aggiornata almeno una regola globale se cambia il comportamento operativo
- [ ] Aggiornata almeno una memory globale con snapshot decisionale
- [ ] Se cambia l'infrastruttura test: documentato il workflow `migrate --env=testing` centralizzato in `Modules/Xot/tests/XotBaseTestCase.php` (una sola volta per processo, mai `--force`/`migrate:fresh`)
- [ ] Se l'obiettivo e coverage/stabilita test: classificati i test legacy non recuperabili e rinominati in `.old`
- [ ] Se tocchi migration che estendono `XotBaseMigration`: verificato che `tableCreate()` non sia avvolto da guard ridondanti su `tableExists()`
- [ ] Nessun file markdown nuovo/rinominato contiene date nel filename (regola: mai date nei nomi `.md`)
