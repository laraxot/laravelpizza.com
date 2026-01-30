# Integrazione Moduli Laraxot

## Moduli Necessari

il progetto si basa su diversi moduli Laraxot che forniscono funzionalità di base essenziali:

1. **Xot** - Modulo core con utility e configurazioni base
   - Repository: `git@github.com:laraxot/module_xot_fila3.git`
   - Branch: `dev`
   - Dipendenze: Nessuna
   - Funzionalità: Classi base, helper, configurazioni comuni

2. **Lang** - Gestione multilingua
   - Repository: `git@github.com:laraxot/module_lang_fila3.git`
   - Branch: `dev`
   - Dipendenze: Xot
   - Funzionalità: Traduzioni, localizzazione

3. **Tenant** - Gestione multi-tenant
   - Repository: `git@github.com:laraxot/module_tenant_fila3.git`
   - Branch: `dev`
   - Dipendenze: Xot
   - Funzionalità: Isolamento dati, gestione tenant

4. **User** - Gestione utenti e autenticazione
   - Repository: `git@github.com:laraxot/module_user_fila3.git`
   - Branch: `dev`
   - Dipendenze: Xot, Tenant
   - Funzionalità: Autenticazione, ruoli, permessi

## Procedura di Integrazione

L'integrazione avviene tramite git subtree, che consente di incorporare repository esterni come subdirectory del nostro progetto, mantenendo la cronologia dei commit.

```bash

# 1. Modulo Xot (deve essere il primo per le dipendenze)
git subtree add --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash

# 2. Modulo Lang (dipende da Xot)
git subtree add --prefix laravel/Modules/Lang git@github.com:laraxot/module_lang_fila3.git dev --squash

# 3. Modulo Tenant (dipende da Xot)
git subtree add --prefix laravel/Modules/Tenant git@github.com:laraxot/module_tenant_fila3.git dev --squash

# 4. Modulo User (dipende da Xot e Tenant)
git subtree add --prefix laravel/Modules/User git@github.com:laraxot/module_user_fila3.git dev --squash
```

L'ordine è importante per rispettare le dipendenze tra i moduli.

## Verifica dell'Integrazione

Dopo l'integrazione, verifica che tutti i moduli siano stati importati correttamente:

```bash
ls -la laravel/Modules/
```

Successivamente, esegui:

```bash
cd laravel
composer update
```

Per installare tutte le dipendenze richieste dai moduli.

## Configurazione Post-Integrazione

Dopo l'integrazione, è necessario:

1. Aggiornare il file `.env` con le configurazioni specifiche per i moduli
2. Eseguire le migrazioni per creare le tabelle necessarie
3. Pubblicare gli asset e le configurazioni dei moduli

```bash
php artisan module:enable Xot Lang Tenant User
php artisan migrate
php artisan module:publish
```

## Aggiornamento dei Moduli

Per aggiornare i moduli in futuro, utilizzare:

```bash
git subtree pull --prefix laravel/Modules/Xot git@github.com:laraxot/module_xot_fila3.git dev --squash

# Ripetere per gli altri moduli
```

## Considerazioni su Performance e Manutenzione

1. **Cache delle configurazioni**: Utilizzare `php artisan config:cache` in produzione
2. **Ottimizzazione autoloader**: Eseguire `composer dump-autoload -o` 
3. **Monitoraggio dipendenze**: Verificare regolarmente eventuali conflitti di dipendenze tra moduli
