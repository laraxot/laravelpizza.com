# Struttura corretta per i file di traduzione nel modulo Lang

## Percorsi standard per i file di traduzione

I file di traduzione nel modulo Lang devono seguire una struttura precisa dei percorsi per evitare duplicazioni e conflitti:

```
/Modules/Lang/lang/{locale}/{file}.php
```

### Percorsi corretti
- ✅ `/Modules/Lang/lang/it/lang_service.php`
- ✅ `/Modules/Lang/lang/en/lang_service.php`

### Percorsi errati da evitare
- ❌ `/Modules/Lang/lang/lang/it/lang_service.php` (doppia cartella `lang`)
- ❌ `/Modules/Lang/resources/lang/it/lang_service.php` (percorso obsoleto)

## Anti-pattern comuni da evitare

1. **Duplicazione di file di traduzione**
   ```
   /Modules/Lang/lang/it/lang_service.php
   /Modules/Lang/lang/lang/it/lang_service.php  # Duplicato con percorso errato
   ```
   Questo causa conflitti durante il caricamento delle traduzioni e può portare a errori di sintassi difficili da tracciare.

2. **Incongruenze di struttura tra file di traduzione**
   ```php
   // File 1: Sintassi breve
   return [
       'key' => 'value',
   ];
   
   // File 2: Sintassi vecchia
   return array(
       'key' => 'value',
   );
   ```
   Utilizzare sempre la stessa sintassi in tutti i file di traduzione per garantire coerenza.

3. **Cartelle di traduzione duplicate**
   ```
   /Modules/Lang/lang/it/
   /Modules/Lang/resources/lang/it/  # Evitare questa duplicazione
   ```
   Mantenere una sola posizione per le traduzioni di ciascuna lingua.

## Regole di manutenzione

1. **Correggere percorsi duplicati**
   - Identificare file duplicati attraverso script di scansione
   - Rimuovere le copie superflue mantenendo solo quelle nel percorso standard
   - Documentare ogni rimozione per tracciabilità

2. **Unificare file di traduzione frammentati**
   - Se esistono più file parziali per lo stesso contesto, unificarli
   - Seguire la struttura gerarchica standard (navigation, fields, actions, ecc.)

3. **Ripulire la cache dopo modifiche**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

## Verifiche periodiche

1. Eseguire controlli sintattici regolari:
   ```bash
   find Modules/Lang/lang -name "*.php" -exec php -l {} \;
   ```

2. Verificare l'assenza di percorsi duplicati:
   ```bash
   find Modules/Lang -path "*/lang/lang/*" -type f
   ```

## Collegamenti alla documentazione correlata

- [Regole generali per i file di traduzione](/laravel/Modules/Xot/docs/translation_rules.md)
- [Errori comuni nei file di traduzione](/laravel/Modules/Lang/docs/errori_comuni_traduzione.md)
- [Documentazione principale sulle traduzioni](/docs/translation_rules.md)

*Ultimo aggiornamento: 3 Giugno 2025*