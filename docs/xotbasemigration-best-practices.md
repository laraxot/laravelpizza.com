---
description:
globs:
alwaysApply: false
---
# Best Practice: XotBaseMigration

## Introduzione
Per tutte le migrazioni dei moduli, si utilizza la classe base personalizzata `XotBaseMigration` invece delle classi standard Laravel. Questo garantisce coerenza, estendibilità e compatibilità con le regole del progetto.

## Pattern Consigliati
- **Controllo colonne**: Usare sempre `$this->hasColumn('nome_colonna')` invece di `Schema::hasColumn()`.
- **Controllo tabelle**: Usare `$this->hasTable()` invece di `Schema::hasTable()`.
- **Creazione/aggiornamento**: Usare i metodi helper `tableCreate()` e `tableUpdate()`.
- **Mai usare direttamente Schema::**

## Esempio Corretto
```php
if (! $this->hasColumn('state')) {
    $this->tableUpdate(function (Blueprint $table) {
        $table->string('state', 32)->nullable();
    });
}
```

## Esempio Sbagliato
```php
if (!Schema::hasColumn('users', 'state')) {
    Schema::table('users', function (Blueprint $table) {
        $table->string('state', 32)->nullable();
    });
}
```

## Motivazione
- Garantisce compatibilità con le estensioni e override di XotBaseMigration
- Permette logging, rollback e gestione avanzata
- Evita errori di namespace e comportamenti incoerenti

## Errori Comuni da Evitare
- Usare Schema::hasColumn invece di $this->hasColumn
- Usare Schema::table invece di $this->tableUpdate
- Non usare i metodi helper di XotBaseMigration

## Note per Cursor e Windsurf
- Queste regole devono essere documentate sia in `.cursor/rules/` che in `.windsurf/rules/`.
- Aggiornare la documentazione ogni volta che si introduce una nuova convenzione o helper in XotBaseMigration.

## Collegamenti correlati
- [Migrazioni del Database](mdc:../../../docs/database-migrations.md)
- [Moderazione e Wizard Generici](mdc:MODERATION_WIZARD_GENERIC.mdc)
- [Contratti e Interfacce Moderazione](mdc:MODERATION_CONTRACTS.mdc)
- [Configurazione Stati Utente](mdc:USER_STATES.mdc)
- [Best Practice: ActivityLog per la Moderazione Utenti](mdc:ACTIVITYLOG_MODERATION_BEST_PRACTICES.mdc)
