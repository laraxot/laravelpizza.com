---
title: "Guida alla Correzione dei File di Traduzione"
type: guide
tags: [translation, file, correction, guide]
created: 2026-07-14
updated: 2026-07-14
qmd: "translation-file-correction-guide-2 guida alla correzione dei file di traduzione"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-2.md"
  - "./00-index.md"
  - "./absolute-completion.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./acronym-naming-conventions.md"
  - "./action-plan-immediate.md"
status: draft
---

# Guida alla Correzione dei File di Traduzione

## Procedura Sistematica per la Standardizzazione

Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di <nome progetto>.
Questo documento fornisce una procedura dettagliata per correggere sistematicamente i file di traduzione nel modulo Notify che non rispettano gli standard di Quaeris.

## Passo 1: Analisi del File Esistente

Prima di apportare modifiche, analizzare il file esistente per:
1. Verificare il nome del file (rispetta le convenzioni snake_case?)
2. Identificare la struttura attuale (quali sezioni sono presenti?)
3. Identificare i contenuti da preservare (etichette, messaggi, ecc.)

## Passo 2: Correzione di File con Naming Errato

Se il file ha un nome non conforme:

```bash

# 1. Creare un nuovo file con il nome corretto
touch /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/nome_corretto.php
touch /var/www/html/Quaeris/laravel/Modules/Notify/lang/it/nome_corretto.php
touch /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules/Notify/lang/it/nome_corretto.php

# 2. Copiare e correggere il contenuto

# (vedere Passo 3 per la struttura corretta)

# 3. Verificare che non ci siano riferimenti al vecchio file
grep -r "nome_errato" /var/www/html/<nome progetto>/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" /var/www/html/Quaeris/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/Quaeris/laravel/Modules/Notify/lang/it/nome_errato.php
grep -r "nome_errato" /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules/Notify

# 4. Rimuovere il file con naming errato
rm /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules/Notify/lang/it/nome_errato.php
```

## Passo 3: Correzione della Struttura del File

Ogni file deve seguire questa struttura completa:

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
        'plural' => 'Nome Risorse',
    ],
    'navigation' => [
        'name' => 'Nome Menu',
        'plural' => 'Nome Menu Plurale',
        'group' => [
            'name' => 'Gruppo Menu',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'heroicon-o-icon-name',
        'sort' => 10,
    ],
    'fields' => [
        // Campi specifici del file
    ],
    'actions' => [
        // Azioni specifiche del file
    ],
    'messages' => [
        // Messaggi specifici del file
    ],
];
```

## Passo 4: Verifica della Coerenza tra Lingue

Dopo aver corretto un file in italiano, verificare e aggiornare la versione inglese:

```bash

# 1. Controllare se esiste il file inglese
ls /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/en/nome_file.php
ls /var/www/html/Quaeris/laravel/Modules/Notify/lang/en/nome_file.php
ls /var/www/html/_bases/base_techplanner_fila5_mono/laravel/Modules/Notify/lang/en/nome_file.php

# 2. Se esiste, aggiornarlo con la stessa struttura

# 3. Se non esiste, crearlo con la traduzione inglese dei messaggi italiani
```

## Passo 5: Test delle Modifiche

Dopo ogni correzione:

1. Verificare che l'interfaccia utente visualizzi correttamente le etichette
2. Verificare che tutte le traduzioni siano disponibili in tutte le lingue
3. Verificare che non ci siano errori di visualizzazione

## Esempi di Correzione

### Esempio 1: File con Naming Errato

**Originale**: `send_whats_app.php`
**Corretto**: `send_whatsapp.php`

### Esempio 2: File con Struttura Incompleta

**Originale**:
```php
<?php

return [
    'navigation' => [
        'label' => 'Invio SMS',
        'group' => 'Notifiche',
    ],
];
```

**Corretto**:
```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
    ],
    'navigation' => [
        'name' => 'Invio SMS',
        'plural' => 'Invio SMS',
        'group' => [
            'name' => 'Notifiche',
            'description' => 'Gestione dell\'invio di notifiche SMS',
        ],
        'label' => 'Invio SMS',
        'icon' => 'heroicon-o-chat-bubble-left-right',
        'sort' => 15,
    ],
    // Altre sezioni...
];
```

## Lista di Priorità per le Correzioni

1. File con naming errato (urgente)
2. File con struttura completamente mancante (alta priorità)
3. File con struttura parziale (media priorità)
4. Allineamento dei file in inglese (dopo la correzione italiana)

## Riferimenti

- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](./translation-standards-progress.md)
- [Regole di Naming per i File di Traduzione](./translation-file-naming-rules.md)
- [Guida alla Struttura dei File di Traduzione](./translation-file-structure-guide.md)
- [Progresso della Standardizzazione](./translation-standards-progress.md)