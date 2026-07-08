# Guida Super Semplice: WSL + Laravel + Webmin + HeidiSQL

> **Questa guida è pensata per chi non ha mai usato Linux e vuole installare un ambiente di sviluppo web completo su Windows con pochi semplici passaggi. Seguila nell'ordine indicato.**

> **Nota**: Per informazioni aggiuntive sull'installazione, consulta anche [Installazione](../../../docs/installazione.md)

## Collegamenti tra versioni di setup.md
* [installazione.md](../../../docs/installazione.md)
* [setup.md](setup.md)

## ❗ Prima di Iniziare

### Cosa ti serve:
1. Un computer Windows 10 o 11
2. Connessione a Internet
3. 10GB di spazio libero sul disco
4. **Tempo totale stimato**: 1-2 ore (a seconda della velocità di download e installazione)

### Cosa installeremo:
- WSL (Windows Subsystem for Linux) - ~15 minuti
- Ubuntu (sistema operativo Linux) - ~10 minuti
- LAMP Server (Linux, Apache, MySQL, PHP) - ~20 minuti
- PHP 8.3 (ultima versione) - ~10 minuti
- Webmin (pannello di controllo) - ~5 minuti
- HeidiSQL (gestore database) - ~5 minuti
- Laravel 12 (framework PHP) - ~15 minuti
- Chiavi SSH per GitHub - ~5 minuti

## Parte 1: Installare WSL (Windows Subsystem for Linux)
**Tempo stimato: 30-45 minuti**

### Passo 1: Verifica Windows (5 minuti)
1. Premi `Windows + R` sulla tastiera
2. Scrivi `winver` e premi Invio
3. Se vedi "Windows 10 versione 1903 o superiore" o "Windows 11", puoi procedere
   - Se non vedi questa versione, aggiorna Windows prima di continuare
   - Per aggiornare: Start -> Impostazioni -> Windows Update -> Verifica aggiornamenti

### Passo 2: Abilita WSL e Virtual Machine Platform (5 minuti)
1. Premi `Windows + X` sulla tastiera
2. Seleziona **Windows PowerShell (amministratore)** o **Terminal (amministratore)**
3. Copia e incolla questi comandi uno alla volta:
```powershell
dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart
```
Premi Invio e aspetta che finisca.

Poi copia e incolla:
```powershell
dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart
```
Premi Invio e aspetta che finisca.

Poi copia e incolla:
```powershell
wsl --set-default-version 2
```
Premi Invio e aspetta che finisca.

### Passo 3: Scarica e Installa il Kernel Linux (5 minuti)
1. Apri il browser e vai a:
   https://wslstorestorage.blob.core.windows.net/wslblob/wsl_update_x64.msi
2. Scarica e installa il pacchetto di aggiornamento del kernel Linux
3. Riavvia il computer quando richiesto

### Passo 4: Installa Ubuntu (5-10 minuti)
1. Apri il Microsoft Store
2. Cerca "Ubuntu 22.04 LTS"
3. Clicca su "Installa"
4. Aspetta che il download e l'installazione terminino

### Passo 5: Configura Ubuntu (10-15 minuti)
1. Apri Ubuntu dal menu Start
2. Aspetta che finisca l'installazione (potrebbe volerci qualche minuto)
3. Quando richiesto:
   - Scrivi un nome utente (es: mario)
   - Premi Invio
   - Scrivi una password (non vedrai i caratteri, è normale)
   - Premi Invio
   - Riscrivi la stessa password
   - Premi Invio
   - **RICORDA QUESTA PASSWORD!** (la userai spesso)

### Passo 6: Installa Zsh e Powerlevel10k (10-15 minuti)
1. Apri l'app "Ubuntu" dal menu Start

2. Installa zsh e git:
```bash
sudo apt install -y zsh git
```
Premi Invio.

3. Imposta zsh come shell predefinita:
```bash
chsh -s $(which zsh)
```
Premi Invio.

4. Installa Oh My Zsh:
```bash
sh -c "$(curl -fsSL https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/tools/install.sh)"
```
Premi Invio e segui le istruzioni.

5. Installa Powerlevel10k:
```bash
git clone --depth=1 https://github.com/romkatv/powerlevel10k.git ${ZSH_CUSTOM:-$HOME/.oh-my-zsh/custom}/themes/powerlevel10k
```
Premi Invio.

6. Abilita il tema:
```bash
nano ~/.zshrc
```
- Trova la riga `ZSH_THEME="..."` e sostituiscila con:
  `ZSH_THEME="powerlevel10k/powerlevel10k"`
- Salva con Ctrl+O, premi Invio, esci con Ctrl+X.

7. Avvia zsh:
```bash
zsh
```
Premi Invio e segui la configurazione guidata (premi Invio per le opzioni base).

## Parte 2: Installa LAMP e Webmin

### Passo 1: Installa LAMP (Linux, Apache, MySQL, PHP) (20 minuti)
Copia e incolla questi comandi uno alla volta:
```bash
sudo apt install "*tasksel*"
```
Premi Invio.

Poi copia e incolla:
```bash
sudo apt install lamp-server^
```
Premi Invio.

Durante l'installazione:
- Inserisci una password per MySQL (ricordala!)
- Premi Invio
- Riscrivi la stessa password
- Premi Invio
- Aspetta che finisca l'installazione (potrebbe volerci qualche minuto)

### Passo 2: Installa PHP 8.3 (10 minuti)
Copia e incolla questi comandi uno alla volta:
```bash
sudo apt install -y software-properties-common
```
Premi Invio.

Poi copia e incolla:
```bash
sudo add-apt-repository ppa:ondrej/php -y
```
Premi Invio.

Poi copia e incolla:
```bash
sudo apt update
```
Premi Invio.

Infine copia e incolla:
```bash
sudo apt install -y php8.3 php8.3-cli php8.3-fpm php8.3-mysql php8.3-curl php8.3-mbstring php8.3-xml php8.3-zip php8.3-gd php8.3-openssl
```
Premi Invio e aspetta che finisca l'installazione.

### Passo 3: Installa NVM e Node.js (15 minuti)
1. Installa NVM:
```bash
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash
```
Premi Invio.

2. Riavvia il terminale o esegui:
```bash
source ~/.zshrc
```
Premi Invio.

3. Installa Node.js LTS:
```bash
nvm install --lts
```
Premi Invio.

4. Imposta Node.js LTS come versione predefinita:
```bash
nvm use --lts
nvm alias default node
```
Premi Invio dopo ogni comando.

5. Verifica l'installazione:
```bash
node --version
npm --version
```
Premi Invio dopo ogni comando.

### Passo 4: Configura SSH per GitHub (10 minuti)
1. Genera le chiavi SSH:
```bash
ssh-keygen -t ed25519 -C "tua@email.com"
```
Premi Invio 3 volte (usa le impostazioni predefinite).

2. Avvia l'agente SSH:
```bash
eval "$(ssh-agent -s)"
```
Premi Invio.

3. Aggiungi la chiave all'agente:
```bash
ssh-add ~/.ssh/id_ed25519
```
Premi Invio.

4. Mostra la chiave pubblica:
```bash
cat ~/.ssh/id_ed25519.pub
```
Premi Invio e copia l'output.

5. Aggiungi la chiave a GitHub:
   - Vai su GitHub.com
   - Clicca sulla tua foto profilo
   - Vai su Settings -> SSH and GPG keys
   - Clicca "New SSH key"
   - Incolla la chiave che hai copiato
   - Clicca "Add SSH key"

6. Verifica la connessione:
```bash
ssh -T git@github.com
```
Premi Invio e rispondi "yes" se richiesto.

## Parte 3: Configura MySQL e Apache con Webmin
**Tempo stimato: 15-20 minuti**

### Passo 1: Configura MySQL con Webmin (5-10 minuti)
1. Apri Webmin nel browser: https://localhost:10000
2. Accedi con:
   - Username: root
   - Password: (quella che hai scelto durante l'installazione)

3. Vai in "Servers" -> "MySQL Database Server"
4. Clicca su "Create a new database"
5. Inserisci:
   - Database name: mioprogetto
   - Clicca "Create"

6. Clicca su "Create a new user"
7. Inserisci:
   - Username: mioprogetto
   - Password: (scegli una password sicura)
   - Host: localhost
   - Clicca "Create"

8. Clicca su "Module Config"
9. In "MySQL Configuration":
   - Authentication Method: mysql_native_password
   - **Importante**: Deseleziona la casella "Listen on localhost only"
   - Clicca "Save"

10. Ottieni l'IP di WSL:
```bash
hostname -I
```
Premi Invio e prendi nota dell'IP mostrato (es: 172.xx.xx.xx)

11. Riavvia MySQL per applicare le modifiche:
```bash
sudo systemctl restart mysql
```
Premi Invio e aspetta che il servizio si riavvii.

### Passo 2: Configura Virtual Host in Webmin (5-10 minuti)
1. Vai in "Servers" -> "Apache Web Server"
2. Clicca su "Create virtual host"
3. Imposta:
   - **Document Root**: `/home/<TUO_UTENTE>/progetti/mioprogetto/public_html`
   - **Server Name**: `mioprogetto.local`
   - **Port**: 80
   - Clicca "Create Now"

4. Clicca su "Edit Directives" per il virtual host
5. Aggiungi queste righe:
```apache
<Directory /home/<TUO_UTENTE>/progetti/mioprogetto/public_html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>

ErrorLog ${APACHE_LOG_DIR}/mioprogetto-error.log
CustomLog ${APACHE_LOG_DIR}/mioprogetto-access.log combined
```
6. Clicca "Save"

### Passo 3: Configura SSL in Webmin
1. Vai in "Servers" -> "Apache Web Server"
2. Clicca su "Create virtual host"
3. Imposta:
   - **Document Root**: `/home/<TUO_UTENTE>/progetti/mioprogetto/public_html`
   - **Server Name**: `mioprogetto.local`
   - **Port**: 443
   - **SSL**: Enabled
   - Clicca "Create Now"

4. Clicca su "SSL Options"
5. Imposta:
   - SSL Enabled: Yes
   - Certificate File: `/etc/apache2/ssl/mioprogetto.crt`
   - Private Key File: `/etc/apache2/ssl/mioprogetto.key`
   - Clicca "Save"

### Passo 4: Abilita i moduli necessari
1. Vai in "Servers" -> "Apache Web Server"
2. Clicca su "Module Config"
3. Abilita questi moduli:
   - mod_ssl
   - mod_rewrite
   - mod_headers
4. Clicca "Save"

### Passo 5: Genera certificato SSL
1. Apri il terminale Ubuntu
2. Esegui:
```bash
sudo mkdir -p /etc/apache2/ssl
cd /etc/apache2/ssl
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout mioprogetto.key -out mioprogetto.crt
```

3. Quando richiesto, inserisci:
   - Country Name: IT
   - State or Province: (la tua provincia)
   - Locality Name: (la tua città)
   - Organization Name: Dev Environment
   - Organizational Unit Name: Local Development
   - Common Name: mioprogetto.local
   - Email Address: (la tua email)

### Passo 6: Configura il redirect HTTP a HTTPS
1. In Webmin, vai in "Servers" -> "Apache Web Server"
2. Clicca su "Edit Directives" per il virtual host HTTP (porta 80)
3. Aggiungi queste righe:
```apache
RewriteEngine On
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```
4. Clicca "Save"

### Passo 7: Riavvia Apache
1. In Webmin, vai in "System" -> "Bootup and Shutdown"
2. Clicca su "Apache Web Server"
3. Clicca "Restart"

### Passo 8: Configura il Database in Laravel
1. Modifica il file .env:
```bash
nano ~/progetti/mioprogetto/.env
```

2. Aggiorna le impostazioni del database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mioprogetto
DB_USERNAME=dbuser
DB_PASSWORD=la_password_che_hai_scelto
APP_URL=https://mioprogetto.local
```

3. Salva e esci (Ctrl+O, Invio, Ctrl+X)

4. Crea il link simbolico per public_html:
```bash
cd ~/progetti/mioprogetto
ln -s public public_html
```

5. Esegui le migrazioni:
```bash
php artisan migrate
```

## Parte 4: Configura HeidiSQL
**Tempo stimato: 10-15 minuti**

### Passo 1: Configura MySQL per l'accesso esterno (5-8 minuti)
1. Apri Webmin nel browser:
   - Vai su https://localhost:10000
2. Accedi con il tuo nome utente e password

3. Prima di tutto, ottieni l'indirizzo IP di WSL eseguendo questo comando nel terminale Ubuntu:
```bash
hostname -I
```
Premi Invio e prendi nota dell'indirizzo IP mostrato (es. 172.x.x.x). Ti servirà per connetterti da HeidiSQL.

4. In Webmin, vai su **Servers > MySQL Database Server**
5. Clicca su **Module Config**
6. Trova l'opzione **Listen only on address** e deselezionala o svuota il campo (questo permetterà connessioni da qualsiasi IP)
7. Clicca su **Save**
8. Riavvia MySQL:
```bash
sudo systemctl restart mysql
```
9. Nella stessa pagina di MySQL, clicca sulla scheda **User Permissions**
10. Clicca su **Create new user**
11. Compila i campi:
    - **Username**: `dbuser`
    - **Host**: `%` (questo permette connessioni da qualsiasi host/IP)
    - **Password**: crea una password sicura (annotala!)
    - Seleziona l'opzione **Any database**
    - Nelle opzioni di privilegi, seleziona: `SELECT`, `INSERT`, `UPDATE`, `DELETE`, `CREATE`, `DROP`, `INDEX`, `ALTER`
12. Clicca su **Create**

### Passo 2: Crea un database per il progetto (5 minuti)
1. Apri Webmin nel browser:
   - Vai su https://localhost:10000
2. Accedi con il tuo nome utente e password
3. Vai su **Servers > MySQL Database Server**
4. Clicca su **Create a new database**
5. **Nome**: `mioprogetto`
6. Clicca **Create**

### Passo 3: Assegna l'utente al database (5 minuti)
1. Apri Webmin nel browser:
   - Vai su https://localhost:10000
2. Accedi con il tuo nome utente e password
3. Vai su **Servers > MySQL Database Server**
4. Clicca su **Database Permissions**
5. Clicca su **Add permissions**
6. Inserisci:
   - **User**: `dbuser@%` (l'utente che abbiamo creato in precedenza)
   - **Databases**: `mioprogetto` (seleziona il database specifico, è più sicuro che "Any")
   - **Permissions**: Seleziona tutti i privilegi necessari
7. Clicca su **Save**

8. **Nota sulla sicurezza**: in ambiente di produzione è consigliabile limitare gli accessi esterni solo agli IP necessari e non usare `%` come host. Questa configurazione è pensata per ambienti di sviluppo locali.

### Passo 4: Connetti HeidiSQL
1. Apri HeidiSQL in Windows (dal menu Start)
2. Clicca su "Nuovo" (icona con il +)
3. Inserisci:
    - Hostname/IP: (l'IP di WSL che hai ottenuto con `hostname -I`)
    - Porta: 3306
    - Utente: dbuser
    - Password: (la password che hai impostato per l'utente dbuser)
4. Clicca "Apri"
5. Se appare un avviso di sicurezza, clicca "Sì"
6. Verifica di poter vedere il database `mioprogetto` nella lista dei database

### Passo 5: Verifica la connessione (2 minuti)
1. In HeidiSQL, clicca destro sul database `mioprogetto`
2. Seleziona "Nuova Query"
3. Scrivi e esegui:
```sql
SHOW TABLES;
```
4. Se non vedi errori, la connessione è stata stabilita correttamente

## Parte 5: Clona e Configura Progetto Laravel 12

### Passo 1: Installa Composer (5 minuti)
Copia e incolla questi comandi:
```bash
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
```
Premi Invio e aspetta che finisca.

### Passo 2: Crea cartella progetti (2 minuti)
```bash
mkdir -p ~/progetti
cd ~/progetti
```
Premi Invio dopo ogni riga.

### Passo 3: Clona il tuo progetto da GitHub (5-15 minuti, dipende dalla dimensione)
Sostituisci 'nome-utente/mio-repository' con il tuo repository GitHub:
```bash
git clone git@github.com:nome-utente/mio-repository.git mioprogetto
```
Premi Invio e aspetta che finisca.

### Passo 4: Alternativa - Crea un nuovo progetto Laravel 12 (15 minuti)
Se non hai un repository da clonare, puoi creare un nuovo progetto Laravel 12:
```bash
composer create-project laravel/laravel:^12.0 mioprogetto
```
Premi Invio e aspetta che finisca (potrebbe volerci qualche minuto).

### Passo 5: Configura il progetto (10 minuti)
```bash
cd mioprogetto
cp .env.example .env
composer install
php artisan key:generate
```
Premi Invio dopo ogni riga.

### Passo 6: Installa Dipendenze Frontend (10-20 minuti)
1. Installa le dipendenze npm:
```bash
cd ~/progetti/mioprogetto
npm install
```
Premi Invio e aspetta che finisca.

2. Compila gli assets:
```bash
npm run build
```
Premi Invio e aspetta che finisca.

### Passo 7: Configura il Database (15 minuti)
1. In HeidiSQL:
   - Clicca destro su "Database"
   - Seleziona "Crea nuovo"
   - Scrivi "laravel" come nome
   - Clicca "OK"

2. In Ubuntu, copia e incolla:
```bash
cp .env.example .env
```
Premi Invio.

Poi copia e incolla:
```bash
php artisan key:generate
```
Premi Invio.

Poi copia e incolla:
```bash
nano .env
```
Premi Invio.

3. Modifica queste righe nel file .env:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=tua_password_mysql
APP_URL=https://mioprogetto.local
```
Per modificare:
- Usa le frecce per muoverti
- Cancella il testo esistente
- Scrivi il nuovo testo
- Premi Ctrl+O per salvare
- Premi Invio
- Premi Ctrl+X per uscire

### Passo 8: Avvia il Progetto (5 minuti)
Copia e incolla questi comandi:
```bash
php artisan migrate
```
Premi Invio.

Poi copia e incolla:
```bash
php artisan serve
```
Premi Invio.

Apri il browser e vai a: http://localhost:8000

## Parte 5: Configura Virtual Host e HTTPS

### Passo 1: Configura Virtual Host in Webmin (15 minuti)
```bash
sudo nano /etc/apache2/sites-available/mioprogetto.conf
```
Copia e incolla questo contenuto, sostituendo `<TUO_UTENTE>` con il tuo nome utente:

```apache
<VirtualHost *:80>
    ServerName mioprogetto.local
    DocumentRoot /home/<TUO_UTENTE>/progetti/mioprogetto/public_html

    <Directory /home/<TUO_UTENTE>/progetti/mioprogetto/public_html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/mioprogetto-error.log
    CustomLog ${APACHE_LOG_DIR}/mioprogetto-access.log combined
</VirtualHost>
```
Salva (Ctrl+O, Invio) ed esci (Ctrl+X).

### Passo 2: Configura SSL con certificato autofirmato (20 minuti)
```bash
sudo mkdir -p /etc/apache2/ssl
cd /etc/apache2/ssl
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout mioprogetto.key -out mioprogetto.crt
```

Quando richiesto, inserisci:
- Country Name: IT (o il tuo paese)
- State or Province: La tua provincia
- Locality Name: La tua città
- Organization Name: Dev Environment
- Organizational Unit Name: Local Development
- Common Name: mioprogetto.local
- Email Address: tua@email.com

### Passo 3: Configura il Virtual Host HTTPS
```bash
sudo nano /etc/apache2/sites-available/mioprogetto-ssl.conf
```

Incolla questo contenuto (sostituisci di nuovo `<TUO_UTENTE>` con il tuo nome utente):

```apache
<VirtualHost *:443>
    ServerName mioprogetto.local
    DocumentRoot /home/<TUO_UTENTE>/progetti/mioprogetto/public_html

    <Directory /home/<TUO_UTENTE>/progetti/mioprogetto/public_html>
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/mioprogetto-error.log
    CustomLog ${APACHE_LOG_DIR}/mioprogetto-access.log combined

    SSLEngine on
    SSLCertificateFile /etc/apache2/ssl/mioprogetto.crt
    SSLCertificateKeyFile /etc/apache2/ssl/mioprogetto.key
</VirtualHost>
```
Salva (Ctrl+O, Invio) ed esci (Ctrl+X).

### Passo 4: Abilita i moduli e i siti
```bash
sudo a2enmod ssl
sudo a2enmod rewrite
sudo a2ensite mioprogetto.conf
sudo a2ensite mioprogetto-ssl.conf
sudo systemctl restart apache2
```

### Passo 5: Modifica il file hosts su Windows
1. Premi `Windows + S`, cerca **Notepad**
2. Clicca destro su **Notepad** e seleziona **Esegui come amministratore**
3. Nel menu **File**, apri:
   `C:\Windows\System32\drivers\etc\hosts`
4. Aggiungi alla fine del file:
   `127.0.0.1 mioprogetto.local`
5. Salva e chiudi Notepad

### Passo 6: Verifica l'installazione (10 minuti)
1. Riavvia tutti i servizi:
```bash
sudo service apache2 restart
sudo service mysql restart
sudo service php8.3-fpm restart
```

2. Apri il browser in Windows e vai all'indirizzo:
```
https://mioprogetto.local
```

3. Vedrai un avviso di sicurezza sul certificato autofirmato. Clicca su "Avanzate" o "Mostra dettagli" e poi su "Procedi a mioprogetto.local (non sicuro)" o simile. Questo è normale perché stiamo usando un certificato autofirmato in ambiente di sviluppo.

4. Dovresti vedere la pagina di benvenuto di Laravel 12 o la homepage del tuo progetto.

## Troubleshooting

### Se il sito non si apre:
1. Verifica il file hosts:
   - Apri PowerShell come amministratore
   - Digita: `ping mioprogetto.local`
   - Se non risponde a 127.0.0.1, controlla il file hosts

2. Verifica i permessi:
```bash
sudo chown -R www-data:www-data ~/progetti/mioprogetto
sudo chmod -R 755 ~/progetti/mioprogetto
```

3. Verifica i log:
```bash
sudo tail -f /var/log/apache2/error.log
sudo tail -f /var/log/php8.3-fpm.log
```

### Se GitHub non funziona con SSH:
1. Verifica la connessione:
```bash
ssh -T git@github.com
```

2. Se non funziona:
   - Controlla che la chiave sia stata aggiunta correttamente su GitHub
   - Verifica che l'agente SSH sia in esecuzione
   - Prova a riavviare l'agente SSH:
```bash
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_ed25519
```

### Comandi Utili da Ricordare:
```bash











# Riavviare tutti i servizi
sudo service mysql restart
sudo service php8.2-fpm restart
sudo service apache2 restart

# Vedere i log di errore
sudo tail -f /var/log/mysql/error.log
sudo tail -f /var/log/apache2/error.log
```

6. **Problemi con HTTPS**:
   - Verifica il certificato:
     ```bash
     sudo certbot certificates
     ```
   - Rinnova il certificato se necessario:
     ```bash
     sudo certbot renew
     ```
   - Verifica la configurazione SSL in Webmin:
     - Vai su "Servers" -> "Apache Web Server"
     - Clicca sul virtual host
     - Verifica le impostazioni SSL

7. **Problemi con SSH**:
   - Verifica la connessione:
     ```bash
     ssh -T git@github.com
     ```
   - Se non funziona, prova a rigenerare le chiavi:
     ```bash
     rm ~/.ssh/id_ed25519*
     ssh-keygen -t ed25519 -C "tua@email.com"
     ```

8. **Problemi con Node.js/npm**:
   - Verifica la versione di Node.js:
     ```bash
     node --version
     nvm ls
     ```
   - Se necessario, reinstallare Node.js:
     ```bash
     nvm uninstall node
     nvm install --lts
     nvm use --lts
     ```
   - Verifica i permessi npm:
     ```bash
     sudo chown -R $USER:$(id -gn $USER) ~/.npm
     sudo chown -R $USER:$(id -gn $USER) ~/.config
     ```

## Collegamenti Utili per Approfondimenti

### DISM e WSL2
- [DISM | Microsoft Docs](https://learn.microsoft.com/windows-hardware/manufacture/desktop/dism)
- [Installazione WSL | Microsoft Docs](https://learn.microsoft.com/windows/wsl/install)
- [Virtual Machine Platform Feature | Microsoft Docs](https://learn.microsoft.com/windows/wsl/compare-versions#virtual-machine-platform)

### Virtual Hosts Apache
- [Apache Virtual Hosts](https://httpd.apache.org/docs/2.4/vhosts/)
- [Apache SSL How-To](https://httpd.apache.org/docs/2.4/ssl/ssl_howto.html)

### File hosts Windows
- [Windows hosts file (HOSTS)](https://learn.microsoft.com/windows-server/administration/windows-commands/hosts)

### Zsh e Powerlevel10k
- [Oh My Zsh](https://ohmyz.sh/)
- [Powerlevel10k GitHub](https://github.com/romkatv/powerlevel10k)

### WSL e Ubuntu
- [Documentazione ufficiale WSL](https://learn.microsoft.com/it-it/windows/wsl/)
- [Guida all'installazione WSL](https://learn.microsoft.com/it-it/windows/wsl/install)
- [Documentazione Ubuntu su WSL](https://ubuntu.com/wsl)
- [Comandi base Ubuntu](https://help.ubuntu.com/community/Beginners/CLI)
- [Tutorial completo WSL e PHP](https://www.digitalocean.com/community/tutorials/how-to-install-php-on-ubuntu-20-04-it)
- [Video tutorial WSL (Italiano)](https://www.youtube.com/watch?v=V_Pz-0_xZ4g)
- [Configurazione avanzata WSL](https://learn.microsoft.com/it-it/windows/wsl/wsl-config)
- [Risoluzione dei problemi comuni di WSL](https://learn.microsoft.com/it-it/windows/wsl/troubleshooting)
- [WSL vs Macchine Virtuali](https://learn.microsoft.com/it-it/windows/wsl/compare-versions)

### MySQL e HeidiSQL
- [Documentazione MySQL](https://dev.mysql.com/doc/)
- [Guida HeidiSQL](https://www.heidisql.com/documentation.php)
- [Configurazione MySQL per accesso remoto](https://dev.mysql.com/doc/refman/8.0/en/remote-access.html)
- [Gestione utenti MySQL](https://dev.mysql.com/doc/refman/8.0/en/adding-users.html)
- [Video tutorial HeidiSQL](https://www.youtube.com/watch?v=5AOFMsEUGEs)
- [MySQL Workbench (alternativa a HeidiSQL)](https://www.mysql.com/products/workbench/)
- [Risoluzione problemi di connessione MySQL](https://dev.mysql.com/doc/refman/8.0/en/problems-connecting.html)
- [Ottimizzazione delle query MySQL](https://dev.mysql.com/doc/refman/8.0/en/optimization.html)
- [Importare/esportare database con HeidiSQL](https://www.heidisql.com/help.php?place=export)

### Webmin
- [Documentazione Webmin](https://www.webmin.com/docs/)
- [Configurazione Apache in Webmin](https://www.webmin.com/docs/modules/apache/)
- [Gestione MySQL in Webmin](https://www.webmin.com/docs/modules/mysql/)
- [Configurazione SSL in Webmin](https://www.webmin.com/docs/modules/ssl/)
- [Forum Webmin](https://forum.webmin.com/)
- [Video tutorial Webmin](https://www.youtube.com/watch?v=mwBYlFt_Sxw)
- [Sicurezza Webmin](https://doxfer.webmin.com/Webmin/Security)
- [Webmin Wiki](https://doxfer.webmin.com/Webmin/Main_Page)
- [Aggiornamento di Webmin](https://www.webmin.com/upgrade.html)

### Laravel
- [Documentazione Laravel 12](https://laravel.com/docs/12.x)
- [Installazione Laravel](https://laravel.com/docs/12.x/installation)
- [Configurazione Database](https://laravel.com/docs/12.x/database)
- [Migrazioni Database](https://laravel.com/docs/12.x/migrations)
- [Configurazione Virtual Host](https://laravel.com/docs/12.x/deployment#apache)
- [Video tutorial Laravel 12 (completo)](https://laracasts.com/series/whats-new-in-laravel-12)
- [Laracasts - Tutorial e risorse](https://laracasts.com/)
- [Laravel News](https://laravel-news.com/)
- [Eloquent ORM](https://laravel.com/docs/12.x/eloquent)
- [Laravel Modules](https://nwidart.com/laravel-modules/)
- [Best practices Laravel](https://github.com/alexeymezenin/laravel-best-practices)
- [Laravel Folio](https://laravel.com/docs/12.x/folio)
- [Laravel Livewire](https://livewire.laravel.com/)
- [Laravel Filament](https://filamentphp.com/)

### PHP
- [Documentazione PHP 8.3](https://www.php.net/manual/it/)
- [Configurazione PHP-FPM](https://www.php.net/manual/it/install.fpm.php)
- [Estensioni PHP](https://www.php.net/manual/it/extensions.alphabetical.php)
- [Configurazione php.ini](https://www.php.net/manual/it/configuration.file.php)
- [PHP The Right Way](https://phptherightway.com/)
- [PHP-FPM vs mod_php](https://www.cloudways.com/blog/php-fpm-on-cloud/)
- [Guide PHP su DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-install-php-8-2-on-ubuntu-22-04)
- [Debugging PHP con Xdebug](https://xdebug.org/docs/)
- [PHP Insights](https://phpinsights.com/)
- [PHP Standards Recommendations (PSR)](https://www.php-fig.org/psr/)

### Node.js e npm
- [Documentazione Node.js](https://nodejs.org/it/docs/)
- [Guida NVM](https://github.com/nvm-sh/nvm)
- [Documentazione npm](https://docs.npmjs.com/)
- [Gestione dipendenze npm](https://docs.npmjs.com/cli/v9/commands/npm-install)
- [Node.js Best Practices](https://github.com/goldbergyoni/nodebestpractices)
- [Video tutorial NVM](https://www.youtube.com/watch?v=ohBFbA0O6hs)
- [npm vs Yarn vs pnpm](https://blog.logrocket.com/npm-vs-yarn-vs-pnpm/)
- [Gestione versioni Node.js con NVM](https://www.sitepoint.com/quick-tip-multiple-versions-node-nvm/)
- [Troubleshooting npm](https://docs.npmjs.com/troubleshooting)
- [Vite.js per sviluppo frontend](https://vitejs.dev/guide/)

### SSL e HTTPS
- [Guida Certbot](https://certbot.eff.org/instructions)
- [Configurazione SSL Apache](https://httpd.apache.org/docs/2.4/ssl/)
- [Generazione certificati SSL](https://www.openssl.org/docs/man1.1.1/man1/req.html)
- [Let's Encrypt](https://letsencrypt.org/docs/)
- [Mozilla SSL Configuration Generator](https://ssl-config.mozilla.org/)
- [SSL Labs Test](https://www.ssllabs.com/ssltest/)
- [Tutorial certificati autofirmati](https://www.digitalocean.com/community/tutorials/how-to-create-a-self-signed-ssl-certificate-for-apache-in-ubuntu-20-04)
- [Protocolli TLS](https://en.wikipedia.org/wiki/Transport_Layer_Security)
- [HTTP/2 con HTTPS](https://httpd.apache.org/docs/current/rewrite/remapping.html#redirect-http-to-https)

### SSH e GitHub
- [Documentazione SSH](https://www.ssh.com/academy/ssh)
- [Guida GitHub SSH](https://docs.github.com/it/authentication/connecting-to-github-with-ssh)
- [Generazione chiavi SSH](https://docs.github.com/it/authentication/connecting-to-github-with-ssh/generating-a-new-ssh-key-and-adding-it-to-the-ssh-agent)
- [Git Workflow](https://www.atlassian.com/git/tutorials/comparing-workflows)
- [Git Best Practices](https://sethrobertson.github.io/GitBestPractices/)
- [GitHub Flow](https://docs.github.com/en/get-started/quickstart/github-flow)
- [Tutorial SSH su Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-set-up-ssh-keys-on-ubuntu-20-04)
- [Sicurezza delle chiavi SSH](https://www.ssh.com/academy/ssh/keygen)
- [GitHub CLI](https://cli.github.com/manual/)
- [Video: SSH in 100 Secondi](https://www.youtube.com/watch?v=v45p_kJV9i4)

### Troubleshooting
- [Risoluzione problemi WSL](https://learn.microsoft.com/it-it/windows/wsl/troubleshooting)
- [Log Apache](https://httpd.apache.org/docs/2.4/logs.html)
- [Log MySQL](https://dev.mysql.com/doc/refman/8.0/en/server-logs.html)
- [Debug PHP](https://www.php.net/manual/it/debugger.php)
- [Diagnostica problemi Virtual Host Apache](https://httpd.apache.org/docs/2.4/vhosts/examples.html)
- [Risoluzione errori Laravel](https://laravel.com/docs/12.x/errors)
- [Modalità debug e manutenzione Laravel](https://laravel.com/docs/12.x/configuration#debug-mode)
- [Troubleshooting WSL Networking](https://learn.microsoft.com/en-us/windows/wsl/troubleshooting#networking-issues)
- [Common MySQL Errors](https://dev.mysql.com/doc/mysql-errors/8.0/en/server-error-reference.html)
- [How to Debug PHP Errors](https://www.sitepoint.com/debug-php-errors/)

### Struttura Progetti il progetto
- [Documentazione il progetto](/var/www/html/<nome progetto>/docs)
- [Convenzioni Laravel](https://laravel.com/docs/12.x/contributions#coding-style)
- [Best Practices](https://laravel.com/docs/12.x/best-practices)
- [PSR-12 Coding Standards](https://www.php-fig.org/psr/psr-12/)
- [Laravel Modules Documentation](https://nwidart.com/laravel-modules/v6/introduction)
- [Module-based Architecture](https://dev.to/armino/structure-organization-of-a-large-laravel-application-46l6)
- [Filament PHP Documentation](https://filamentphp.com/docs)
- [Laravel Filament Cookbook](https://filamentphp.com/cookbook)
- [Laravel Directory Structure](https://laravel.com/docs/12.x/structure)
- [Riferimenti struttura cartelle il progetto](/var/www/html/<nome progetto>/docs/standards/directory_structure.md)

### Strumenti di Sviluppo
- [Visual Studio Code](https://code.visualstudio.com/docs)
- [Git](https://git-scm.com/doc)
- [Composer](https://getcomposer.org/doc/)
- [Docker](https://docs.docker.com/) (opzionale per sviluppo avanzato)

### Sicurezza
- [Best Practices MySQL](https://dev.mysql.com/doc/refman/8.0/en/security-best-practices.html)
- [Sicurezza Apache](https://httpd.apache.org/docs/2.4/misc/security_tips.html)
- [Sicurezza PHP](https://www.php.net/manual/it/security.php)
- [Sicurezza SSH](https://www.ssh.com/academy/ssh/security)

### Performance
- [Ottimizzazione MySQL](https://dev.mysql.com/doc/refman/8.0/en/optimization.html)
- [Ottimizzazione Apache](https://httpd.apache.org/docs/2.4/misc/perf-tuning.html)
- [Ottimizzazione PHP](https://www.php.net/manual/it/performance.php)
- [Ottimizzazione Laravel](https://laravel.com/docs/12.x/deployment#optimization)

### Community e Supporto
- [Forum Laravel](https://laravel.io/forum)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel)
- [GitHub Issues](https://github.com/laravel/laravel/issues)
- [Discord Laravel](https://discord.gg/laravel)
