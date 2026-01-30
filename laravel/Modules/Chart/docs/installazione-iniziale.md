# Installazione Iniziale di il progetto

# Installazione Iniziale

> **Nota**: Questo documento è correlato a [Configurazione Server](/bashscripts/docs/server_setup.md). Per una panoramica completa, consulta entrambi i documenti.

## Prerequisiti

- PHP 8.2 o superiore
- Composer
- Node.js e npm
- Git
- MySQL 8.0 o superiore

## Comandi di Installazione Iniziale

1. Installare Laravel Installer globalmente
```bash
composer global require laravel/installer -W
```

2. Creare un nuovo progetto Laravel
```bash
laravel new <nome progetto>
cd <nome progetto>
```

3. Installare le dipendenze PHP
```bash
composer install
```

4. Installare le dipendenze JavaScript
```bash
npm install
```

5. Copiare il file di configurazione
```bash
cp .env.example .env
```

6. Generare la chiave dell'applicazione
```bash
php artisan key:generate
```

7. Configurare il database nel file .env
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<nome progetto>
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

8. **IMPORTANTE**: Rimuovere le migrazioni centrali
```bash
rm -rf database/migrations
```

9. Eseguire le migrazioni
```bash
php artisan migrate
```

10. Compilare gli assets
```bash
npm run dev
```

11. Avviare il server di sviluppo
```bash
php artisan serve
```

## Note Importanti

### Perché Laravel Installer?
- Fornisce un modo standardizzato per creare nuovi progetti Laravel
- Configura automaticamente la struttura base del progetto
- Imposta le dipendenze iniziali corrette
- Crea la struttura di directory standard

### Perché rimuovere database/migrations?
- Tutte le migrazioni nel nostro progetto sono contenute nei moduli
- Evita conflitti con le migrazioni centrali
- Mantiene una struttura pulita e organizzata
- Permette una gestione indipendente delle migrazioni per modulo

## Prossimi Passi

Dopo l'installazione iniziale, consultare:
- [Gestione Migrazioni](migrazione-struttura.md) per la gestione delle migrazioni nei moduli
- [Installazione Moduli](installazione.md) per l'aggiunta dei moduli necessari
- [Configurazione](configurazione.md) per le impostazioni specifiche del progetto 

## Collegamenti tra versioni di installazione-iniziale.md
* [installazione-iniziale.md](docs/installazione-iniziale.md)
* [installazione-iniziale.md](docs/tecnico/installazione-iniziale.md)
* [installazione-iniziale.md](laravel/Modules/Xot/docs/implementation/installazione-iniziale.md)

