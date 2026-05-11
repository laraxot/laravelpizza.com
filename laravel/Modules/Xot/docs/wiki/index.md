# Xot Module LLM Wiki

Indice operativo del wiki Xot (core framework).

## Struttura canonica (sacred)

- [concepts/](./concepts/): Pattern architetturali e metodologie Xot/Laraxot.
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
- [laraxot-core](../../../../docs/wiki/concepts/laraxot-core.md): Core XotBase classes rules.
- [xotbase-check](../../../../docs/wiki/concepts/xotbase-check.md): Verify XotBase usage.

## Scopo Xot Module

Core framework Laraxot: XotBase classes, Actions, PHPStan Level 10, Filament integration, migrations, translations.

## Compiled Pages

| Pagina | Tipo | Argomento | Data |
|--------|------|-----------|------|
| [policy-inheritance-boundary](../User/docs/wiki/concepts/policy-inheritance-boundary.md) | Decision | Cross-module | 2026-04-27 |
| [unit-test-case-pattern](./concepts/unit-test-case-pattern.md) | Concept | Test patterns | 2026-04-21 |
| [phpstan-cluster-map-and-false-friends](./concepts/phpstan-cluster-map-and-false-friends.md) | Concept | PHPStan cluster | 2026-04-23 |
| [xotbasefield-calculated-view-rule](./concepts/xotbasefield-calculated-view-rule.md) | Concept | XotBaseField | 2026-04-23 |
| [policy-base-strategy](./concepts/policy-base-strategy.md) | Concept | Policy strategy | 2026-04-27 |
| [policy-module-matrix](./concepts/policy-module-matrix.md) | Concept | Policy matrix | 2026-04-27 |
| [laravel13-modular-package-compatibility-matrix](./concepts/laravel13-modular-package-compatibility-matrix.md) | Concept | Compatibilita' pacchetti modulo | 2026-04-28 |
| [claude-code-laraxot-rules-path-scoping](./concepts/claude-code-laraxot-rules-path-scoping.md) | Concept | Claude Code rules path-scoped per Xot/Laraxot | 2026-04-30 |
| [why-xotbaseresourceform-superior](./concepts/why-xotbaseresourceform-superior.md) | Concept | Perché TicketForm pattern è superiore al Filament demo | 2026-05-05 |
| [xotbase-resource-infolist-architecture](./concepts/xotbase-resource-infolist-architecture.md) | Concept | XotBaseResourceInfolist + TicketInfolist pattern | 2026-05-05 |
| [filament-v5-hybrid-pattern](./concepts/filament-v5-hybrid-pattern.md) | Concept | Filament v5 configure() + XotBase hybrid pattern | 2026-05-05 |
| [xotbase-table-columns-enforcement](./concepts/xotbase-table-columns-enforcement.md) | Concept | XotBaseResourceTable empty-column enforcement rule | 2026-05-07 |

## Best Practices

- Estendere sempre XotBase classes (vedi [xotbase-check](../../../../docs/wiki/concepts/xotbase-check.md))
- Usare Actions non Services (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- Implementare `casts()` method non `$casts` property (vedi [model-casts-phpstan](../../../../docs/wiki/concepts/model-casts-phpstan.md))
- PHPStan Level 10 enforcement (vedi [phpstan-level10](../../../../docs/wiki/concepts/phpstan-level10.md))
- Array con chiavi stringhe in Schemas/Tables (vedi [array-keys-rule](./array-keys-rule.md))

## Bad Practices

- NON creare Service classes - usare Actions (vedi [actions-over-services-governance](https://github.com/laraxot/base_fixcity_fila5/blob/main/.opencode/skills/actions-over-services-governance/SKILL.md))
- NON usare `dehydrated(false)` nei trait - blocca salvataggio (vedi Geo CoordinatePicker fix)
- NON dichiarare `$view` statica in XotBaseField - si calcola via `GetViewByClassAction`

## False Friends

- `dehydrated(false)` sembra mantenere il campo nei dati ma blocca il salvataggio (vedi [coordinate-picker-filament5-save-pattern](../../Geo/docs/wiki/concepts/coordinate-picker-filament5-save-pattern.md))
- `live()` in Filament non rende il campo sempre live - serve `$applyStateBindingModifiers()` (vedi [coordinate-picker-state-binding-rule](../../Geo/docs/wiki/concepts/coordinate-picker-state-binding-rule.md))

## Troubleshooting

| Pagina | Tipo | Argomento |
|--------|------|-----------|
| [xotbasefield-calculated-view-rule](./concepts/xotbasefield-calculated-view-rule.md) | Concept | XotBaseField runtime |

Aggiornato: 2026-04-30
