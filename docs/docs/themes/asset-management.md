# Gestione degli Asset

## Struttura delle Directory

```
public_html/
└── assets/
    └── [module_name]/
        └── [asset_type]/
            └── [files]

bashscripts/
└── verify_assets.sh    # Script di verifica asset
```

## Permessi e Proprietari

1. **Proprietario**: www-data
2. **Gruppo**: www-data
3. **Permessi**: 775 per le directory, 664 per i file

## Best Practices

1. **Verifica dei Permessi**:
   ```bash
   sudo chown -R www-data:www-data /path/to/public_html
   sudo chmod -R 775 /path/to/public_html
   ```

2. **Controlli Preventivi**:
   - Verificare l'esistenza della directory di destinazione
   - Controllare i permessi prima della copia
   - Implementare try-catch per gestire gli errori
   - Utilizzare lo script di verifica in `bashscripts/verify_assets.sh`

3. **Gestione degli Errori**:
   ```php
   try {
       // Operazione di copia
   } catch (\Exception $e) {
       // Log dell'errore
       // Notifica all'amministratore
       // Fallback a asset di default
   }
   ```

## Automazione

Gli script di automazione si trovano nella directory `bashscripts/`:
1. `verify_assets.sh` - Verifica e corregge la struttura degli asset
2. Altri script di gestione asset

## Monitoraggio

- Implementare un sistema di logging per gli errori di asset
- Creare alert per problemi di permessi
- Monitorare lo spazio disponibile
- Verificare periodicamente l'integrità degli asset
- Utilizzare lo script di verifica prima di ogni deploy
# Gestione degli Asset

## Struttura delle Directory

```
public_html/
└── assets/
    └── [module_name]/
        └── [asset_type]/
            └── [files]

bashscripts/
└── verify_assets.sh    # Script di verifica asset
```

## Permessi e Proprietari

1. **Proprietario**: www-data
2. **Gruppo**: www-data
3. **Permessi**: 775 per le directory, 664 per i file

## Best Practices

1. **Verifica dei Permessi**:
   ```bash
   sudo chown -R www-data:www-data /path/to/public_html
   sudo chmod -R 775 /path/to/public_html
   ```

2. **Controlli Preventivi**:
   - Verificare l'esistenza della directory di destinazione
   - Controllare i permessi prima della copia
   - Implementare try-catch per gestire gli errori
   - Utilizzare lo script di verifica in `bashscripts/verify_assets.sh`

3. **Gestione degli Errori**:
   ```php
   try {
       // Operazione di copia
   } catch (\Exception $e) {
       // Log dell'errore
       // Notifica all'amministratore
       // Fallback a asset di default
   }
   ```

## Automazione

Gli script di automazione si trovano nella directory `bashscripts/`:
1. `verify_assets.sh` - Verifica e corregge la struttura degli asset
2. Altri script di gestione asset

## Monitoraggio

- Implementare un sistema di logging per gli errori di asset
- Creare alert per problemi di permessi
- Monitorare lo spazio disponibile
- Verificare periodicamente l'integrità degli asset
- Utilizzare lo script di verifica prima di ogni deploy
