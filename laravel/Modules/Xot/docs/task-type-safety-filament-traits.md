# Task: Migliorare Type Safety nei Filament Traits - Xot

**Modulo**: Xot
**Priorita'**: Media
**Completamento**: 50%
**Data**: 2026-01-30

---

## Descrizione

I traits Filament del modulo Xot (in particolare `HasXotTable`) hanno 16 suppressioni PHPStan che indicano problemi di type safety con tipi `mixed`. Questo impatta tutti i moduli che utilizzano queste funzionalita'.

## File Coinvolti

| File | Issue |
|------|-------|
| `app/Filament/Traits/HasXotTable.php` | 16 suppress - mixed type in filter/column builders |
| `app/Filament/Builders/FilterBuilder.php` | 4 suppress - mixed in chain building |
| `app/Filament/Resources/XotBaseResource.php` | 1 suppress - return type |
| `app/Filament/Resources/RelationManagers/XotBaseRelationManager.php` | 2 suppress - return type |

## Approccio

1. Aggiungere generics PHPDoc ai metodi builder
2. Usare type narrowing con `assert()` e `instanceof`
3. Creare typed wrapper methods dove Filament restituisce `mixed`
4. Documentare i casi irrisolvibili (limiti di Filament API)

## Criteri di Completamento

- [ ] HasXotTable: ridotte suppressioni da 16 a max 5
- [ ] FilterBuilder: 0 suppressioni
- [ ] XotBaseResource: 0 suppressioni
- [ ] PHPStan level 10 ancora a 0 errori
- [ ] Tutti i pannelli Filament funzionanti dopo le modifiche
