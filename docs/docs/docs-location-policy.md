# Documentazione: Policy Posizione Docs (Modulo User)

## Regola
- Vietato usare `/docs` in root del repository.
- Usare esclusivamente `laravel/Modules/<ModuleName>/docs/` per la documentazione.

## Motivazioni
- Evita duplicazioni e inconsistenze.
- Facilita responsabilità e reperibilità per modulo.

## Azioni Esecutive
- Aggiunta regola in `.cursor/rules/docs-location-policy.mdc` che blocca la root `docs`.
- Verificare PR che includano solo file in `Modules/*/docs`.

## Come Migrare
1. Identifica file sotto `/docs` root.
2. Spostali nel modulo pertinente in `laravel/Modules/<Module>/docs/`.
3. Aggiorna backlink tra moduli se necessario.

## Checklist
- [ ] Nessun nuovo file in `/docs` root
- [ ] Nuovi documenti solo in `Modules/*/docs`
- [ ] Backlink corretti tra documentazioni
