# Migrazioni del Database in <nome progetto>

## Panoramica

Questo documento descrive le best practice per la gestione delle migrazioni del database in <nome progetto>, con particolare attenzione alla struttura delle tabelle e alla mappatura dei campi.

## Principi Fondamentali

1. **Migrazioni Incrementali**: Ogni modifica alla struttura del database deve essere implementata tramite una nuova migrazione
2. **Compatibilità Retroattiva**: Le migrazioni devono mantenere la compatibilità con il codice esistente
3. **Documentazione**: Ogni migrazione deve essere documentata adeguatamente
4. **Test**: Le migrazioni devono essere testate prima di essere applicate in produzione

## Struttura delle Tabelle Principali

### Tabella `users`

La tabella `users` è utilizzata per memorizzare tutti i tipi di utenti (pazienti, dottori, amministratori) tramite il pattern Single Table Inheritance.

```php
Schema::create('users', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('type')->index();
    $table->string('first_name');
    $table->string('last_name');
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->string('address')->nullable();
    $table->string('city')->nullable();
    $table->json('certifications')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

Per una documentazione dettagliata sulla mappatura dei campi, consulta la [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md).

## Tabelle Pivot e Relazioni Many-to-Many

Per la gestione delle relazioni many-to-many tra utenti e team, consultare la documentazione locale del modulo User:

- [Relazione utenti-team: tabella pivot doctor_team](../../laravel/Modules/User/docs/relazioni-utenti-team.mdc)

## Gestione delle Migrazioni

### Creazione di una Nuova Migrazione

Per creare una nuova migrazione, utilizzare il comando Artisan:

```bash
php artisan make:migration nome_migrazione
```

### Aggiunta di Colonne

Per aggiungere una nuova colonna a una tabella esistente:

```php
Schema::table('nome_tabella', function (Blueprint $table) {
    $table->string('nuova_colonna')->nullable();
});
```

### Rimozione di Colonne

Per rimuovere una colonna esistente:

```php
Schema::table('nome_tabella', function (Blueprint $table) {
    $table->dropColumn('colonna_da_rimuovere');
});
```

## Errori Comuni

### 1. Utilizzo di Campi Non Esistenti

Un errore comune è tentare di accedere a campi che non esistono nella tabella. Questo può accadere quando:

- Si utilizza un nome di campo errato
- Si tenta di accedere a un campo che è stato rimosso
- Si tenta di accedere a un campo che non è stato ancora aggiunto

Per evitare questi errori, consultare sempre la [Mappatura dei Campi Database](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md) prima di implementare modifiche.

## Documentazione Correlata

- [Pattern di Ereditarietà dei Modelli](/docs/model-inheritance-patterns.md)
- [Mappatura dei Campi Database nel Modulo Patient](/laravel/Modules/Patient/docs/DATABASE_FIELD_MAPPING.md)
- [Gestione degli Utenti](/docs/user-management.md)
- [Gestione dei File](/docs/file-management.md)
- [Gestione delle Traduzioni](/docs/translation-management.md)

## Regole Specifiche per la Proprietà $connection nelle Migrazioni

- Nelle migrazioni che estendono XotBaseMigration, la proprietà $connection deve essere dichiarata come `protected ?string $connection = 'mysql';` (o altro valore appropriato).
- Non dichiarare mai il tipo come solo `string` o senza type hint.
- Questo garantisce compatibilità con la base Laravel e previene errori fatali in fase di esecuzione delle migration.
