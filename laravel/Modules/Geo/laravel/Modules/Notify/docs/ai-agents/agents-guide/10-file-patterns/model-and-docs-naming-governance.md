# Model And Docs Naming Governance

## Scope

This governance applies to:

- `laravel/Modules/*/app/Models`
- `laravel/Modules/*/docs`
- `laravel/Themes/*/docs`

## Rules

1. Model class names must be singular (`Scheda`, `Progressione`, `Valutatore`).
2. Database table names stay plural (`schede`, `progressioni`, `valutatori`).
3. Filament resource `$model` must reference the singular model class.
4. Factories must use singular model names (`SchedaFactory` for `Scheda`).
5. Any model rename must include code + docs + tracking update in the same change.

## Docs Hygiene

1. Keep one canonical filename per topic (`kebab-case`).
2. Do not create both `my-file.md` and `my_file.md` for the same topic.
3. Put historical duplicates under an explicit archive folder and link the canonical file.
4. Add or update one `README.md` or `00-index.md` in each `docs/` folder.
5. Prefer relative links; avoid stale absolute references.

## Required Checklist For Model Renames

- [ ] Model filename and class updated
- [ ] Factory filename/class updated
- [ ] Filament resource references updated
- [ ] Policy type hints updated
- [ ] PHPDoc generics/type hints updated
- [ ] Module docs updated
- [ ] Theme docs/indexes updated if they reference the model
- [ ] GitHub issue/discussion updated
