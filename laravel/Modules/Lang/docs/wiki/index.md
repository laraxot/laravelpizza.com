# Lang Module LLM Wiki

Indice operativo del wiki Lang.

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie localizzazione.
- [entities/](./entities/): Modelli e componenti chiave.
- [sources/](./sources/): Dati di ricerca e link esterni.
- [comparisons/](./comparisons/): Implementazioni alternative.
- [decisions/](./decisions/): ADL (Architectural Decision Log).
- [troubleshooting/](./troubleshooting/): Problemi noti e soluzioni.
- [_archive/](./_archive/): Documentazione legacy.
- [_templates/](./_templates/): Template standard.

## Regole collegate

- [forbidden-folders-rule](../../../../docs/wiki/concepts/forbidden-folders.md): Vincoli strutturali strict.
- [llm-wiki-standard](../../../../docs/project/karpathy-llm-wiki-adoption.md): Mapping repository e ciclo di vita conoscenza.
- [laravel-localization](../../../../docs/wiki/concepts/laravel-localization.md): Integrazione mcamara/laravel-localization.
- [laravel12-lang-path-rule](./concepts/laravel12-lang-path-rule.md): Path corrette Laravel 12.

## Scopo Lang Module

Gestione traduzioni, localizzazione, fallback e integrazione mcamara/laravel-localization.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |
| [laravel12-lang-path-rule](./concepts/laravel12-lang-path-rule.md) | Concept | Path Laravel 12 | 2026-04-21 |
| [xotbase-table-columns-enforcement](./concepts/xotbase-table-columns-enforcement.md) | Concept | 1 Table file — TranslationFilesTable populated | 2026-05-07 |

## Best Practices

- Seguire 5-level pattern per traduzioni (vedi [translation-check](../../../../docs/wiki/concepts/translation-check.md))
- Usare XotBaseServiceProvider per registrazione traduzioni (vedi [laraxot-service-provider](../../../../docs/wiki/concepts/laraxot-service-provider.md))
- Implementare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../docs/wiki/concepts/model-casts-phpstan.md))

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON hardcodare stringhe - usare translation files (vedi [laravel-localization](../../../../docs/wiki/concepts/laravel-localization.md))

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [laravel12-lang-path-rule](./concepts/laravel12-lang-path-rule.md) | Concept | Path Laravel 12 corrette |

Aggiornato: 2026-04-28
