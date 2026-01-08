# Esecuzione Corretta di PHPStan in Laraxot <nome progetto>

## Regola Principale

Tutti gli sviluppatori che lavorano su Laraxot <nome progetto> devono utilizzare PHPStan nel modo corretto per garantire la qualità del codice.

## Comando Corretto

```bash
cd /percorso/al/progetto/laravel
./vendor/bin/phpstan analyse [opzioni] [percorso]
```

## Comandi Errati da Evitare

❌ **Errato**:
```bash
# NON usare l'Artisan command
php artisan phpstan:analyse

# NON chiamare direttamente phpstan senza entrare nella cartella laravel
phpstan analyse 

# NON chiamare phpstan dalla directory root del progetto
./laravel/vendor/bin/phpstan analyse
```

✅ **Corretto**:
```bash
# Entrare nella directory laravel
cd /var/www/html/_bases/base_<nome progetto>_fila3/laravel

# Chiamare phpstan con il percorso vendor/bin/
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9
```

## Livelli di Analisi

- **Livello 9**: Standard minimo per il progetto.
- **Livello 10**: Rigidità massima, obiettivo da raggiungere per tutti i moduli.

```bash
# Livello standard 
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9

# Livello avanzato
./vendor/bin/phpstan analyse Modules/NomeModulo --level=10
```

## Workflow Consigliato

1. Sviluppa le nuove funzionalità o correzioni.
2. Esegui PHPStan a livello 9 sul tuo modulo:
   ```bash
   ./vendor/bin/phpstan analyse Modules/MioModulo --level=9
   ```
3. Correggi tutti gli errori segnalati.
4. Se possibile, prova ad eseguire l'analisi a livello 10:
   ```bash
   ./vendor/bin/phpstan analyse Modules/MioModulo --level=10
   ```
5. Committi e invia le modifiche solo se l'analisi a livello 9 passa senza errori.

## Note Importanti

- Il rispetto di questa regola è **obbligatorio** per tutti gli sviluppatori.
- Il codice che non supera PHPStan a livello 9 non deve essere committato.
- Ricorda di configurare correttamente l'autocompletion in IDE come PHPStorm o VS Code per evitare errori comuni.
- Utilizza sempre `declare(strict_types=1);` all'inizio di ogni file PHP.
- Evita l'uso di `mixed` se non strettamente necessario.
- Utilizza sempre le funzioni sicure di `thecodingmachine/safe` per le funzioni native di PHP.

## Risoluzione dei Problemi Comuni

Per una guida dettagliata sulla risoluzione dei problemi comuni segnalati da PHPStan, consulta:

```
laravel/Modules/Xot/docs/PHPSTAN-USAGE-GUIDE.md
laravel/Modules/Xot/docs/PHPSTAN-FIXES-SUMMARY.md
```

## Ignorare Temporaneamente Errori

In rari casi, può essere necessario ignorare temporaneamente un errore. Utilizza:

```php
/** @phpstan-ignore-next-line */
$variabile = funzione_che_causa_errore();
```

**Attenzione**: Ogni utilizzo di `@phpstan-ignore-next-line` deve essere giustificato con un commento che spieghi perché non è possibile correggere l'errore in modo appropriato. 

## Convenzioni per i Moduli

1. Ogni modulo deve avere la propria documentazione nella cartella `docs` del modulo.
2. I modelli devono essere tipizzati correttamente con i loro attributi.
3. Le risorse Filament devono estendere la classe base corretta e implementare tutti i metodi richiesti.
4. Utilizzare sempre le classi di tipo corrette per i filtri e le azioni. 

## Troubleshooting: php-cs-fixer e ENOENT

Se riscontri errori come ENOENT o "php-cs-fixer not found" durante l'uso di strumenti di code style:
- Consulta la sezione troubleshooting in `laravel/Modules/Performance/docs/phpstan.md`.
- Verifica che il binario sia installato e nel PATH.
- Usa la versione locale se disponibile (`./vendor/bin/php-cs-fixer`).

Per dettagli: [php-cs-fixer installation guide](https://cs.symfony.com/#installation) 