# AGENTS Filament Migration

Guida alla migrazione da Filament v3/v4 a v5.

## Critical Breaking Changes for Filament v5

| Requisito | Stato Attuale | Necessario |
|-----------|---------------|------------|
| PHP 8.2+ | ✅ Soddisfatto | ✅ |
| Laravel 11.28+ | ✅ Soddisfatto (Laravel 12) | ✅ |
| Livewire v4.0+ | ❌ v3 - DA AGGIORNARE | ✅ |
| Tailwind CSS v4.0+ | ❌ v3 - DA AGGIORNARE | ✅ |

---

## Migration Process

```bash
# 1. Install upgrade tool
composer require filament/upgrade:"^5.0" -W --dev

# 2. Run automated upgrade script
vendor/bin/filament-v5

# 3. Follow script output commands
composer require filament/filament:"^5.0" -W --no-update
composer update

# 4. Remove upgrade tool
composer remove filament/upgrade --dev
```

---

## Key Areas to Check After Migration

1. **Livewire v4 syntax changes**
2. **Tailwind CSS v4 configuration**
3. **Module compatibility** (test each module)
4. **Custom Filament resources and pages**
5. **Asset compilation** (Vite configs)

---

## Migration Checklist

### Prima della migrazione
- [ ] Backup current working state
- [ ] Check all custom Filament resources
- [ ] Review Livewire components
- [ ] Test current functionality

### Dopo la migrazione
- [ ] Run `php artisan filament:upgrade`
- [ ] Update Livewire to v4
- [ ] Update Tailwind to v4
- [ ] Test all modules
- [ ] Update custom components
- [ ] Verify asset compilation
- [ ] Run full test suite

---

## 🔗 Link

- [Indice AGENTS](./agents-split-index.md)
- [filament-patterns.md](./filament-patterns.md) - Pattern Filament
- [AGENTS.md originale](../../AGENTS.md)
- [Index principale](./index.md)
