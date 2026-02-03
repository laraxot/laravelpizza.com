<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f3927d7 (.)
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
=======
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> 4f3927d7 (.)
=======
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 66453ace (.)
=======
>>>>>>> 2a97406c (.)
=======
>>>>>>> 4f042b88 (.)
=======
>>>>>>> 36321fcb (.)
=======
>>>>>>> 712617d3 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 2a97406c (.)
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> 36321fcb (.)
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 731b801a8 (.)
=======
=======
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> c31e900eb (.)
=======
=======
>>>>>>> 36ac4fc1 (.)
>>>>>>> fea359347 (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> 4f3927d7 (.)
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)
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

<<<<<<< HEAD
<<<<<<< HEAD
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
=======
>>>>>>> 82ae73be (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> bf5d31b0f (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
<<<<<<< HEAD
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8f2456941 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
<<<<<<< HEAD
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 49639b815 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
<<<<<<< HEAD
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 8e5817bc (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 51182e3c (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 1c0eb9c7 (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 47a873f13 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> 9fe1b60e (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 7a9167faf (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
=======
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 77edd94a (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 6dad70a87 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
<<<<<<< HEAD
=======
>>>>>>> 59916c8f (.)
=======
>>>>>>> f81a620f (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
=======
>>>>>>> 70e8274e (.)
=======
>>>>>>> 2fc60436 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> cbb586cb0 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
<<<<<<< HEAD
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> de02998b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1619767d8 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
<<<<<<< HEAD
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 2f135ef98 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
<<<<<<< HEAD
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 8e5817bc (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 968ed47cd (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
<<<<<<< HEAD
=======
>>>>>>> 7a2f131f (.)
=======
>>>>>>> 51182e3c (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
=======
>>>>>>> 1c0eb9c7 (rebase 210)
=======
>>>>>>> a9bf0423 (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 460b8f5b (rebase 210)
=======
>>>>>>> 4d253d2c (rebase 210)
=======
>>>>>>> 9fe1b60e (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 69f695548 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 8a8a8e2f (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> efb0f8d9 (rebase 210)
=======
>>>>>>> b4f93b3a (rebase 210)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 1375c94d (rebase 210)
=======
>>>>>>> 52cd5f85 (rebase 210)
=======
>>>>>>> c5c038f2 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> db6bec044 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 030c9674 (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> bb00ab64 (rebase 210)
=======
>>>>>>> 77edd94a (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> eea68ec9 (.)
=======
>>>>>>> 59916c8f (.)
=======
>>>>>>> f81a620f (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> ec24613a1 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 06e3078e (.)
<<<<<<< HEAD
=======
>>>>>>> 70e8274e (.)
=======
>>>>>>> 2fc60436 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> ce89c8bb (.)
=======
>>>>>>> 58816034 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> de02998b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 011072e4 (.)
=======
>>>>>>> 161887a2 (.)
=======
>>>>>>> e7a9a2bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f19d70d2 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 9d67cabd (.)
<<<<<<< HEAD
=======
>>>>>>> ba564870 (.)
=======
>>>>>>> 9cdf6146 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 80f054e0 (.)
=======
>>>>>>> 7c39b1fe (.)
=======
>>>>>>> 3f39ac8b (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 4d2eb53e (.)
=======
>>>>>>> 888799d0 (.)
=======
>>>>>>> 6d08c01b (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> be45a0b8d (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 6b6b9e41 (.)
<<<<<<< HEAD
=======
>>>>>>> c6c33175 (.)
=======
>>>>>>> 3b4c9907 (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 5fe4f466 (.)
=======
>>>>>>> 503981fd (.)
=======
>>>>>>> 8e5817bc (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> e0d9c9be (.)
=======
>>>>>>> 7a2f131f (.)
=======
<<<<<<< HEAD
>>>>>>> 10292b60a (.)
=======
>>>>>>> bf5d31b0f (.)
=======
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> 51182e3c (rebase 210)
<<<<<<< HEAD
>>>>>>> 13655a7ed (.)
=======
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> cb85c538 (rebase 210)
>>>>>>> e0836b102 (.)
=======
>>>>>>> 903e3e2cd (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 510809c6f (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> a115e2aad (.)
=======
>>>>>>> 9cb55171f (.)
=======
>>>>>>> 848f79b79 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> c188e2a18 (.)
=======
>>>>>>> cd5474106 (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 763771402 (.)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 207ac35e (.)
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
=======
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 82ae73be (.)
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)
=======
>>>>>>> d284d65 (.)
=======
=======
>>>>>>> 82ae73be (.)
=======
=======
>>>>>>> 4e2ebfb (.)
>>>>>>> 207ac35e (.)
=======
>>>>>>> 9777d1b3 (.)
=======
>>>>>>> f963d2c0 (.)
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
<<<<<<< HEAD
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 75179b85 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 12a7e2462 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> f963d2c0 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d09cb759 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 4689a827 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 66453ace (.)
=======
>>>>>>> 7325acf3 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 2a97406c (.)
=======
>>>>>>> f2e64178 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36136dcfa (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 4f042b88 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> c4bdacbf (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 36321fcb (.)
=======
>>>>>>> dceba960 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 712617d3 (.)
=======
>>>>>>> bd804d67 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 229a065a (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 4fc21b78 (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 9c45d9bd (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9f8e680a (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 5aedc39c (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 8c8937e7 (rebase 210)
=======
>>>>>>> 22baa66d (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 36ac4fc1 (.)
=======
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> d9e649ac3 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> fd1fcc4c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> e790eb33 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 4f3927d7 (.)
=======
>>>>>>> 3ee54c5d (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> c8b1c8bf (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 75179b85 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> ee18dd92 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4689a827 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 66453ace (.)
=======
>>>>>>> 7325acf3 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 2a97406c (.)
=======
>>>>>>> f2e64178 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 4f042b88 (.)
=======
>>>>>>> c4bdacbf (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 36321fcb (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> dceba960 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 712617d3 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> bd804d67 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 229a065a (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 9c45d9bd (rebase 210)
=======
>>>>>>> 9f8e680a (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> eb62d6cf (rebase 210)
=======
>>>>>>> 5aedc39c (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 8c8937e7 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 22baa66d (rebase 210)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
=======
>>>>>>> 2effe245 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> fd1fcc4c (.)
=======
>>>>>>> e790eb33 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 4f3927d7 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 3ee54c5d (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 9cf0dc90 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 75179b85 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 75179b855 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> f963d2c0 (.)
=======
>>>>>>> d09cb759 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> ee18dd92 (.)
=======
>>>>>>> 4689a827 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 66453ace (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 7325acf3 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 2a97406c (.)
<<<<<<< HEAD
=======
>>>>>>> f2e64178 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 4f042b88 (.)
=======
>>>>>>> c4bdacbf (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 36321fcb (.)
=======
>>>>>>> dceba960 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> 712617d3 (.)
=======
>>>>>>> bd804d67 (.)
<<<<<<< HEAD
>>>>>>> laraxot/develop
=======
>>>>>>> 1487fe812 (.)
=======
>>>>>>> 12a7e2462 (.)
=======
=======
>>>>>>> d09cb759 (.)
>>>>>>> 510809c6f (.)
=======
>>>>>>> 4bec160e6 (.)
=======
=======
>>>>>>> 4689a827 (.)
>>>>>>> 8dc1f2ed6 (.)
=======
>>>>>>> 138485550 (.)
=======
=======
>>>>>>> 7325acf3 (.)
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 23f115647 (.)
=======
>>>>>>> 36136dcfa (.)
=======
=======
>>>>>>> c4bdacbf (.)
>>>>>>> a115e2aad (.)
=======
>>>>>>> 70175d0c4 (.)
=======
=======
>>>>>>> dceba960 (.)
>>>>>>> 9cb55171f (.)
=======
>>>>>>> 731b801a8 (.)
=======
=======
>>>>>>> bd804d67 (.)
>>>>>>> 848f79b79 (.)
=======
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> fdb24863 (rebase 210)
<<<<<<< HEAD
>>>>>>> b85076e48 (.)
=======
=======
>>>>>>> 229a065a (rebase 210)
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
>>>>>>> ce1853afd (.)
=======
=======
>>>>>>> 9f8e680a (rebase 210)
>>>>>>> c188e2a18 (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
=======
>>>>>>> 5aedc39c (rebase 210)
>>>>>>> cd5474106 (.)
=======
>>>>>>> c31e900eb (.)
=======
=======
>>>>>>> 22baa66d (rebase 210)
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
>>>>>>> d9e649ac3 (.)
=======
=======
>>>>>>> e790eb33 (.)
>>>>>>> 2dab69c8a (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
=======
>>>>>>> 3ee54c5d (.)
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
- [Documentazione Root](../docs/translation_standards_links.md)
- [Regole Helper Text](../docs/translation-helper-text-standards.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)
>>>>>>> a55aa5e96 (.)
- [Documentazione Root](../project_docs/translation_standards_links.md)
- [Best Practices Filament](../docs/filament_translation_best_practices.md)- [Documentazione Root](../project_docs/translation_standards_links.md)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 1619767d8 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
>>>>>>> 8f2456941 (.)
=======
>>>>>>> 2f135ef98 (.)
=======
>>>>>>> be45a0b8d (.)
=======
>>>>>>> 49639b815 (.)
=======
>>>>>>> 968ed47cd (.)
=======
>>>>>>> e0836b102 (.)
=======
>>>>>>> 47a873f13 (.)
=======
>>>>>>> 69f695548 (.)
=======
>>>>>>> 7a9167faf (.)
=======
>>>>>>> db6bec044 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
>>>>>>> ec24613a1 (.)
=======
>>>>>>> cbb586cb0 (.)
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
=======
>>>>>>> 4e2ebfb (.)
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> b207a9b1a (.)
=======
>>>>>>> 1619767d8 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> d3a8af4d5 (.)
=======
>>>>>>> 4f19d70d2 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> c22b35d1e (.)
=======
>>>>>>> 8f2456941 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> f87b41c3b (.)
=======
>>>>>>> 2f135ef98 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 138fcd4b0 (.)
=======
>>>>>>> be45a0b8d (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> db0bc148f (.)
=======
>>>>>>> 49639b815 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 2641c2944 (.)
=======
>>>>>>> 968ed47cd (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 13655a7ed (.)
=======
>>>>>>> e0836b102 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 903e3e2cd (.)
=======
>>>>>>> 47a873f13 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> a0788fa28 (.)
=======
>>>>>>> 69f695548 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 5d49e093a (.)
=======
>>>>>>> 7a9167faf (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 17f6b8617 (.)
=======
>>>>>>> db6bec044 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> 2e1ac1f20 (.)
=======
>>>>>>> 6dad70a87 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> e95dfc210 (.)
=======
>>>>>>> ec24613a1 (.)
=======
=======
- [Documentazione Root](../project_docs/translation_standards_links.md)
>>>>>>> b19cd40 (.)
>>>>>>> be698cf2c (.)
=======
>>>>>>> cbb586cb0 (.)
- [Regole Helper Text](../project_docs/translation-helper-text-standards.md)
- [Best Practices Filament](../project_docs/filament_translation_best_practices.md)
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b85 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 36321fcb (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 712617d3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
=======
>>>>>>> fdb24863 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 229a065a (rebase 210)
=======
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> eb62d6cf (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
=======
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 26d39e2eb (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fd1fcc4c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
=======
>>>>>>> 4f3927d7 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
=======
>>>>>>> c8b1c8bf (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
<<<<<<< HEAD
=======
>>>>>>> 2a97406c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
=======
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 36321fcb (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
>>>>>>> 712617d3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fdb24863 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 229a065a (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 4fc21b78 (rebase 210)
=======
>>>>>>> 9c45d9bd (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 9f8e680a (rebase 210)
=======
>>>>>>> eb62d6cf (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 5aedc39c (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 8c8937e7 (rebase 210)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 22baa66d (rebase 210)
<<<<<<< HEAD
=======
>>>>>>> 36ac4fc1 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 2effe245 (.)
=======
>>>>>>> fd1fcc4c (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> e790eb33 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f3927d7 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 3ee54c5d (.)
<<<<<<< HEAD
=======
>>>>>>> c8b1c8bf (.)
=======
>>>>>>> 9cf0dc90 (.)
=======
>>>>>>> 75179b85 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> 75179b855 (.)
=======
>>>>>>> f963d2c0 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> d09cb759 (.)
=======
>>>>>>> ee18dd92 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 4689a827 (.)
=======
>>>>>>> 66453ace (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> 7325acf3 (.)
=======
>>>>>>> 2a97406c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 23f115647 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> f2e64178 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 4f042b88 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> c4bdacbf (.)
=======
>>>>>>> 36321fcb (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> dceba960 (.)
=======
>>>>>>> 712617d3 (.)
=======
=======
>>>>>>> d284d65 (.)
>>>>>>> bd804d67 (.)
>>>>>>> laraxot/develop
=======
>>>>>>> 1487fe812 (.)
=======
=======
>>>>>>> f963d2c0 (.)
>>>>>>> 12a7e2462 (.)
=======
>>>>>>> 510809c6f (.)
=======
=======
>>>>>>> ee18dd92 (.)
>>>>>>> 4bec160e6 (.)
=======
>>>>>>> 8dc1f2ed6 (.)
=======
=======
>>>>>>> 66453ace (.)
>>>>>>> 138485550 (.)
=======
>>>>>>> 2e9bd58c3 (.)
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 23f115647 (.)
=======
=======
>>>>>>> 4f042b88 (.)
>>>>>>> 36136dcfa (.)
=======
>>>>>>> a115e2aad (.)
=======
=======
>>>>>>> 36321fcb (.)
>>>>>>> 70175d0c4 (.)
=======
>>>>>>> 9cb55171f (.)
=======
=======
>>>>>>> 712617d3 (.)
>>>>>>> 731b801a8 (.)
=======
>>>>>>> 848f79b79 (.)
=======
=======
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 3e757cee2 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> c188e2a18 (.)
=======
=======
>>>>>>> eb62d6cf (rebase 210)
>>>>>>> 7a142b4f5 (.)
=======
>>>>>>> cd5474106 (.)
=======
=======
>>>>>>> 8c8937e7 (rebase 210)
>>>>>>> c31e900eb (.)
=======
>>>>>>> 01750b107 (.)
=======
>>>>>>> fea359347 (.)
=======
>>>>>>> 26d39e2eb (.)
=======
=======
>>>>>>> fd1fcc4c (.)
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 2dab69c8a (.)
=======
=======
>>>>>>> 4f3927d7 (.)
>>>>>>> 602b8a0a9 (.)
=======
>>>>>>> 763771402 (.)
=======
>>>>>>> 7ceb00286 (.)
=======
=======
>>>>>>> 9cf0dc90 (.)
>>>>>>> 379ffe3f3 (.)
=======
>>>>>>> a55aa5e96 (.)

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

<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
*Ultimo aggiornamento: 2025-01-06* 
=======
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> 998e6866b (.)
=======
>>>>>>> 36136dcfa (.)
*Ultimo aggiornamento: 2025-01-06* 
=======
>>>>>>> 5fd545e4 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 2a97406c (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4f042b88 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 36321fcb (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 712617d3 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 54220b28 (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4fc21b78 (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 9c45d9bd (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> eb62d6cf (rebase 210)
<<<<<<< HEAD
<<<<<<< HEAD
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 8c8937e7 (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 36ac4fc1 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> fd1fcc4c (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4f3927d7 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> c8b1c8bf (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 9cf0dc90 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 75179b85 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> f963d2c0 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> ee18dd92 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 66453ace (.)
=======
>>>>>>> 5fd545e4 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 2a97406c (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4f042b88 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 36321fcb (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 712617d3 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> fdb24863 (rebase 210)
=======
>>>>>>> 54220b28 (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4fc21b78 (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 9c45d9bd (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> eb62d6cf (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 8c8937e7 (rebase 210)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 36ac4fc1 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> fd1fcc4c (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4f3927d7 (.)
<<<<<<< HEAD
<<<<<<< HEAD
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> c8b1c8bf (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 9cf0dc90 (.)
<<<<<<< HEAD
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 75179b85 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> f963d2c0 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 75179b855 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> f963d2c0 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> ee18dd92 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 66453ace (.)
=======
>>>>>>> 5fd545e4 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 2a97406c (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4f042b88 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 36321fcb (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 712617d3 (.)
<<<<<<< HEAD
>>>>>>> laraxot/develop
=======
>>>>>>> 301ad8b44 (.)
=======
>>>>>>> 998e6866b (.)
=======
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 4f042b88 (.)
>>>>>>> 36136dcfa (.)
=======
>>>>>>> 70175d0c4 (.)
=======
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 712617d3 (.)
>>>>>>> 731b801a8 (.)
=======
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> fdb24863 (rebase 210)
>>>>>>> b85076e48 (.)
=======
>>>>>>> 43dd68f4b (.)
=======
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 9c45d9bd (rebase 210)
>>>>>>> ce1853afd (.)
=======
>>>>>>> 7a142b4f5 (.)
=======
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> 8c8937e7 (rebase 210)
>>>>>>> c31e900eb (.)
=======
>>>>>>> fea359347 (.)
=======
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> fd1fcc4c (.)
>>>>>>> d9e649ac3 (.)
=======
>>>>>>> 602b8a0a9 (.)
=======
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> c8b1c8bf (.)
>>>>>>> 7ceb00286 (.)
=======
>>>>>>> 379ffe3f3 (.)
=======
*Ultimo aggiornamento: 2025-01-06* 
>>>>>>> a55aa5e96 (.)
