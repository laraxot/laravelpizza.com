# Note sulla connessione del modello Chart

Nel modello `Modules/Chart/app/Models/Chart.php` puo' essere presente la riga:

```php
protected $connection = 'sqlite'; // Use sqlite connection for testing
```

Questa impostazione forza l'uso di SQLite per il modello (utile in test).
Attualmente la riga e' commentata per utilizzare la connessione MySQL di default
configurata in `.env` (DB_CONNECTION=mysql).

