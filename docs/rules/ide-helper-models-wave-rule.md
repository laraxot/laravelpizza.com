# IDE Helper Models Wave Rule

Quando si esegue `cd laravel && php artisan ide-helper:models -W`:

1. aggiornare prima docs, rules, memory e skill del contesto coinvolto;
2. non fidarsi dell'esito in sandbox se i modelli interrogano MySQL locale;
3. se compaiono `Could not analyze class ...` con errori di connessione, rilanciare con accesso reale al DB locale prima di toccare la configurazione;
4. leggere il diff generato nei modelli;
5. rilanciare almeno `./vendor/bin/phpstan analyse Modules --no-progress`.

Regola chiave:

- `ide-helper:models -W` e' sincronizzazione dei PHPDoc, non sostituisce design del modello o fix manuali del dominio.
