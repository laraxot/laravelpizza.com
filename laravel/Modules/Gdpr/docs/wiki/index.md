# Gdpr Module LLM Wiki

Indice operativo del wiki Gdpr.

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie GDPR.
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
- [laravel-security-audit](../../../../docs/wiki/concepts/laravel-security-audit.md): Audit sicurezza Laravel.

## Scopo Gdpr Module

Gestione conformità GDPR, privacy policy, consensi utente e cookie.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [.gitkeep](./concepts/.gitkeep) | Concept | - | 2026-04-21 |

## Best Practices

- Usare Actions per privacy logic (vedi [actions-over-services-governance](../../../../docs/wiki/concepts/actions-over-services-governance.md))
- Implementare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../docs/wiki/concepts/model-casts-phpstan.md))
- Usare Enums per stati consenso (vedi [laravel-enums](../../../../docs/wiki/concepts/laravel-enums.md))

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](../../../../docs/wiki/concepts/actions-over-services-governance.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON hardcodare privacy text - usare translation files (vedi [laravel-localization](../../../../docs/wiki/concepts/laravel-localization.md))

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [.gitkeep](./concepts/.gitkeep) | Concept | Template iniziale |

Aggiornato: 2026-04-28
