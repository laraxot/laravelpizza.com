# Test di Risoluzione Conflitti nel Modulo UI

## Descrizione

Questo documento descrive i test automatici creati per verificare la corretta risoluzione dei conflitti git nei file del modulo UI.

## Test Implementati

### TableLayoutToggleTest

Il test `TableLayoutToggleTest` verifica che il componente `TableLayoutToggleTableAction` sia stato correttamente risolto e funzioni come previsto:

- `test_table_layout_toggle_action_exists()`: Verifica che la classe e l'interfaccia `HasTableLayout` esistano.
- `test_table_layout_toggle_action_make()`: Verifica che il metodo `make()` costruisca correttamente l'istanza.

### AddressFieldTest

Il test `AddressFieldTest` verifica che il componente `AddressField` sia stato correttamente risolto e funzioni come previsto:

- `test_address_field_exists()`: Verifica che la classe esista.
- `test_address_field_make()`: Verifica che il metodo `make()` costruisca correttamente l'istanza.
- `test_address_field_relationship()`: Verifica che il metodo `relationship()` funzioni correttamente.

## Esecuzione dei Test

Per eseguire i test:

```bash
cd laravel
./vendor/bin/pest --filter=TableLayoutToggleTest
./vendor/bin/pest --filter=AddressFieldTest
```

## Collegamenti alla Documentazione

- [CONFLITTI_MERGE_RISOLTI.md](CONFLITTI_MERGE_RISOLTI.md): Documentazione dei conflitti risolti nel modulo UI.
- [actions/table_layout_toggle.md](actions/table_layout_toggle.md): Documentazione dell'azione TableLayoutToggle.
- [components.md](components.md): Documentazione dei componenti UI, incluso AddressField.

## Collegamenti Principali

- [Risoluzione Conflitti Git](../../../../docs/risoluzione_conflitti_git.md): Documentazione principale sulla risoluzione dei conflitti git.
- [UI Conflict Links](../../../../docs/ui_conflict_links.md): Collegamenti ai file di risoluzione dei conflitti nel modulo UI.
# Test di Risoluzione Conflitti nel Modulo UI

## Descrizione

Questo documento descrive i test automatici creati per verificare la corretta risoluzione dei conflitti git nei file del modulo UI.

## Test Implementati

### TableLayoutToggleTest

Il test `TableLayoutToggleTest` verifica che il componente `TableLayoutToggleTableAction` sia stato correttamente risolto e funzioni come previsto:

- `test_table_layout_toggle_action_exists()`: Verifica che la classe e l'interfaccia `HasTableLayout` esistano.
- `test_table_layout_toggle_action_make()`: Verifica che il metodo `make()` costruisca correttamente l'istanza.

### AddressFieldTest

Il test `AddressFieldTest` verifica che il componente `AddressField` sia stato correttamente risolto e funzioni come previsto:

- `test_address_field_exists()`: Verifica che la classe esista.
- `test_address_field_make()`: Verifica che il metodo `make()` costruisca correttamente l'istanza.
- `test_address_field_relationship()`: Verifica che il metodo `relationship()` funzioni correttamente.

## Esecuzione dei Test

Per eseguire i test:

```bash
cd laravel
./vendor/bin/pest --filter=TableLayoutToggleTest
./vendor/bin/pest --filter=AddressFieldTest
```

## Collegamenti alla Documentazione

- [CONFLITTI_MERGE_RISOLTI.md](CONFLITTI_MERGE_RISOLTI.md): Documentazione dei conflitti risolti nel modulo UI.
- [actions/table_layout_toggle.md](actions/table_layout_toggle.md): Documentazione dell'azione TableLayoutToggle.
- [components.md](components.md): Documentazione dei componenti UI, incluso AddressField.

## Collegamenti Principali

- [Risoluzione Conflitti Git](../../../../docs/risoluzione_conflitti_git.md): Documentazione principale sulla risoluzione dei conflitti git.
- [UI Conflict Links](../../../../docs/ui_conflict_links.md): Collegamenti ai file di risoluzione dei conflitti nel modulo UI.
