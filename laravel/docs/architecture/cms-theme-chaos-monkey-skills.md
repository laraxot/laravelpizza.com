# Skills Operative - CMS Theme Chaos Monkey

## Skill 1: Render Chain Isolation

Obiettivo: capire in meno di 10 minuti dove si rompe la catena di rendering.

Passi:
1. Confermare route con `php artisan folio:list`.
2. Aprire page Folio e confermare `x-page` con slug previsto.
3. Aprire JSON pagina tenant e verificare blocchi.
4. Verificare esistenza delle view blocco.

## Skill 2: Block Query Recovery

Obiettivo: ripristinare blocchi query-driven senza cambiare architettura.

Passi:
1. Verificare `data.query.model` FQCN.
2. Controllare ordinamento/limit/wrap_in.
3. Validare shape dati attesa dalla view.
4. Applicare fallback solo locale al blocco guasto.

## Skill 3: Localized URL Integrity

Obiettivo: evitare regressioni i18n in link dinamici.

Passi:
1. Cercare concatenazioni hardcoded in Blade/Alpine.
2. Usare campo URL già localizzato nel payload.
3. Verificare output locale su almeno due lingue.

## Riferimenti

- [rules/cms-theme-chaos-monkey-rules](../rules/cms-theme-chaos-monkey-rules.md)
- [memory/cms-theme-chaos-monkey-memory](../memory/cms-theme-chaos-monkey-memory.md)
