# Log Risoluzione Conflitti Git (Merge Conflict Resolution Log)

<<<<<<< .merge_file_ROMjtX
Questo documento traccia la cronologia delle risoluzioni dei conflitti massivi incontrati durante lo sviluppo del progetto healthcare_app.
=======
Questo documento traccia la cronologia delle risoluzioni dei conflitti massivi incontrati durante lo sviluppo del progetto ModuloEsempio.
>>>>>>> .merge_file_KckxnN

## 📅 27 Gennaio 2026 - Risoluzione Corrente (Antigravity)

**Status**: ✅ COMPLETATO
**Responsabile**: Antigravity

### File Corretti
- `Modules/Notify/tests/Feature/JsonComponentsTest.php`: Risolti conflitti di asserzioni e setup.
<<<<<<< .merge_file_ROMjtX
- `Modules/Lang/docs/translatable/json-content-translation.md`: Corretti placeholder `<nome progetto>` in `healthcare_app`.
=======
- `Modules/Lang/docs/translatable/json-content-translation.md`: Corretti placeholder `<nome progetto>` in `ptvx`.
>>>>>>> .merge_file_KckxnN
- `Modules/User/app/Models/OauthPersonalAccessClient.php`: Pulizia PHPDoc e risoluzione conflitti UUID.
- `Modules/User/app/Models/Role.php`: Risoluzione massiva di PHPDoc duplicati e contrastanti (id `int` vs `string`).
- `Modules/User/app/Models/OauthClient.php`: Rimozione import duplicati e pulizia PHPDoc.
- `Modules/User/app/Models/OauthToken.php`: Consolidamento PHPDoc.
- `Modules/User/docs/phpstan-fixes-roadmap.md`: Risolto conflitto finale.
- `Modules/Xot/docs/consolidated/testing-best-practices-uppercase-1.md`: Risolto conflitto e corretto placeholder namespace.
- `Modules/Geo/docs/README.md`: Re-integrazione completa dopo corruzione da conflitti.

---

## 📅 06 Gennaio 2025 - Risoluzione Servizi Geo e Tema Two

**Status**: ✅ COMPLETATO
**Responsabile**: Sistema di correzione automatica

### Modulo Geo
- **AddressResource.php**: Risolta gestione `postal_code` e rimosso codice obsoleto.
- **Locality.php**: Aggiunto import `Safe\json_decode` e risolta gestione dati JSON.
- **Traduzioni**: Aggiornamento `webbingbrasil-map.php` e `geo.php` (EN).

### Tema Two
- **doctor_states.php** & **patient_states.php**: Rimossa duplicazione chiavi `integration_*` in tutte le lingue (IT/EN/DE).

---

## 📅 04 Novembre 2025 - Emergenza `artisan serve`

**Status**: ✅ COMPLETATO
**Responsabile**: Team Laraxot

### Problema
Il comando `php artisan serve` falliva per errori di sintassi causati da conflitti in 16+ file critici.

### File Corretti (Esempi)
- **RouteServiceProvider.php**: Pattern `if` triplicati con singola chiusura.
- **XotData.php**: Metodi `make()`, `getUserByEmail()` duplicati massivamente.
- **HasXotTable.php**: Import duplicati e blocchi `if` incompleti.
- **MetatagData.php**: Proprietà e metodi triplicati.
- **XotBaseChartWidget.php**: Metodi duplicati fuori dalla classe.

---

## 🔧 Pattern di Risoluzione Standard (Best Practices)

1. **DRY (Don't Repeat Yourself)**: Ogni proprietà o metodo deve esistere una sola volta.
2. **Type Safety**: Preferire `?type` a `null|type` (PSR-12).
3. **Defensive Programming**: Verificare sempre la chiusura di ogni blocco `{}`.
4. **Import Hygiene**: Rimuovere `use` statements duplicati.
<<<<<<< .merge_file_ROMjtX
5. **Placeholder Correction**: Sostituire stringhe come `<nome progetto>` con il valore reale (`healthcare_app`).
=======
5. **Placeholder Correction**: Sostituire stringhe come `<nome progetto>` con il valore reale (`ptvx`).
>>>>>>> .merge_file_KckxnN

## 🔐 Regola d'Oro: File Locking (Prevenzione)

Per evitare conflitti durante modifiche concorrenti:
1. `touch file.php.lock` prima di iniziare.
2. Se il lock esiste, skippare il file.
3. `rm file.php.lock` a fine modifica.

---
*Documento mantenuto secondo la metodologia Super Mucca.*
