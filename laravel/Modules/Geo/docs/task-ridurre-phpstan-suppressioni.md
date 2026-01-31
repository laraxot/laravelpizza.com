# Task: Ridurre Suppressioni PHPStan Inline - Geo

**Modulo**: Geo
**Priorita'**: Alta
**Completamento**: 0%
**Data**: 2026-01-30

---

## File Coinvolti (37 suppressioni)

| File | Suppressioni | Tipo |
|------|-------------|------|
| `app/Models/Address.php` | 7 | mixed type su attributi geografici |
| `app/Models/Comune.php` | 6 | mixed type su dati JSON |
| `app/Models/ComuneJson.php` | 6 | mixed type su Sushi |
| `app/Filament/Forms/Components/AddressField.php` | 7 | form component types |
| `app/Filament/Forms/Components/AddressesField.php` | 6 | form component types |
| `app/Filament/Forms/LocationForm.php` | 3 | location type |
| `app/Services/HereService.php` | 1 | API response type |
| `app/Models/Traits/HasAddress.php` | 1 | relation type |

## Criteri di Completamento

- [ ] Tutte le 37 suppressioni analizzate
- [ ] Almeno 25 risolte con type narrowing
- [ ] PHPStan 0 errori mantenuto
