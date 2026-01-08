# Esecuzione Corretta di PHPStan in Laraxot <nome progetto>

## Comando Base per PHPStan

PHPStan deve **sempre** essere eseguito dalla cartella principale dell'applicazione Laravel con il percorso relativo completo:

```bash
cd /var/www/html/_bases/base_<nome progetto>_fila3/laravel
./vendor/bin/phpstan analyse --level=9 --memory-limit=2G Modules/NomeModulo
```

## Percorso Corretto

È fondamentale includere `./` prima di `vendor/bin/phpstan` per garantire che lo script venga eseguito correttamente.

❌ ERRATO:
```bash
phpstan analyse ...
vendor/bin/phpstan analyse ...
```

✅ CORRETTO:
```bash
./vendor/bin/phpstan analyse ...
```

## Opzioni Consigliate

- `--level=9`: Richiesto per conformità alle regole del progetto
- `--memory-limit=2G`: Necessario per moduli complessi
- `--error-format=json`: Utile per processare gli errori automaticamente
- `--no-progress`: Raccomandato per output di log più puliti

## Workflow Consigliato

1. Analizzare un modulo alla volta
2. Categorizzare gli errori (namespace, modelli, relazioni, ecc.)
3. Correggere una categoria di errori alla volta
4. Verificare i progressi eseguendo nuovamente PHPStan
5. Documentare le soluzioni nella cartella docs del modulo

## Esecuzione in Pipeline CI/CD

In ambiente CI/CD, utilizzare:

```bash
cd /var/www/html/_bases/base_<nome progetto>_fila3/laravel
./vendor/bin/phpstan analyse --level=9 --memory-limit=2G --no-progress --error-format=json Modules/NomeModulo > phpstan_results.json
``` 