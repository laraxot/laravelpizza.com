# Regola Globale: Metodo getTableColumns per Filament Table

## Descrizione
Questa pagina raccoglie la regola e i collegamenti per l’adozione del metodo `getTableColumns` in tutte le Filament Table dei moduli del progetto.

## Regola
- **Usare sempre:** `getTableColumns`
- **Non usare più:** `getListTableColumns`

## Motivazione
- Uniformità con lo standard Filament
- Migliore leggibilità e manutenibilità
- Facilità di upgrade e adozione di nuove versioni

## Collegamenti Specifici
- [Regola Generale - Modulo Xot](../laravel/Modules/Xot/docs/FILAMENT_TABLE_COLUMNS.md)
- [Regola e Applicazione - Modulo Performance](../laravel/Modules/Performance/docs/filament-resources.md)
- [Esempio e Applicazione - Modulo User](../laravel/Modules/User/docs/filament/FILAMENT_TABLE_COLUMNS.md)

**Nota:** Nei moduli Laraxot, le pagine tabellari devono estendere `Modules\Xot\Filament\Resources\Pages\XotBaseListRecords` e non la classe base Filament.

## Note
- Ogni modulo deve documentare l’adozione nella sua docs/
- Aggiornare i link bidirezionali in caso di modifiche

---

**Ultimo aggiornamento:** 2025-05-13

**Link bidirezionale:** Aggiornare anche le docs dei moduli coinvolti.
