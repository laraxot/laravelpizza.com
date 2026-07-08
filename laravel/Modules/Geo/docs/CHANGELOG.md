# Changelog

All notable changes to `:package_name` will be documented in this file.

## 1.0.0 - 202X-XX-XX

- initial release
# Changelog del Modulo Xot

## Versione Attuale (10/2023)

### Correzioni di Bug
- **Risolto**: Errore "Method Filament\Actions\Action::table does not exist" nel trait `HasXotTable`
  - Modificato il metodo `table()` per verificare l'esistenza dei metodi prima di chiamarli
  - Aggiunto supporto condizionale per `headerActions()`, `actions()` e `bulkActions()`
  - Questo risolve l'incompatibilità con Filament 3

### Miglioramenti
- Aggiunta documentazione nel codice per spiegare le modifiche e prevenire futuri problemi

## Note di Compatibilità
- Si consiglia di verificare le implementazioni di `getTableActions()` e metodi simili nelle classi che estendono `XotBaseListRecords`
- Se si incontrano errori simili, consultare il documento `xot_compatibility.md` nel modulo Broker

---

*Ultimo aggiornamento: 10/2023*
