# Task: Ridurre Suppressioni PHPStan Inline - Xot

**Modulo**: Xot
**Priorita'**: Alta
**Completamento**: 0%
**Data**: 2026-01-30

---

## Descrizione

Il modulo Xot ha 60 suppressioni `@phpstan-ignore` inline nel codice app/. Queste mascherano problemi reali di tipo che dovrebbero essere risolti correttamente.

## File Principali da Correggere

| File | Suppressioni | Tipo Problema |
|------|-------------|---------------|
| `app/Filament/Traits/HasXotTable.php` | 16 | mixed type su metodi Filament |
| `app/Http/Middleware/Cors.php` | 5 | property.nonObject, method.nonObject |
| `app/Filament/Builders/FilterBuilder.php` | 4 | mixed type nei builder |
| `app/States/XotBaseState.php` | 3 | return.type su stati |
| `app/Filament/Pages/XotBasePage.php` | 3 | return.type |
| `app/Actions/Model/UpdateAction.php` | 1 | return.type |
| `app/Actions/Model/GetSicureArrayByModelAction.php` | 1 | return.type |
| `app/Providers/XotServiceProvider.php` | 1 | type safety |
| `app/Contracts/UserContract.php` | 1 | interface type |

## Approccio

1. Per ogni file con suppressioni, analizzare il tipo reale dell'errore
2. Preferire type narrowing (`assert`, `instanceof`) invece di suppress
3. Usare PHPDoc `@var`, `@param`, `@return` per guidare PHPStan
4. Solo se non risolvibile altrimenti, mantenere la suppressione con commento esplicativo

## Criteri di Completamento

- [ ] Tutte le suppressioni analizzate
- [ ] Almeno 40 delle 60 suppressioni risolte senza suppress
- [ ] PHPStan level 10 ancora a 0 errori dopo le modifiche
- [ ] Nessuna regressione nei test
