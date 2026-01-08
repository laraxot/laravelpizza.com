# Errori comuni nei file di traduzione

## Errori di sintassi

### Parentesi mancanti in array annidati

Un errore comune nei file di traduzione è la mancanza di parentesi chiuse negli array annidati. Questo tipo di errore causa un `ParseError` che blocca l'intera applicazione.

**Esempio di errore**:
```php
'azione_esempio' => 
array (
  'label' => 'Etichetta azione',
'altra_azione' => // Manca la parentesi chiusa e la virgola dell'array precedente
```

**Correzione**:
```php
'azione_esempio' => 
array (
  'label' => 'Etichetta azione',
), // Aggiunta parentesi chiusa e virgola
'altra_azione' =>
```

### Virgole in eccesso o mancanti

Le virgole mancanti tra gli elementi di un array o le virgole in eccesso alla fine dell'ultimo elemento possono causare errori di sintassi.

**Esempio di errore**:
```php
'campo1' => 'valore1'
'campo2' => 'valore2' // Manca la virgola dopo 'valore1'
```

**Correzione**:
```php
'campo1' => 'valore1',
'campo2' => 'valore2'
```

## Pattern e best practices

### Pattern da seguire

1. **Struttura chiara e indentazione coerente**:
   ```php
   'azione' => [
       'label' => 'Etichetta',
       'tooltip' => 'Descrizione tooltip',
   ],
   ```

2. **Utilizzare la sintassi breve degli array** (quando possibile):
   ```php
   'azioni' => [
       'crea' => [
           'label' => 'Crea nuovo',
       ],
   ],
   ```

3. **Aggiungere commenti per blocchi complessi**:
   ```php
   // Azioni per la gestione degli utenti
   'user_actions' => [
       // ...
   ],
   ```

### Anti-pattern da evitare

1. **Evitare stringhe hardcoded per le etichette**:
   ```php
   // NO: Etichetta hardcoded nel codice
   ->label('Crea nuovo')
   
   // SI: Riferimento alla traduzione
   ->label(__('lang_service.actions.create.label'))
   ```

2. **Evitare di mischiare stili di array**:
   ```php
   // NO: Mischiare stili array()
   'azioni' => array(
       'crea' => [
           'label' => 'Crea',
       ],
   ),
   
   // SI: Mantenere lo stesso stile
   'azioni' => array(
       'crea' => array(
           'label' => 'Crea',
       ),
   ),
   ```

3. **Non lasciare etichette non tradotte**:
   ```php
   // NO: Lasciare chiavi non tradotte
   'import_valutatori_' => [
       'label' => 'import_valutatori_',
   ],
   
   // SI: Tradurre tutte le etichette
   'import_valutatori' => [
       'label' => 'Importa valutatori',
   ],
   ```

## Controlli preventivi

Per evitare errori nei file di traduzione:

1. Utilizzare un editor con evidenziazione della sintassi PHP
2. Verificare sempre la corretta chiusura delle parentesi
3. Eseguire una validazione della sintassi PHP prima del commit:
   ```bash
   php -l Modules/Lang/lang/it/lang_service.php
   ```
4. Considerare l'uso di strumenti automatici per la formattazione

## Collegamenti alla documentazione correlata

- [Regole generali per i file di traduzione](/laravel/Modules/Xot/docs/translation_rules.md)
- [Documentazione principale sulle traduzioni](/docs/translation_rules.md)

*Ultimo aggiornamento: 3 Giugno 2025*