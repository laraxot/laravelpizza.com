# Regole Generali del Progetto <nome progetto>

Questo documento contiene le regole generali che devono essere seguite in tutto il progetto <nome progetto> per garantire coerenza e qualità del codice.

## Struttura dei Namespace
- **Modelli**: Utilizzare il namespace `Modules\<nome modulo>\Models` per tutti i modelli.
- **Filament**: Utilizzare il namespace `Modules\<nome modulo>\Filament` per i componenti Filament, anche se si trovano nella directory `app/Filament`.

## Estensione dei Modelli
- I modelli devono estendere classi base personalizzate come `BaseUser` o `XotBaseModel` invece di `Illuminate\Database\Eloquent\Model` quando applicabile.

## Gestione degli Attributi
- L'attributo `$casts` è deprecato e deve essere sostituito con il metodo `casts()`.

## Traduzioni
- Le traduzioni devono essere gestite tramite file di lingua in `Modules/<nome modulo>/lang/<lingua>` e non con `->label()`.

## Struttura dei Moduli
- Ogni modulo ha uno scopo specifico. Gli elementi frontend devono essere nel modulo `Cms`.

## Collegamenti Bidirezionali
- Questo documento è collegato alle documentazioni dei seguenti moduli:
  - [Patient Module Documentation](../../../Patient/project_docs/doctor-model-update.md)
  - [User Module Documentation](../../../User/project_docs/user-model-guidelines.md)

Queste regole devono essere seguite per garantire che il codice passi i controlli di qualità futuri e aderisca ai principi DRY (Don't Repeat Yourself) e KISS (Keep It Simple, Stupid). Considerare sempre le implicazioni di politica, filosofia, religione e zen nelle soluzioni implementate.
