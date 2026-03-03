# Troubleshooting definitivo permessi file_put_contents su lang_service.php

## Sintesi della soluzione robusta

1. **Ownership ricorsivo**
   - Tutti i file e le sottodirectory di `Modules/Lang/lang` devono essere di proprietà `www-data:www-data`.
   - Comando:
     ```bash
     sudo chown -R www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang
     ```
2. **Permessi sicuri e coerenti**
   - Tutte le directory: `ug+rwx,o+rx` (775)
   - Tutti i file: `ug+rw,o+r-w` (664)
   - Comando:
     ```bash
     sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang -type d -exec chmod 775 {} +
     sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang -type f -exec chmod 664 {} +
     ```
3. **Motivazione**
   - Garantisce che Apache/PHP (utente www-data) possa sempre leggere/scrivere file lingua.
   - Evita rischi di sicurezza legati a permessi troppo aperti (no 777).
   - Soluzione idempotente: può essere rilanciata senza effetti collaterali.

## Script di manutenzione automatica
Salva come `fix_lang_permissions.sh` e lancia con sudo:
```bash
#!/bin/bash
sudo chown -R www-data:www-data /var/www/html/ptvx/laravel/Modules/Lang/lang
sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang -type d -exec chmod 775 {} +
sudo find /var/www/html/ptvx/laravel/Modules/Lang/lang -type f -exec chmod 664 {} +
echo "Permessi corretti su Modules/Lang/lang."
```

## Troubleshooting
- Se l’errore persiste, verificare che non ci siano ACL o mount di filesystem con restrizioni particolari.
- Verificare che SELinux/AppArmor non blocchino la scrittura.
- Log Apache/PHP possono fornire dettagli aggiuntivi.

## Collegamento rapido
Questa guida risolve in modo definitivo ogni errore di permessi su file lingua generati da script o runtime PHP.

---

**Ultimo aggiornamento: maggio 2025 – Windsurf/Laraxot standard**

[Link diretto dalla root docs](../../../docs/lang_service_permessi.md)
