# Piano di Implementazione per la Standardizzazione delle Traduzioni

Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di <nome progetto>.
Questo documento descrive il piano di implementazione per standardizzare le traduzioni nel modulo Notify di SaluteOra.

## Analisi della Situazione Attuale

Dall'analisi dei file di traduzione esistenti, sono stati identificati i seguenti problemi:

1. **File con Nomi Errati**:
   - `send_s_m_s.php` invece di `send_sms.php`
   - `send_a_w_s_email.php` invece di `send_aws_email.php`
   - `send_whats_app.php` invece di `send_whatsapp.php`
   - `send_netfun_s_m_s.php` invece di `send_netfun_sms.php`

2. **File Senza Nome**:
   - `.php` (file senza nome)

3. **Duplicazione**:
   - In alcuni casi esistono sia le versioni corrette che quelle errate dei file

4. **Inconsistenza tra Lingue**:
   - La cartella "en" contiene solo 3 file, mentre la cartella "it" ne contiene molti di più

5. **Struttura Non Standardizzata**:
   - I file di traduzione non seguono una struttura coerente

## Strategia di Implementazione

### Fase 1: Pulizia dei File Errati

1. **Rimozione dei File Senza Nome**:
   - Rimuovere il file `.php`

2. **Consolidamento dei File Duplicati**:
   - Per ogni coppia di file (es. `send_s_m_s.php` e `send_sms.php`):
     - Verificare che il contenuto del file corretto sia completo
     - Se necessario, integrare il contenuto del file errato nel file corretto
     - Rimuovere il file con nome errato

### Fase 2: Standardizzazione della Struttura

1. **Applicazione del Template Standard**:
   - Assicurarsi che tutti i file seguano la struttura standard definita
   - Aggiungere `declare(strict_types=1);` a tutti i file
   - Organizzare le chiavi in modo gerarchico

2. **Completezza delle Traduzioni**:
   - Assicurarsi che tutte le chiavi necessarie siano presenti in ogni file

### Fase 3: Sincronizzazione tra Lingue

1. **Creazione dei File Mancanti in Inglese**:
   - Per ogni file italiano, creare il corrispondente file inglese se non esiste

2. **Verifica della Coerenza**:
   - Assicurarsi che le stesse chiavi esistano in tutte le lingue

### Fase 4: Documentazione e Monitoraggio

1. **Aggiornamento della Documentazione**:
   - Mantenere aggiornata la documentazione sugli standard di traduzione

2. **Implementazione di Strumenti di Monitoraggio**:
   - Considerare l'implementazione di strumenti per verificare la completezza e coerenza delle traduzioni

## Implementazione Tecnica

### Script di Pulizia

```bash

# Rimozione dei file senza nome
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/<nome progetto>/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/saluteora/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/.php

# Rimozione dei file con nomi errati dopo aver verificato che esistano le versioni corrette
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_s_m_s.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_a_w_s_email.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_whats_app.php
rm -f /var/www/html/_bases/base_techplanner_fila3_mono/laravel/Modules/Notify/lang/it/send_netfun_s_m_s.php
```

### Template Standard per i File di Traduzione

```php
<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Nome Risorsa',
    ],
    'navigation' => [
        'name' => 'Nome nel Menu',
        'plural' => 'Nome Plurale',
        'group' => [
            'name' => 'Nome Gruppo',
            'description' => 'Descrizione del gruppo',
        ],
        'label' => 'Etichetta Menu',
        'icon' => 'icona-risorsa',
        'sort' => 50,
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Placeholder Campo',
            'helper_text' => 'Testo di aiuto',
        ],
    ],
    'actions' => [
        'send' => 'Invia',
        'cancel' => 'Annulla',
    ],
    'messages' => [
        'success' => 'Operazione completata con successo',
        'error' => 'Si è verificato un errore',
    ],
];
```

## Conclusione

L'implementazione di questo piano garantirà che le traduzioni nel modulo Notify seguano gli standard definiti, migliorando la manutenibilità e la coerenza del codice.
