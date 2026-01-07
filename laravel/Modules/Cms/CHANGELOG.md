# Changelog - Modulo Cms

All notable changes to this module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed
- **Architettura Modelli: Correzione BaseModel (15 Ottobre 2025)**
  - `BaseModel.php`: Ora estende `XotBaseModel` invece di `Model`
  - Rimossi: HasFactory, Updater, Cachable, newFactory(), $snakeAttributes, $incrementing, $timestamps, $perPage, $primaryKey, $hidden
  - Mantenuto: `$connection = 'cms'`, `$keyType = 'string'`, casts specifici per UUID
  - **Benefici:** ~45 righe duplicate eliminate, supporto UUID mantenuto
  - **Impatto:** Tutti i modelli CMS ora seguono l'architettura Laraxot standard

## 1.0.0 - 202X-XX-XX

- Initial release





