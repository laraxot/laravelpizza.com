# Media Module LLM Wiki

Indice operativo del wiki Media.

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie media.
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
- [medialibrary-development](../../../../docs/wiki/concepts/medialibrary-development.md): Spatie Laravel Media Library.

## Scopo Media Module

Gestione media, upload, conversioni, responsive images con spatie/laravel-medialibrary.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |
| [xotbase-table-columns-enforcement](./concepts/xotbase-table-columns-enforcement.md) | Concept | 3 Table files populated — Media, MediaConvert, TemporaryUpload | 2026-05-07 |

## Best Practices

- Usare Spatie Media Library per media (vedi [medialibrary-development](../../../../docs/wiki/concepts/medialibrary-development.md))
- Implementare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../docs/wiki/concepts/model-casts-phpstan.md))
- Usare XotBaseServiceProvider per registrazione media (vedi [laraxot-service-provider](../../../../docs/wiki/concepts/laraxot-service-provider.md))

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON hardcodare media path - usare config (vedi [laravel-security-audit](../../../../docs/wiki/concepts/laravel-security-audit.md))

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [.gitkeep](./concepts/.gitkeep) | Concept | Template iniziale |

Aggiornato: 2026-04-28
