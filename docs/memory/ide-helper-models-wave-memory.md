# IDE Helper Models Wave Memory

- Comando eseguito: `cd laravel && php artisan ide-helper:models -W`
- In sandbox il comando segnalava `Could not analyze class ...` su molti modelli, ma il problema era ambientale: accesso bloccato a MySQL locale (`127.0.0.1:3306`).
- Rilanciato con accesso esteso, il comando ha rigenerato correttamente i PHPDoc dei modelli.
- Verifica finale eseguita: `cd laravel && ./vendor/bin/phpstan analyse Modules --no-progress`
- Esito finale: `OK`, nessun errore PHPStan.

Lezione operativa:

- prima di ignorare modelli in `config/ide-helper.php`, distinguere tra errore del modello e blocco di connessione locale.
