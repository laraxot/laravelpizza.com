---
title: "Xot: far passare i test Pest di feature"
type: story
status: blocked
priority: P1
module: Xot
tags: [test, pest, feature, filament, fix-structure, contratti]
---

# Xot: far passare i test Pest di feature

Fase BMAD: Dev (correzione). Scope: sette file in `laravel/Modules/Xot/tests/Feature/`.

## Stato

- Esito: sette file corretti. Ogni file era verde nell'ultima esecuzione completa precedente alle 10:16 del 2026-10-28.
- Bloccata la rieseguita finale e la PHPStan: dalle 10:16 l'applicazione non si avvia (vedi "Blocco").

## Blocco (fuori dal gruppo)

`Modules/Xot/app/Filament/Resources/RelationManagers/XotBaseRelationManager.php:110` dichiara `final public function form()`. Il metodo e' in storia dal commit `a036998ef` (maggio 2026). Dal 2026-10-28 10:16 `Modules/Ptv/app/Filament/Resources/AnagResource/RelationManagers/AszEffRelationManager.php` (modifica non committata) lo sovrascrive. Il boot di Filament carica tutte le risorse e il PHP fallisce con `Cannot override final method`. Ogni run Pest e la PHPStan si fermano in boot.

Decisione richiesta: rimuovere `final` da `form()` in XotBaseRelationManager (la memoria di progetto "getFormSchemaOld final" vieta di reintrodurlo), oppure rinominare il metodo nel sottoclasse Ptv. Non e' stato toccato da questo gruppo: il file e' di un altro agente.

## Per file

### FixStructureTest

- Scopo: `bashscripts/utils/fix_structure.sh` deve spostare le cartelle Pascal in `app/` mantenendo il nome, rinominare `Config` in `config`, unire `Config` e `config` lasciando `config_old` (contratto in `bashscripts/fix/fix_structure.md`).
- Causa: lo script era stato spostato da `bashscripts/` a `bashscripts/utils/`, e il test puntava al vecchio path. La versione in `utils/` inoltre lowercasava le cartelle spostate in `app/` (`app/actions`) e non creava `config_old`.
- Decisione: il test punta a `utils/` (canonico, il wrapper in `fix/fix/` lo esegue). Lo script ripristina il contratto documentato. Nessun file cancellato dallo script.
- Esito: verde, 3 test, 11 asserzioni.

### XotBaseResourceTest

- Scopo: il contratto di navigazione di `XotBaseResource` passa da `NavigationLabelTrait` (traduzioni), non da property statiche. La memoria di progetto vieta `$navigationIcon` statica.
- Causa: il fixture dichiarava property statiche che il trait ignora; i valori attesi (`heroicon-o-beaker`, `Sistema`, `59`) sono nel file `lang/it/navigation_probe.php`. `getModuleName()` usava `Str::between`, che per il namespace di test dava `Xot\Tests\Fixtures`.
- Decisione: il fixture perde le property statiche. I test asseriscono i valori del file di lingua. `getModuleName()` ritorna il primo segmento dopo `Modules\` (`Xot`), che coincide con il nome modulo per tutte le risorse reali.
- Esito: verde, 5 test.

### ListRecordsPagesDeclareColumnsTest

- Scopo: ogni pagina di lista concreta deve avere colonne (dichiarate o nella classe `Tables/`).
- Causa: `BaseListIncentivi` e `PtvBaseYearListRecords` sono basi `abstract` mai renderizzate; il test le segnalava.
- Decisione: le classi `abstract` sono escluse dal controllo. Le liste concrete restano controllate.
- Esito: verde, 1 test.

### BaseMorphPivotBusinessLogicTest

- Scopo: il pivot morph di test usa la tabella `test_morph_pivots` (fixture esplicito; la storia `xot-test-harness-truth` lo registra gia').
- Causa: aspettativa stale `test_morph_pivot`. Le date passano per `fromDateTime()` di Eloquent (formato `Y-m-d H:i:s`): la precisione e' al secondo, come la colonna DB.
- Decisione: asserzione corretta sul nome tabella; date generate con `startOfSecond()`.
- Esito: verde, 43 test.

### GetPdfContentByRecordActionTest

- Scopo: l'action genera il nome file e la vista per convenzione; errore esplicito se la vista manca.
- Causa: (a) email `test@example.com` e id `123` fissi collidevano con righe committate nel DB MySQL di test condiviso; (b) il modello anonimo definiva `testGetKey()`, ma l'action chiama `getKey()`; (c) il messaggio d'errore include la classe del modello.
- Decisione: identificatori dalla factory e filename atteso costruito da `getKey()`; `id` impostato con `setAttribute`; messaggio d'errore completo.
- Esito: verde, 8 test, 3 placeholder `markTestSkipped` preesistenti (richiedono mock che non esistono).

### ModuleServiceIntegrationTest

- Scopo: `GetAllModelsByModuleNameAction` restituisce i model di un modulo presente.
- Causa: il modulo `Chart` non esiste nel repo; i test passavano per vuoto o fallivano sul nome.
- Decisione: `Chart` sostituito con `User`, modulo presente con `app/Models`.
- Esito: verde, 20 test.

### XotBaseModelBusinessLogicTest

- Scopo: il base model e' serializzabile, ha i trait e restituisce un array con gli attributi.
- Causa: (a) `class_uses()` non vede i trait ereditati (serve `class_uses_recursive`); (b) PHP non serializza classi anonime; (c) un modello vuoto ha `toArray()` vuoto, comportamento corretto.
- Decisione: fixture nominato `TestConcreteBaseModel`; `class_uses_recursive`; attributo impostato prima di `toArray()`.
- Esito: verde, 21 test. Restano 9 test "risky" (senza asserzioni), preesistenti: da riscrivere in una storia dedicata.

## Verifica

- Esecuzione Pest dei sette file: verde in singola esecuzione prima del blocco (vedi "Stato").
- PHPStan `Modules/Xot`: non eseguita con esito. Il run in background fallisce in boot per il blocco.
- File toccati: `bashscripts/utils/fix_structure.sh`; `Modules/Xot/tests/Feature/{FixStructureTest, Filament/XotBaseResourceTest, ListRecordsPagesDeclareColumnsTest, BaseMorphPivotBusinessLogicTest, Actions/Pdf/GetPdfContentByRecordActionTest, ModuleServiceIntegrationTest, XotBaseModelBusinessLogicTest}.php`; `Modules/Xot/tests/Fixtures/Filament/Resources/NavigationProbeResource.php`; `Modules/Xot/app/Filament/Resources/XotBaseResource.php` (solo `getModuleName()`).

## Prossimi passi

1. Sbloccare il boot (decisione sopra).
2. Rieseguire i sette file e la PHPStan su `Modules/Xot`, poi aggiornare questa story con l'esito.
3. Aprire una storia separata per i 9 test "risky" in `XotBaseModelBusinessLogicTest` e per i 3 placeholder PDF.
