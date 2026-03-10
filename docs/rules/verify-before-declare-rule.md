# Regola: Verifica Prima di Dichiarare Completato

**Data**: 08-03-2026
**Regola**: CRITICA

## Principo

**MAI dichiarare completato un task senza aver verificato che funzioni correttamente!**

## Perché

1. **Evita falsi positivi**: Dichiarare "fatto" senza verifica porta a problemi nascosti
2. **Rispetta il tempo**: L'utente si fida dei report, non deve rifare il lavoro
3. **Qualità**: Solo test verificati = codice funzionante

## Come Verificare

### Prima di dire "fatto":
1. **Esegui i test**: `cd laravel && ./vendor/bin/pest`
2. **Verifica output**: Controlla che non ci siano errori
3. **Check manuale**: Se possibile, verifica il risultato manualmente
4. **PHPStan**: Esegui l'analisi statica
5. **PHPMD**: Esegui il controllo code smell sul file/perimetro toccato
6. **PHPInsights**: Esegui la quality analysis sul file/perimetro toccato
7. **Test Pest associato**: se hai modificato un file PHP testabile, devi verificare/creare/aggiornare anche il test associato

### Esempio Sbagliato
```
❌ Ho fixato tutto, i test dovrebbero passare
❌ Ho creato il file, dovrebbe funzionare
❌ Ho verificato mentalmente, dovrebbe essere OK
```

### Esempio Corretto
```
✅ Ho eseguito i test, 10 test passati, 0 falliti
✅ Ho verificato con PHPStan, 0 errori
✅ Ho testato manualmente il flusso, funziona
```

## Comandi di Verifica

```bash
# Test
cd laravel && ./vendor/bin/pest --parallel

# Test modulo specifico
cd laravel && ./vendor/bin/pest Modules/[Modulo]/tests

# PHPStan
cd laravel && ./vendor/bin/phpstan analyse

# PHPMD
cd laravel && ./vendor/bin/phpmd path/to/File.php text phpmd.xml

# PHPInsights
cd laravel && ./vendor/bin/phpinsights analyse path/to/File.php --no-interaction

# Syntax check
php -l [file.php]
```

## Violazioni

- Dichiarare "fatto" senza eseguire test
- Non verificare l'output dei test
- Assumere che il codice funzioni senza test
- Non eseguire PHPStan
- Lasciare file PHP con marker di merge (`<<<<<<<`, `=======`, `>>>>>>>`) e dichiarare comunque il task completato
- Non eseguire PHPMD dopo aver toccato un file PHP
- Non eseguire PHPInsights dopo aver toccato un file PHP
- Non valutare il test Pest associato al comportamento cambiato
- Inserire `Log::info(...)` come debug permanente e dichiarare comunque il lavoro pulito

## Note

- LSP errors (come "Undefined function") sono normali in file di test Pest
- Verificare con test reali, non con LSP
