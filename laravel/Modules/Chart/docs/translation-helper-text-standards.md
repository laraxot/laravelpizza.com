# Standard per helper_text nelle Traduzioni <nome progetto>

## Regola Critica: Gestione helper_text

### Principio Fondamentale
Quando `helper_text` è uguale alla chiave dell'array, **DEVE** essere impostato a stringa vuota (`''`).

### Motivazione
- **Evitare duplicazione**: Non mostrare lo stesso testo due volte
- **Coerenza UX**: Mantenere interfacce pulite e professionali
- **Best Practice**: Seguire standard di design moderni
- **Localizzazione**: Evitare valori non tradotti nelle interfacce utente

## Pattern di Implementazione

### ✅ CORRETTO
```php
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci il tuo indirizzo',
    'help' => 'Indica l\'indirizzo di residenza o domicilio',
    'description' => 'Indirizzo completo dell\'utente',
    'helper_text' => '', // Vuoto perché diverso da 'address'
],
'phone' => [
    'label' => 'Telefono',
    'placeholder' => 'Inserisci il numero di telefono',
    'help' => 'Numero di telefono per contatti',
    'description' => 'Numero di telefono principale',
    'helper_text' => '', // Vuoto perché diverso da 'phone'
],
'first_name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Il tuo nome anagrafico',
    'description' => 'Nome dell\'utente',
    'helper_text' => '', // Vuoto perché diverso da 'first_name'
],
```

### ❌ ERRATO
```php
'address' => [
    'label' => 'Indirizzo',
    'placeholder' => 'Inserisci il tuo indirizzo',
    'helper_text' => 'address', // ERRORE: uguale alla chiave
],
'phone' => [
    'label' => 'Telefono',
    'helper_text' => 'phone', // ERRORE: uguale alla chiave
],
'first_name' => [
    'label' => 'first_name', // ERRORE: valore non tradotto
    'placeholder' => 'first_name', // ERRORE: valore non tradotto
    'helper_text' => 'first_name', // ERRORE: uguale alla chiave
],
```

## Regole di Applicazione

### 1. Controllo Obbligatorio
- **SE** `helper_text` = chiave dell'array → impostare `helper_text = ''`
- **SE** ci sono `label` e `placeholder` → **DEVE** esserci `helper_text`
- **SE** i valori sono uguali alla chiave → **TRADURRE** in italiano appropriato

### 2. Coerenza Multilingua
- Applicare la stessa logica in tutte le lingue (it, en, de)
- Mantenere struttura identica tra le versioni
- **NON RIMUOVERE** campi esistenti, solo aggiungere o migliorare

### 3. Struttura Completa
Ogni campo deve avere:
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder',
    'help' => 'Testo di aiuto',
    'description' => 'Descrizione',
    'helper_text' => '', // Vuoto se uguale alla chiave
],
```

## Checklist di Validazione

Prima di considerare completo un file di traduzione:

- [ ] Nessun `helper_text` uguale alla chiave dell'array
- [ ] Tutti i campi con `label` e `placeholder` hanno `helper_text`
- [ ] Struttura coerente tra tutte le lingue
- [ ] `helper_text` vuoto (`''`) quando appropriato
- [ ] Testi di aiuto significativi e diversi da label/placeholder
- [ ] Nessun valore non tradotto (chiavi come valori)

## Esempi di Correzione

### Prima (Errato)
```php
'email' => [
    'description' => 'email',
],
'last_name' => [
    'description' => 'last_name',
    'helper_text' => 'last_name',
    'placeholder' => 'last_name',
    'label' => 'last_name',
],
'first_name' => [
    'description' => 'first_name',
    'helper_text' => 'first_name',
    'placeholder' => 'first_name',
    'label' => 'first_name',
],
```

### Dopo (Corretto)
```php
'email' => [
    'label' => 'Email',
    'placeholder' => 'Inserisci l\'indirizzo email',
    'help' => 'L\'email verrà utilizzata per comunicazioni e accesso',
    'description' => 'Indirizzo email associato al profilo',
    'helper_text' => '',
],
'last_name' => [
    'label' => 'Cognome',
    'placeholder' => 'Inserisci il cognome',
    'help' => 'Il tuo cognome anagrafico',
    'description' => 'Cognome dell\'utente',
    'helper_text' => '',
],
'first_name' => [
    'label' => 'Nome',
    'placeholder' => 'Inserisci il nome',
    'help' => 'Il tuo nome anagrafico',
    'description' => 'Nome dell\'utente',
    'helper_text' => '',
],
```

## Applicazione Globale

Questa regola si applica a:
- `Modules/*/lang/*/` - Tutti i moduli
- `Themes/*/lang/*/` - Tutti i temi
- Qualsiasi file di traduzione del progetto <nome progetto>

## Caso Studio: <nome progetto> profile_widget.php

### Problema Identificato (Gennaio 2025)
Il file `Modules/<nome progetto>/lang/it/profile_widget.php` conteneva:
- Sintassi `array()` invece di `[]`
- Mancanza di `declare(strict_types=1)`
- Campi `first_name` e `last_name` con valori non tradotti
- `helper_text` uguali alle chiavi degli array

### Soluzione Applicata
1. **Sintassi**: Convertito da `array()` a `[]`
2. **Strict Types**: Aggiunto `declare(strict_types=1)`
3. **Traduzioni**: Aggiunte traduzioni italiane appropriate per `first_name` e `last_name`
4. **Helper Text**: Impostato a `''` dove uguale alla chiave
5. **Coerenza**: Aggiornati anche i file `en/` e `de/` per mantenere struttura identica

### Risultato
- ✅ Conformità completa agli standard Laraxot
- ✅ Traduzioni semantiche corrette in italiano
- ✅ Struttura espansa completa per tutti i campi
- ✅ Coerenza multilingua mantenuta

## Collegamenti

- [Regole Generali Traduzioni](translation_standards_links.md)
- [Documentazione Modulo Lang](../../laravel/Modules/Lang/docs/)
- [Best Practices Filament](../../laravel/Modules/Xot/docs/filament/)
- [Standard di Qualità <nome progetto>](../../laravel/Modules/<nome progetto>/docs/translation_quality_standards.md)

*Ultimo aggiornamento: Gennaio 2025* 