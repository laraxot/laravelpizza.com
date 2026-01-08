# Regole per i file di traduzione in Laraxot PTVX

## Panoramica

Questo documento fornisce una panoramica delle regole per i file di traduzione in Laraxot PTVX e collegamenti alla documentazione dettagliata nei vari moduli. Per le regole specifiche e dettagliate, consultare la documentazione nei moduli Xot e Lang.

## Regole fondamentali

1. **Percorsi standard**: I file di traduzione devono essere posizionati esclusivamente nei seguenti percorsi:
   ```
   /Modules/<NomeModulo>/lang/<lingua>/<file>.php
   ```

2. **Sintassi moderna**: Utilizzare sempre la sintassi breve degli array (`[]`) invece della sintassi vecchia (`array()`)

3. **Struttura gerarchica**: Seguire la struttura gerarchica standard per i file di traduzione (navigation, fields, actions, validation, messages)

4. **Etichette tradotte**: Tutte le etichette devono essere effettivamente tradotte, non semplicemente ripetere la chiave

## Anti-pattern da evitare

1. **File duplicati**: Evitare file di traduzione duplicati in percorsi diversi
2. **Percorsi non standard**: Non utilizzare percorsi non standard come `resources/lang` o `lang/lang`
3. **Sintassi mista**: Non mischiare sintassi diverse (`[]` e `array()`) nei file di traduzione
4. **Traduzioni incomplete**: Non lasciare chiavi non tradotte o incomplete

## Manutenzione e verifiche

Per verificare e correggere problemi nei file di traduzione, utilizzare lo script:
```bash
/var/www/html/ptvx/bashscripts/check_duplicate_translations.sh
```

Dopo ogni modifica ai file di traduzione, pulire la cache:
```bash
cd /var/www/html/ptvx/laravel && php artisan cache:clear && php artisan config:clear && php artisan view:clear
```

## Collegamenti alla documentazione dettagliata

- [Regole generali per i file di traduzione](/laravel/Modules/Xot/docs/translation-rules.md)
- [Struttura delle traduzioni nel modulo Lang](/laravel/Modules/Lang/docs/struttura_traduzioni.md)
- [Errori comuni nei file di traduzione](/laravel/Modules/Lang/docs/errori_comuni_traduzione.md)
- [Percorsi standard per i file di traduzione](/.cursor/rules/translation_paths_rules.mdc)

## Note su errori comuni

Un errore comune è la duplicazione di percorsi (`lang/lang/it/` invece di `lang/it/`), che può portare a errori di sintassi difficili da tracciare. 

Un altro errore frequente è l'utilizzo della sintassi vecchia degli array (`array()`) invece della sintassi breve (`[]`), che è più leggibile e meno soggetta a errori.

*Ultimo aggiornamento: 3 Giugno 2025*