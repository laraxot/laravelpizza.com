# Setup del Progetto Laravel

Questo documento contiene la documentazione dettagliata dei comandi utilizzati per il setup di un progetto Laravel, insieme a spiegazioni, consigli e note per migliorare il processo.

## Requisiti di Sistema

### Hardware Minimi
- CPU: 2 core
- RAM: 4GB
- Storage: 20GB SSD
- Network: 100Mbps

### Software Richiesti
- Ubuntu 22.04 LTS o superiore
- PHP 8.2 o superiore
- MySQL 8.0 o superiore
- Apache 2.4 o superiore
- Node.js 18.x o superiore
- Composer 2.x

### Verifica Requisiti
```bash

# Verifica versione PHP
php -v

# Verifica versione MySQL
mysql --version

# Verifica versione Apache
apache2 -v

# Verifica versione Node.js
node -v

# Verifica versione Composer
composer --version
```

## Struttura del Documento

- [Comandi Base](#comandi-base)
- [Configurazione Ambiente](#configurazione-ambiente)
- [Installazione Dipendenze](#installazione-dipendenze)
- [Configurazione Database](#configurazione-database)
- [Note e Consigli](#note-e-consigli)

## Comandi Base

### Installazione Tasksel
```bash
sudo apt install tasksel
```

**Spiegazione:**
- `tasksel` è un tool che permette di installare gruppi di pacchetti predefiniti su sistemi Debian/Ubuntu
- Utile per installare rapidamente ambienti di sviluppo completi
- Richiede privilegi di root (sudo)

**Note:**
- Verificare che il sistema sia aggiornato prima dell'installazione
- Consigliato per sistemi Debian/Ubuntu
- Può essere utilizzato per installare LAMP, LEMP o altri stack di sviluppo

## Configurazione Ambiente

### Aggiunta Repository PHP
```bash
sudo add-apt-repository ppa:ondrej/php
```

**Spiegazione:**
- Aggiunge il repository PPA di Ondřej Surý, che contiene le versioni più recenti e stabili di PHP
- Permette di installare versioni specifiche di PHP (7.4, 8.0, 8.1, 8.2, 8.3)
- Fornisce anche estensioni PHP e pacchetti correlati

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'aggiunta del repository, è necessario aggiornare la lista dei pacchetti con `sudo apt update`
- Questo repository è considerato uno dei più affidabili per PHP su Ubuntu
- Consigliato per progetti che necessitano di versioni specifiche di PHP

### Configurazione File .env
```bash

# Naviga nella directory del progetto
cd laravel

# Copia il file .env.latest in .env
cp .env.latest .env

# Genera una nuova APP_KEY
php artisan key:generate
```

**Spiegazione:**
- Configura l'ambiente di sviluppo Laravel
- `cp .env.latest .env`: Copia il file di configurazione template in .env
- `php artisan key:generate`: Genera una nuova chiave di applicazione sicura

**Funzionalità:**
- Configurazione base dell'ambiente
- Generazione chiave di crittografia
- Impostazione variabili d'ambiente
- Preparazione per lo sviluppo

**Note:**
- Assicurarsi di essere nella directory corretta del progetto
- Verificare che il file .env.latest esista
- Dopo la generazione della chiave, verificare che sia stata aggiunta al file .env
- Se necessario, configurare manualmente altre variabili d'ambiente:
  ```ini

  APP_NAME=<nome progetto>

  APP_NAME=il progetto
 80ec88ee9 (.)

  APP_ENV=local
  APP_DEBUG=true
  APP_URL=http://localhost
  ```
- In caso di problemi, verificare i permessi del file .env:
  ```bash
  chmod 644 .env
  ```

## Installazione Dipendenze

### Installazione Stack LAMP
```bash
sudo apt install lamp-server^
```

**Spiegazione:**
- Installa il completo stack LAMP (Linux, Apache, MySQL, PHP)
- Il simbolo `^` alla fine indica che si tratta di un task completo
- Installa automaticamente tutte le dipendenze necessarie

**Componenti Installati:**
- Apache2 (web server)
- MySQL (database server)
- PHP (linguaggio di programmazione)
- Moduli PHP essenziali
- Configurazioni base

**Note:**
- Richiede privilegi di root (sudo)
- Durante l'installazione verrà richiesta la password per MySQL
- Consigliato eseguire `sudo apt update` prima dell'installazione
- Verificare che tutti i servizi siano attivi dopo l'installazione:
  ```bash
  sudo systemctl status apache2
  sudo systemctl status mysql
  ```

### Installazione Strumenti di Sviluppo
```bash
sudo apt install git npm aptitude
```

**Spiegazione:**
- Installa tre strumenti essenziali per lo sviluppo:
  1. `git`: Sistema di controllo versione distribuito
  2. `npm`: Gestore di pacchetti per Node.js
  3. `aptitude`: Interfaccia avanzata per la gestione dei pacchetti

**Componenti Installati:**
- **Git:**
  - Sistema di controllo versione
  - Gestione del codice sorgente
  - Collaborazione in team
- **NPM:**
  - Gestione delle dipendenze JavaScript
  - Installazione di pacchetti Node.js
  - Esecuzione di script
- **Aptitude:**
  - Gestione avanzata dei pacchetti
  - Interfaccia interattiva
  - Risoluzione automatica delle dipendenze

**Note:**
- Richiede privilegi di root (sudo)
- Consigliato eseguire `sudo apt update` prima dell'installazione
- Dopo l'installazione di npm, è consigliabile aggiornarlo:
  ```bash
  sudo npm install -g npm@latest
  ```
- Per Git, configurare l'utente:
  ```bash
  git config --global user.name "Nome Utente"
  git config --global user.email "email@example.com"
  ```

### Installazione Estensioni PHP
```bash
sudo apt-get install -y php libapache2-mod-php php8.*-{cli,bcmath,bz2,intl,gd,mbstring,mysql,zip,common,curl,xml,imap,pdo-sqlite,sqlite3,dom} php-{json,xml,zip,common,tokenizer,mysql,sqlite3} libapache2-mod-php8*
```

**Spiegazione:**
- Installa PHP e tutte le estensioni necessarie per lo sviluppo
- Il flag `-y` risponde automaticamente "sì" alle domande durante l'installazione
- Installa sia le estensioni PHP 8.x che i moduli Apache necessari

**Componenti Installati:**
- **Estensioni Base:**
  - php-cli: Interfaccia a riga di comando
  - php-bcmath: Calcoli matematici di precisione
  - php-bz2: Compressione Bzip2
  - php-intl: Internazionalizzazione
  - php-gd: Manipolazione immagini
  - php-mbstring: Gestione stringhe multibyte
  - php-mysql: Supporto MySQL
  - php-zip: Gestione archivi ZIP
  - php-common: Funzionalità comuni
  - php-curl: Client URL
  - php-xml: Elaborazione XML
  - php-imap: Accesso IMAP
  - php-pdo-sqlite: Supporto SQLite via PDO
  - php-sqlite3: Supporto SQLite3
  - php-dom: DOM XML
  - php-json: Elaborazione JSON
  - php-tokenizer: Tokenizzazione PHP

**Note:**
- Richiede privilegi di root (sudo)
- Consigliato eseguire `sudo apt update` prima dell'installazione
- Dopo l'installazione, riavviare Apache:
  ```bash
  sudo systemctl restart apache2
  ```
- Verificare l'installazione delle estensioni:
  ```bash
  php -m
  ```

### Installazione OPcache
```bash
sudo apt install opcache
```

**Spiegazione:**
- Installa l'estensione OPcache per PHP
- OPcache è un acceleratore di codice PHP che migliora significativamente le performance
- Memorizza il bytecode precompilato in memoria, evitando la ricompilazione ad ogni richiesta

**Funzionalità:**
- Cache del bytecode PHP
- Ottimizzazione automatica del codice
- Riduzione del consumo di CPU
- Miglioramento delle performance generali

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, configurare OPcache in `php.ini`:
  ```ini
  opcache.enable=1
  opcache.memory_consumption=128
  opcache.interned_strings_buffer=8
  opcache.max_accelerated_files=4000
  opcache.revalidate_freq=60
  opcache.fast_shutdown=1
  opcache.enable_cli=1
  ```
- Riavviare PHP-FPM o Apache dopo la configurazione:
  ```bash
  sudo systemctl restart apache2
  # o
  sudo systemctl restart php-fpm
  ```
- Verificare l'attivazione:
  ```bash
  php -i | grep opcache
  ```

### Installazione Zsh
```bash
sudo apt-get install zsh
```

**Spiegazione:**
- Installa Zsh (Z Shell), una shell avanzata e potente
- Offre funzionalità superiori rispetto alla bash standard
- Supporta completamento automatico avanzato e temi personalizzabili

**Funzionalità:**
- Completamento automatico intelligente
- Gestione avanzata della cronologia
- Supporto per plugin e temi
- Sintassi migliorata
- Migliore gestione delle directory

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, configurare Zsh come shell predefinita:
  ```bash
  chsh -s $(which zsh)
  ```
- Installare Oh My Zsh per una configurazione ottimale:
  ```bash
  sh -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
  ```
- Configurare il tema e i plugin preferiti in `~/.zshrc`
- Riavviare la shell per applicare le modifiche:
  ```bash
  exec zsh
  ```

### Installazione Oh My Zsh
```bash
sh -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"
```

**Spiegazione:**
- Installa Oh My Zsh, un framework open source per la gestione della configurazione di Zsh
- Fornisce una vasta collezione di plugin e temi
- Migliora significativamente l'esperienza d'uso di Zsh

**Funzionalità:**
- Gestione centralizzata dei plugin
- Temi personalizzabili
- Completamento automatico avanzato
- Alias utili predefiniti
- Integrazione con Git

**Note:**
- Richiede Zsh già installato
- Durante l'installazione verrà creato un backup del file `.zshrc` esistente
- Dopo l'installazione, configurare il tema preferito in `~/.zshrc`:
  ```bash
  ZSH_THEME="nome-tema"
  ```
- Aggiungere plugin desiderati:
  ```bash
  plugins=(git docker composer npm)
  ```
- Riavviare la shell per applicare le modifiche:
  ```bash
  exec zsh
  ```

### Installazione Tema Powerlevel10k
```bash
git clone https://github.com/romkatv/powerlevel10k.git $ZSH_CUSTOM/themes/powerlevel10k
```

**Spiegazione:**
- Installa Powerlevel10k, un tema avanzato e altamente personalizzabile per Oh My Zsh
- Offre un'interfaccia utente moderna e informativa
- Supporta configurazione interattiva

**Funzionalità:**
- Prompt personalizzabile
- Indicatori di stato in tempo reale
- Supporto per emoji e icone
- Configurazione guidata
- Performance ottimizzata

**Note:**
- Richiede Oh My Zsh già installato
- Dopo l'installazione, configurare il tema in `~/.zshrc`:
  ```bash
  ZSH_THEME="powerlevel10k/powerlevel10k"
  ```
- Eseguire la configurazione interattiva:
  ```bash
  p10k configure
  ```
- Personalizzare ulteriormente il tema modificando `~/.p10k.zsh`
- Riavviare la shell per applicare le modifiche:
  ```bash
  exec zsh
  ```

### Configurazione Tema Powerlevel10k
```bash

# Modifica il file ~/.zshrc
ZSH_THEME="powerlevel10k/powerlevel10k"
```

**Spiegazione:**
- Configura Oh My Zsh per utilizzare il tema Powerlevel10k
- Il tema viene caricato dal percorso specificato
- La configurazione viene applicata al riavvio della shell

**Note:**
- Il file `.zshrc` deve essere modificato con un editor di testo
- Dopo la modifica, salvare il file
- Riavviare la shell per applicare le modifiche:
  ```bash
  exec zsh
  ```
- Se non si vede il nuovo tema, verificare che:
  1. Il tema sia stato installato correttamente
  2. Il percorso nel file `.zshrc` sia corretto
  3. Non ci siano errori di sintassi nel file

### Ricaricamento Configurazione Zsh
```bash
source ~/.zshrc
```

**Spiegazione:**
- Ricarica la configurazione di Zsh senza dover riavviare la shell
- Applica immediatamente le modifiche al file `.zshrc`
- Utile dopo aver modificato la configurazione

**Note:**
- Alternativa al comando `exec zsh`
- Non richiede privilegi di root
- Se il comando non funziona, verificare che:
  1. Il file `.zshrc` sia stato salvato correttamente
  2. Non ci siano errori di sintassi nel file
  3. I percorsi dei plugin e dei temi siano corretti
- In caso di problemi, provare a riavviare la shell:
  ```bash
  exec zsh
  ```

### Installazione dos2unix e PHP8-Memcache
```bash
sudo apt install dos2unix php8"*"memcache
```

**Spiegazione:**
- Installa due componenti essenziali:
  1. `dos2unix`: Strumento per la conversione dei file di testo
  2. `php8-memcache`: Estensione PHP 8 per la gestione della cache in memoria

**Componenti Installati:**
- **dos2unix:**
  - Converte i file di testo da formato DOS/Windows a Unix
  - Risolve problemi di fine riga (CRLF vs LF)
  - Utile per la compatibilità cross-platform
  - Supporta conversioni batch

- **PHP8-Memcache:**
  - Estensione PHP 8 per la gestione della cache in memoria
  - Migliora le performance delle applicazioni
  - Riduce il carico sul database
  - Supporta la memorizzazione di dati complessi
  - Compatibile con PHP 8.x

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione di memcache, configurare PHP:
  ```ini
  extension=memcache.so
  ```
- Configurare il server memcached in `/etc/memcached.conf`:
  ```ini
  -m 64        # memoria in MB
  -p 11211     # porta
  -u memcache  # utente
  -l 127.0.0.1 # interfaccia
  ```
- Riavviare i servizi:
  ```bash
  sudo systemctl restart memcached
  sudo systemctl restart apache2
  ```
- Verificare l'installazione:
  ```bash
  php -m | grep memcache
  ```

### Installazione Webmin e Usermin
```bash
sudo apt-get install --install-recommends webmin usermin
```

**Spiegazione:**
- Installa Webmin e Usermin con tutte le dipendenze raccomandate
- Webmin: interfaccia web per l'amministrazione del sistema
- Usermin: interfaccia web per la gestione degli utenti

**Componenti Installati:**
- **Webmin:**
  - Interfaccia web per l'amministrazione del sistema
  - Gestione centralizzata dei servizi
  - Configurazione semplificata
  - Monitoraggio del sistema

- **Usermin:**
  - Interfaccia web per gli utenti
  - Gestione email e file
  - Configurazione personale
  - Accesso limitato alle funzionalità

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, accedere a:
  - Webmin: `https://localhost:10000`
  - Usermin: `https://localhost:20000`
- Configurare il firewall per permettere l'accesso:
  ```bash
  sudo ufw allow 10000/tcp  # Webmin
  sudo ufw allow 20000/tcp  # Usermin
  ```
- Verificare lo stato dei servizi:
  ```bash
  sudo systemctl status webmin
  sudo systemctl status usermin
  ```
- In caso di problemi, verificare i log:
  ```bash
  sudo tail -f /var/log/webmin/miniserv.log
  sudo tail -f /var/log/usermin/miniserv.log
  ```

### Aggiornamento Composer e Dipendenze
```bash

# Naviga nella directory del progetto
cd laravel

# Aggiorna Composer alla versione più recente
php -d memory_limit=-1 composer.phar selfupdate

# Aggiorna tutte le dipendenze del progetto
php -d memory_limit=-1 composer.phar update
```

**Spiegazione:**
- Aggiorna Composer e le dipendenze del progetto Laravel
- Il flag `-d memory_limit=-1` rimuove il limite di memoria per PHP
- `composer.phar` è l'eseguibile di Composer

**Funzionalità:**
- Aggiornamento di Composer alla versione più recente
- Aggiornamento di tutte le dipendenze del progetto
- Risoluzione automatica delle dipendenze
- Generazione dell'autoloader ottimizzato

**Note:**
- Eseguire i comandi nella directory del progetto Laravel
- In caso di problemi di memoria, utilizzare il flag `-d memory_limit=-1`
- Dopo l'aggiornamento, verificare che tutto funzioni correttamente:
  ```bash
  php artisan serve
  ```
- Se necessario, ripristinare la versione precedente di Composer:
  ```bash
  php -d memory_limit=-1 composer.phar self-update --rollback
  ```
- Verificare la versione di Composer:
  ```bash
  php -d memory_limit=-1 composer.phar --version
  ```

### Aggiornamento Completo Dipendenze
```bash
php -d memory_limit=-1 composer.phar update -W
```

**Spiegazione:**
- Aggiorna tutte le dipendenze del progetto, incluse quelle root
- Il flag `-W` forza l'aggiornamento anche delle dipendenze root
- Il flag `-d memory_limit=-1` rimuove il limite di memoria per PHP
- `composer.phar` è l'eseguibile di Composer

**Funzionalità:**
- Aggiornamento completo di tutte le dipendenze
- Aggiornamento forzato delle dipendenze root
- Risoluzione automatica delle dipendenze
- Generazione dell'autoloader ottimizzato

**Note:**
- Eseguire il comando nella directory del progetto Laravel
- In caso di problemi di memoria, utilizzare il flag `-d memory_limit=-1`
- Dopo l'aggiornamento, verificare che tutto funzioni correttamente:
  ```bash
  php artisan serve
  ```
- Se necessario, ripristinare la versione precedente:
  ```bash
  php -d memory_limit=-1 composer.phar update --lock
  ```
- Verificare lo stato delle dipendenze:
  ```bash
  php -d memory_limit=-1 composer.phar show
  ```

### Installazione PHP Memcache
```bash
sudo apt install php8"*"-memcache"*"
```

**Spiegazione:**
- Installa l'estensione Memcache per PHP 8.x
- Il pattern `"*"` installa l'estensione per tutte le versioni di PHP 8 disponibili
- Memcache è un sistema di caching in memoria che migliora le performance

**Funzionalità:**
- Cache in memoria per dati e oggetti
- Riduzione del carico sul database
- Miglioramento delle performance
- Supporto per strutture dati complesse

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, configurare PHP:
  ```ini
  extension=memcache.so
  ```
- Configurare il server memcached in `/etc/memcached.conf`:
  ```ini
  -m 64        # memoria in MB
  -p 11211     # porta
  -u memcache  # utente
  -l 127.0.0.1 # interfaccia
  ```
- Riavviare i servizi:
  ```bash
  sudo systemctl restart memcached
  sudo systemctl restart apache2
  ```
- Verificare l'installazione:
  ```bash
  php -m | grep memcache
  ```

### Installazione PHP APCu
```bash
sudo apt-get install -y php-apcu
```

**Spiegazione:**
- Installa l'estensione APCu (Alternative PHP Cache User Cache) per PHP
- Il flag `-y` risponde automaticamente "sì" alle domande durante l'installazione
- APCu è un sistema di caching in memoria per dati utente
- Migliora le performance delle applicazioni PHP

**Funzionalità:**
- Cache in memoria per dati utente
- Supporto per strutture dati complesse
- API semplice e intuitiva
- Compatibilità con APC
- Miglioramento delle performance

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, configurare PHP:
  ```ini
  extension=apcu.so
  apc.enabled=1
  apc.shm_size=128M
  apc.ttl=7200
  apc.user_ttl=7200
  apc.gc_ttl=3600
  apc.stat=1
  ```
- Riavviare i servizi:
  ```bash
  sudo systemctl restart apache2
  # o
  sudo systemctl restart php-fpm
  ```
- Verificare l'installazione:
  ```bash
  php -m | grep apcu
  ```
- In caso di problemi, verificare i log:
  ```bash
  tail -f /var/log/php/error.log
  ```

### Installazione PEAR e Dipendenze di Sviluppo
```bash
sudo apt install php-pear php-dev build-essential
```

**Spiegazione:**
- Installa tre componenti essenziali per lo sviluppo PHP:
  1. `php-pear`: PHP Extension and Application Repository
  2. `php-dev`: File di sviluppo PHP necessari per compilare estensioni
  3. `build-essential`: Pacchetti essenziali per la compilazione di software

**Componenti Installati:**
- **PEAR:**
  - Sistema di gestione pacchetti per PHP
  - Installazione di estensioni PHP
  - Gestione delle dipendenze
  - Repository di pacchetti PHP

- **PHP Dev:**
  - File header per lo sviluppo
  - Librerie di sviluppo
  - Strumenti per la compilazione
  - Supporto per estensioni PHP

- **Build Essential:**
  - Compilatore GCC
  - Librerie di sviluppo C
  - Make e altri strumenti di build
  - Dipendenze per la compilazione

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, verificare PEAR:
  ```bash
  pear version
  ```
- Verificare le estensioni PHP installate:
  ```bash
  php -m
  ```
- Se necessario, aggiornare PEAR:
  ```bash
  sudo pear upgrade
  ```
- In caso di problemi, verificare i log:
  ```bash
  tail -f /var/log/php/error.log
  ```

### Installazione Redis e Dipendenze
```bash
sudo apt install redis redis-server gcc make autoconf libc-dev pkg-config php-pecl-http php8.*-redis
```

**Spiegazione:**
- Installa Redis e tutte le dipendenze necessarie per il suo funzionamento con PHP
- Include il server Redis, le estensioni PHP e gli strumenti di compilazione

**Componenti Installati:**
- **Redis:**
  - Server Redis
  - Client Redis
  - Strumenti di gestione

- **Dipendenze di Sistema:**
  - gcc: Compilatore C
  - make: Strumento di build
  - autoconf: Generatore di script di configurazione
  - libc-dev: Librerie di sviluppo C
  - pkg-config: Gestione delle dipendenze

- **Estensioni PHP:**
  - php-pecl-http: Estensione HTTP per PHP
  - php8.*-redis: Estensione Redis per PHP 8.x

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, configurare Redis:
  ```ini
  # /etc/redis/redis.conf
  maxmemory 256mb
  maxmemory-policy allkeys-lru
  ```
- Abilitare e avviare il servizio Redis:
  ```bash
  sudo systemctl enable redis-server
  sudo systemctl start redis-server
  ```
- Verificare l'installazione delle estensioni PHP:
  ```bash
  php -m | grep redis
  ```
- Configurare PHP per utilizzare Redis:
  ```ini
  extension=redis.so
  ```
- In caso di problemi, verificare i log:
  ```bash
  sudo tail -f /var/log/redis/redis-server.log
  ```

### Installazione Redis via PECL
```bash
sudo pecl install redis
```

**Spiegazione:**
- Installa l'estensione Redis per PHP tramite PECL (PHP Extension Community Library)
- PECL è il repository ufficiale per le estensioni PHP
- Fornisce l'ultima versione stabile dell'estensione Redis

**Funzionalità:**
- Supporto completo per Redis
- API PHP per l'interazione con Redis
- Gestione delle connessioni
- Supporto per tutti i tipi di dati Redis
- Transazioni e pipeline

**Note:**
- Richiede privilegi di root (sudo)
- Dopo l'installazione, configurare PHP:
  ```ini
  extension=redis.so
  ```
- Verificare l'installazione:
  ```bash
  php -m | grep redis
  ```
- Se necessario, aggiornare l'estensione:
  ```bash
  sudo pecl upgrade redis
  ```
- In caso di problemi, verificare i log:
  ```bash
  tail -f /var/log/php/error.log
  ```
- Per rimuovere l'estensione:
  ```bash
  sudo pecl uninstall redis
  ```

## Configurazione Database

### Creazione Database SQLite
```bash

# Crea il file database.sqlite nella directory database
touch laravel/database/database.sqlite
```

**Spiegazione:**
- Crea un file database SQLite vuoto per lo sviluppo locale
- Il file viene creato nella directory `database` del progetto Laravel
- SQLite è un database leggero e file-based, ideale per sviluppo e testing

**Funzionalità:**
- Database leggero e portabile
- Nessuna configurazione server richiesta
- Facile da usare per sviluppo locale
- Supporto completo per le funzionalità di Laravel

**Note:**
- Assicurarsi che la directory `database` abbia i permessi corretti:
  ```bash
  sudo chmod -R 775 laravel/database
  ```
- Configurare il file `.env` per utilizzare SQLite:
  ```ini
  DB_CONNECTION=sqlite
  DB_DATABASE=/absolute/path/to/database.sqlite
  ```
- Eseguire le migrazioni dopo la creazione:
  ```bash
  php artisan migrate
  ```
- In caso di problemi di permessi:
  ```bash
  sudo chown -R www-data:www-data laravel/database
  ```

### Configurazione Client Redis
```ini

# Configurazione nel file .env
REDIS_CLIENT=predis
```

**Spiegazione:**
- Configura Laravel per utilizzare Predis come client Redis
- Predis è un client PHP puro per Redis
- Non richiede estensioni PHP aggiuntive
- Più facile da installare e mantenere

**Funzionalità:**
- Supporto completo per Redis
- API PHP pura
- Facile integrazione con Laravel
- Supporto per tutte le funzionalità di Redis
- Gestione delle connessioni

**Note:**
- Assicurarsi che Predis sia installato:
  ```bash
  composer require predis/predis
  ```
- Verificare la configurazione in `config/database.php`:
  ```php
  'redis' => [
      'client' => env('REDIS_CLIENT', 'predis'),
      // ...
  ]
  ```
- In caso di problemi, verificare i log:
  ```bash
  tail -f storage/logs/laravel.log
  ```
- Per testare la connessione Redis:
  ```bash
  php artisan tinker
  >>> Redis::ping()
  ```

### Pubblicazione Vendor e Migrazioni
```bash

# Pubblica tutti i file dei vendor
php artisan vendor:publish --all

# Rimuove le migrazioni esistenti
rm -rf database/migrations

# Esegue le migrazioni
php artisan migrate
```

**Spiegazione:**
- `vendor:publish --all`: Pubblica tutti i file di configurazione e asset dai pacchetti installati
- `rm -rf database/migrations`: Rimuove tutte le migrazioni esistenti
- `php artisan migrate`: Esegue le migrazioni del database

**Funzionalità:**
- Pubblicazione di file di configurazione
- Pubblicazione di asset statici
- Pubblicazione di viste e componenti
- Gestione delle migrazioni del database
- Sincronizzazione dello schema del database

**Note:**
- Eseguire i comandi nella directory del progetto Laravel
- Assicurarsi che il database sia configurato correttamente nel file `.env`
- Verificare che l'utente abbia i permessi necessari per le operazioni
- In caso di problemi con le migrazioni:
  ```bash
  php artisan migrate:status
  php artisan migrate:rollback
  ```
- Se necessario, forzare l'esecuzione delle migrazioni:
  ```bash
  php artisan migrate --force
  ```
- Per ripristinare tutte le migrazioni:
  ```bash
  php artisan migrate:fresh
  ```

## Note e Consigli

*In attesa dei comandi per documentare...*

## Ottimizzazione PHP

### Configurazione php.ini
```ini
memory_limit = 256M
upload_max_filesize = 64M
post_max_size = 64M
max_execution_time = 300
max_input_time = 300
error_reporting = E_ALL & ~E_DEPRECATED & ~E_STRICT
display_errors = Off
log_errors = On
error_log = /var/log/php/error.log
session.gc_maxlifetime = 1440
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 4000
opcache.revalidate_freq = 60
opcache.fast_shutdown = 1
opcache.enable_cli = 1
```

### Installazione Redis
```bash
sudo apt install redis-server
sudo systemctl enable redis-server
sudo systemctl start redis-server
```

### Configurazione Redis
```ini

# /etc/redis/redis.conf
maxmemory 256mb
maxmemory-policy allkeys-lru
```

## Ottimizzazione Apache

### Configurazione Virtual Host
```apache
<VirtualHost *:80>
    ServerName project.local
    DocumentRoot /var/www/html/project/public
    
    <Directory /var/www/html/project/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/project-error.log
    CustomLog ${APACHE_LOG_DIR}/project-access.log combined
</VirtualHost>
```

### Configurazione Performance
```apache

# /etc/apache2/mods-available/mpm_prefork.conf
<IfModule mpm_prefork_module>
    StartServers 5
    MinSpareServers 5
    MaxSpareServers 10
    MaxRequestWorkers 150
    MaxConnectionsPerChild 0
</IfModule>
```

### Gestione Moduli Apache
```bash

# Disabilita il modulo PHP 8.2
sudo a2dismod php8.2

# Abilita il modulo PHP 8.3
sudo a2enmod php8.3

# Abilita il modulo rewrite
sudo a2enmod rewrite
```

**Spiegazione:**
- Gestisce i moduli Apache necessari per il progetto
- `a2dismod`: Disabilita un modulo Apache
- `a2enmod`: Abilita un modulo Apache
- `rewrite`: Necessario per le regole di riscrittura URL in Laravel

**Moduli Gestiti:**
- **PHP 8.2:**
  - Disabilitato per evitare conflitti
  - Rimuove il supporto per PHP 8.2

- **PHP 8.3:**
  - Abilitato come versione principale
  - Fornisce il supporto per PHP 8.3

- **Rewrite:**
  - Abilitato per il routing di Laravel
  - Necessario per le regole .htaccess
  - Abilita la riscrittura degli URL

**Note:**
- Richiede privilegi di root (sudo)
- Dopo le modifiche, riavviare Apache:
  ```bash
  sudo systemctl restart apache2
  ```
- Verificare i moduli attivi:
  ```bash
  sudo apache2ctl -M
  ```
- In caso di problemi, verificare i log:
  ```bash
  sudo tail -f /var/log/apache2/error.log
  ```

## Ottimizzazione MySQL

### Configurazione my.cnf
```ini
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
innodb_flush_method = O_DIRECT
max_connections = 151
query_cache_size = 64M
query_cache_limit = 2M
thread_cache_size = 8
table_open_cache = 2000
```

## Sicurezza

### Configurazione Firewall
```bash
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow http
sudo ufw allow https
sudo ufw enable
```

### Installazione Fail2ban
```bash
sudo apt install fail2ban
sudo systemctl enable fail2ban
sudo systemctl start fail2ban
```

## Monitoraggio

### Installazione Monitor Tools
```bash
sudo apt install htop iotop iftop
```

### Configurazione Log Rotation
```bash
sudo nano /etc/logrotate.d/project
```

```ini
/var/www/html/project/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    delaycompress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        if [ -f /var/run/php-fpm/php-fpm.pid ]; then
            kill -USR1 `cat /var/run/php-fpm/php-fpm.pid`
        fi
    endscript
}
```

## Laravel Specific

### Configurazione Queue Workers
```bash
sudo nano /etc/supervisor/conf.d/project-worker.conf
```

```ini
[program:project-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/html/project/storage/logs/worker.log
```

### Configurazione Scheduler
```bash
sudo crontab -e
```

```bash
* * * * * cd /var/www/html/project && php artisan schedule:run >> /dev/null 2>&1
```

### Creazione Utente Filament
```bash
php artisan make:filament-user
```

**Spiegazione:**
- Crea un nuovo utente amministratore per il pannello Filament
- Interattivo: richiede email, nome e password
- L'utente creato avrà accesso completo al pannello di amministrazione

**Funzionalità:**
- Creazione utente amministratore
- Configurazione credenziali di accesso
- Assegnazione ruolo super admin
- Accesso al pannello Filament

**Note:**
- Eseguire il comando nella directory del progetto Laravel
- Assicurarsi che Filament sia installato correttamente
- Verificare che il database sia configurato e accessibile
- Dopo la creazione, accedere al pannello con le credenziali fornite
- Se necessario, modificare i permessi dell'utente:
  ```bash
  php artisan permission:create-role admin
  php artisan permission:assign-role admin
  ```
- In caso di problemi, verificare i log:
  ```bash
  tail -f storage/logs/laravel.log
  ```

### Creazione Super Admin
```bash
php artisan user:super-admin
```

**Spiegazione:**
- Crea un nuovo utente con privilegi di super amministratore
- Interattivo: richiede email, nome e password
- L'utente creato avrà accesso completo a tutte le funzionalità del sistema

**Funzionalità:**
- Creazione utente super admin
- Configurazione credenziali di accesso
- Assegnazione ruolo super admin
- Accesso completo al sistema
- Gestione di tutti i permessi

**Note:**
- Eseguire il comando nella directory del progetto Laravel
- Assicurarsi che il database sia configurato e accessibile
- Dopo la creazione, accedere al sistema con le credenziali fornite
- Se necessario, verificare i permessi dell'utente:
  ```bash
  php artisan permission:show
  ```
- In caso di problemi, verificare i log:
  ```bash
  tail -f storage/logs/laravel.log
  ```
- Per rimuovere i privilegi di super admin:
  ```bash
  php artisan user:remove-super-admin
  ```

### Assegnazione Moduli Utente
```bash
php artisan user:assign-module
```

**Spiegazione:**
- Assegna moduli specifici a un utente esistente
- Interattivo: richiede l'email dell'utente e i moduli da assegnare
- Permette di gestire l'accesso ai diversi moduli del sistema

**Funzionalità:**
- Assegnazione moduli a utenti
- Gestione accessi per modulo
- Configurazione permessi specifici
- Gestione ruoli per modulo

**Note:**
- Eseguire il comando nella directory del progetto Laravel
- Assicurarsi che l'utente esista nel sistema
- Verificare che i moduli siano installati correttamente
- Dopo l'assegnazione, verificare i permessi:
  ```bash
  php artisan module:list
  ```
- In caso di problemi, verificare i log:
  ```bash
  tail -f storage/logs/laravel.log
  ```
- Per rimuovere l'assegnazione di un modulo:

  ```

  ```
 80ec88ee9 (.)

