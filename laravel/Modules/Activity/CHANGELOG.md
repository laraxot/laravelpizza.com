# Changelog

Tutte le variazioni importanti di Activity saranno generate automaticamente da semantic-release.

## [Unreleased]

### Security
- Whitelist per `logout_reason` in `LogoutListener` (era iniettabile senza validazione)
- `viewAny` implementato in `ActivityPolicy`, `SnapshotPolicy`, `StoredEventPolicy` (era commentato)
- `ActivityRecorderInterface` ora ha un'implementazione concreta (`ActivityRecorder`) bindata nel container

### Fixed
- `LoginListener` registrava l'evento di login senza fare nulla (stub vuoto)
- Rimosso file di backup committato per errore (`BaseModel.php.backup-*`)
- Rimossa cartella di fixture duplicata (`tests/fixtures/` vs `tests/Fixtures/`)

### Changed
- `ActivityLogger` diviso in `ActivityLogger` (scrittura), `ActivityQueryRepository` (query/statistiche), `ActivityMaintenanceAction` (pulizia)
- `getStatistics()` ora usa cache (5 minuti)
- `cleanOld()` usa `chunkById` invece di un DELETE bulk non limitato
- Dipendenze `spatie/laravel-activitylog` e `spatie/laravel-event-sourcing` pinnate al major installato (`^5.0`, `^7.15`) invece di `"*"`
