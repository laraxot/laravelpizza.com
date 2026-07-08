# Handoff — conflitti Git Xot + PHPStan

**Data:** 2026-07-01  
**Scope:** `laravel/Modules/Xot` (marker `<<<<<<<` nel working tree, non merge attivo)

## Fatto

- Risolti conflitti PHP con merge manuale (architettura Laraxot, non script cieco).
- Navigazione admin: `array_merge(GetModulesNavigationItems, GetPanelsNavigationItems)` in `XotBaseMainPanelProvider`.
- SSoT panel↔modulo: `PanelModuleResolver` + `PanelMixin` (macro Filament).
- SVG/assets: sweep automatico iterativo (`scripts/resolve_merge_conflicts.py`).
- **Marker residui:** 0 (esclusi fixture phpcs in vendor).
- **PHPStan `Modules/Xot`:** OK (0 errori).

## Scelte merge (PHP)

| File | Scelta |
|------|--------|
| `XotBasePage::hasPermissionTo` | `getUser()->hasPermissionTo()` diretto |
| `HandlersRepository` | `fn (callable $handler)` — array già tipizzato |
| `FakeSeederAction` | `static fn (Model $item)` |
| `SafeArrayCastAction::executeWithFilter` | `array_flip($allowedKeys)` — PHPDoc `array<int,string>` |
| `XlsByModelClassAction` | `instanceof Model` |

## Verifica

```bash
find . \( -path ./laravel/vendor -o -path ./.git \) -prune -o -type f -exec grep -l '^<<<<<<< ' {} + 2>/dev/null | wc -l
# atteso: 0

cd laravel && ./vendor/bin/phpstan analyse Modules/Xot
```

## Canon

- [conflict-resolution-progress](../../laravel/Modules/Xot/docs/git/logs/conflict-resolution-progress.md)
- [git-merge-conflict-inventory](../../laravel/Modules/Xot/docs/wiki/troubleshooting/git-merge-conflict-inventory.md)
