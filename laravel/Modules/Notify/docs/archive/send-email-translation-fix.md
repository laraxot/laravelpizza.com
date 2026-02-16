# Fix Traduzioni File send_email.php - Modulo Notify

## Problemi Identificati

### 1. Conflitti di Merge Non Risolti
- Presenza di marcatori git  nel file
- Codice duplicato e inconsistente

### 2. Sintassi Obsoleta
- Uso di `array()` invece di sintassi breve `[]`
- Mancanza di `declare(strict_types=1);`

### 3. Struttura Non Espansa
- Campi con struttura semplificata invece di struttura espansa
- Mancanza di `label`, `placeholder`, `help` per alcuni campi

### 4. Campi Mancanti
- Programmazione invio (`scheduled_at`)
- Configurazione mittente (`from_email`, `from_name`)
- Priorità email (`priority`)
- Categoria email (`category`)
- Tracking (`tracking_enabled`)

### 5. Azioni Incomplete
- Messaggi di successo/errore mancanti
- Conferme modali incomplete

### 6. Validazione Incompleta
- Messaggi di validazione specifici mancanti
- Regole di validazione non documentate

## Soluzioni Implementate

### ✅ Struttura Espansa Completa
Ogni campo ora ha la struttura espansa completa:
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Testo di aiuto specifico',
    'description' => 'Descrizione del campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // Vuoto perché diverso da placeholder
],
```

### ✅ Regola Critica: Tooltip e Helper Text
**REGOLA IMPORTANTE**: Ogni campo con `label` e `placeholder` DEVE avere:
- `tooltip`: Informazione aggiuntiva per l'utente
- `helper_text`: Impostato a `''` quando diverso da placeholder

### ✅ Campi Aggiunti
- `sections`: Organizzazione logica dei campi
- `to`, `cc`, `bcc`: Separazione destinatari
- `content`: Contenuto testuale separato da HTML
- `parameters`: Parametri JSON per template
- `priority`: Priorità di invio
- `category`: Categorizzazione email
- `tracking_enabled`: Abilitazione tracking

### ✅ Azioni Migliorate
- Messaggi di successo/errore completi
- Conferme modali con descrizioni dettagliate
- Tooltip per ogni azione

### ✅ Validazione Completa
- Messaggi specifici per ogni regola di validazione
- Validazione per tutti i nuovi campi

## Struttura Finale

### Sezioni Organizzate
1. **Dettagli Email**: Oggetto, template
2. **Destinatari**: To, CC, BCC
3. **Contenuto**: Testo, HTML, parametri
4. **Allegati**: File da allegare
5. **Programmazione**: Invio programmato
6. **Avanzate**: Priorità, categoria, tracking

### Campi Principali
- `subject`: Oggetto email
- `template_id`: Template predefinito
- `to`: Destinatario principale
- `cc`: Copia conoscenza
- `bcc`: Copia nascosta
- `from_email`: Email mittente
- `from_name`: Nome mittente
- `content`: Contenuto testuale
- `body_html`: Contenuto HTML
- `parameters`: Parametri template
- `attachments`: File allegati
- `priority`: Priorità invio
- `scheduled_at`: Programmazione
- `category`: Categoria email
- `tracking_enabled`: Abilita tracking

### Azioni Disponibili
- `send`: Invio immediato
- `preview`: Anteprima email
- `save_draft`: Salva bozza
- `schedule`: Programma invio
- `test_smtp`: Test configurazione

## Conformità Standard

### ✅ Sintassi Moderna
- `declare(strict_types=1);` presente
- Sintassi breve array `[]`
- Tipizzazione corretta

### ✅ Struttura Espansa
- Tutti i campi con struttura completa
- Tooltip e helper_text per ogni campo
- Organizzazione logica in sezioni

### ✅ Completezza
- Tutti i campi necessari presenti
- Azioni complete con messaggi
- Validazione specifica

### ✅ Coerenza
- Naming consistente
- Terminologia uniforme
- Struttura standardizzata

## Collegamenti

- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)

## Note Importanti

### Regola Critica: Tooltip e Helper Text
**OGNI CAMPO** con `label` e `placeholder` deve avere:
```php
'tooltip' => 'Informazione aggiuntiva per l\'utente',
'helper_text' => '', // Vuoto se diverso da placeholder
```

### Struttura Espansa Obbligatoria
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '',
],
```

*Ultimo aggiornamento: 2025-01-06* 