# Convenzione di Naming e Gestione delle Migrazioni

## Pattern del Progetto <main module>

Il progetto <main module> adotta un approccio specifico per le migrazioni, diverso dalla convenzione standard di Laravel. Il nostro pattern è:

```
YYYY_MM_DD_HHMMSS_create_oggetto_contesto_table.php
```

Dove:
- `YYYY_MM_DD` è la data della creazione iniziale
- `HHMMSS` è spesso un valore numerico sequenziale (es. `000001`)
- `oggetto_contesto` descrive l'entità e il suo contesto

## Approccio "Un File Per Tabella"

La caratteristica distintiva del nostro approccio è il principio "un file per tabella":

1. **Ogni tabella ha un'unica migrazione**: Non creiamo nuovi file per modifiche incrementali
2. **Modifiche successive nella stessa migrazione**: Quando dobbiamo aggiungere/modificare campi, aggiorniamo il file originale
3. **Versionamento tramite Git**: La storia delle modifiche è tracciata dal sistema di controllo versione

## Vantaggi dell'Approccio

Questo pattern offre numerosi benefici:

1. **Coesione**: Tutte le modifiche a una tabella sono centralizzate in un unico file
2. **Visione complessiva**: È facile vedere la struttura completa di una tabella
3. **Riduzione della frammentazione**: Meno file da gestire e navigare
4. **Manutenibilità migliorata**: Modifiche correlate sono raggruppate logicamente
5. **Identificazione semplificata**: È immediato trovare la migrazione di una tabella specifica

## Implementazione con XotBaseMigration

L'implementazione sfrutta la classe `XotBaseMigration` che supporta questo approccio attraverso:

```php
$this->tableCreate(
    function (Blueprint $table): void {
        // Definizione iniziale della tabella
    }
);

$this->tableUpdate(
    function (Blueprint $table): void {
        // Modifiche incrementali (aggiunta campi, indici, ecc.)
    }
);
```

Questo pattern permette di separare chiaramente la creazione iniziale dalle modifiche successive.

## Esempi dal Progetto

Questa convenzione è applicata in tutto il progetto. Alcuni esempi:

- `2025_05_28_000001_create_addresses_table.php` (Modulo Geo)
- `2025_05_17_000001_create_doctor_team_table.php` (Modulo User)
- `2018_10_10_000002_create_mail_templates_table.php` (Modulo Notify)

## Come Implementare Modifiche

Per aggiungere nuovi campi a una tabella esistente:

1. **Identificare il file di migrazione** originale della tabella
2. **Aggiungere le modifiche** nella sezione `tableUpdate`
3. **Non creare nuovi file** di migrazione per modifiche incrementali

```php
// Esempio di aggiunta di un campo
$this->tableUpdate(
    function (Blueprint $table): void {
        $table->string('nuovo_campo')->nullable()->after('campo_esistente');
    }
);
```

## Riferimenti

- [XotBaseMigration](../../../Xot/database/migrations/XotBaseMigration.php)
- [Documentazione Laravel sulle Migrazioni](https://laravel.com/docs/migrations)
- [Xot Module Documentation Standards](../../../Xot/docs/documentation-standards.md)
