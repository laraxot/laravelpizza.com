# Changelog - Modulo Chart

All notable changes to this module will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Fixed
- **Architettura Modelli: Correzione BaseModel (15 Ottobre 2025)**
  - `BaseModel.php`: Ora estende `XotBaseModel` invece di `Model`
  - Rimossi: HasFactory, Updater, newFactory(), $snakeAttributes, $incrementing, $timestamps, $perPage, $primaryKey, $hidden, casts() base
  - Mantenuto: Solo `$connection = 'chart'` come proprietà specifica
  - **Benefici:** ~50 righe duplicate eliminate, gerarchia corretta, conformità architetturale
  - **Impatto:** Tutti i modelli del modulo Chart ora ereditano correttamente da XotBaseModel

## 1.0.0 - 202X-XX-XX

- Initial release





