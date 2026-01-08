# Regola Generale: Metodo getTableColumns per Filament Table (Xot)

## Regola
Tutte le Filament Table (Pages, RelationManagers, ecc.) nei moduli devono usare il metodo `getTableColumns` per definire le colonne della tabella.

- **Non usare più:** `getListTableColumns`
- **Usare sempre:** `getTableColumns`

## Motivazione
- Uniformità con lo standard Filament
- Migliore leggibilità e manutenibilità
- Facilità di upgrade e adozione di nuove versioni

## Esempio
```php
// Corretto
public function getTableColumns(): array
{
    return [ ... ];
}
```

## Applicazione
- Obbligatorio per tutti i moduli
- Ogni modulo deve documentare l'adozione nella sua docs/
- Aggiornare override, chiamate e test

**Nota:** Nei moduli come Performance, la logica tabellare (colonne, filtri, azioni) va sempre nelle pagine (che estendono `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords`), non nelle Resource. Vedi esempio e motivazione nella [documentazione Performance](../../Performance/docs/filament-resources.md).

## Collegamenti
- [Esempio e Applicazione - Modulo User](../../../User/docs/filament/FILAMENT_TABLE_COLUMNS.md)
- [Regola Globale - Root Docs](../../../../docs/filament-table-columns.md)

## Nota storica: correzione XotBaseManageRelatedRecords

- La classe XotBaseManageRelatedRecords è stata aggiornata per rispettare PHPStan livello 10.
- Tutti i metodi pubblici sono ora tipizzati e documentati con PHPDoc.
- Uso sistematico di Assert e fallback robusti.
- Vietato l'uso di return impliciti, mixed o cast forzati.
- Il metodo per le colonne della tabella è sempre getTableColumns.

**Collegamento:** Vedi anche [filament_components.md](./filament_components.md)

---

**Ultimo aggiornamento:** 2025-05-13

**Link bidirezionale:** Aggiornare anche la root docs e la docs dei moduli coinvolti.
