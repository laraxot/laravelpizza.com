# Modulo User

## Informazioni Generali
- **Nome**: `laraxot/module_user_fila3`
- **Descrizione**: Modulo per la gestione degli utenti
- **Namespace**: `Modules\User`
- **Repository**: https://github.com/laraxot/module_user_fila3

## Service Providers
1. `Livewire\LivewireServiceProvider`
2. `Modules\User\Providers\UserServiceProvider`
3. `Modules\User\Providers\Filament\AdminPanelProvider`

## Struttura
```
app/
### Versione HEAD

├── Filament/           # Componenti Filament
│   ├── Pages/         # Pagine Filament
│   ├── Resources/     # Risorse Filament
│   └── Widgets/       # Widget Filament (es. RegistrationWidget)
├── Http/              # Controllers e Middleware
├── Models/            # Modelli del dominio
├── Providers/         # Service Providers
└── Services/          # Servizi utente

### Versione Incoming

├── Filament/       # Componenti Filament
├── Http/           # Controllers e Middleware
├── Models/         # Modelli del dominio
├── Providers/      # Service Providers
└── Services/       # Servizi utente

---

```

## Dipendenze
### Pacchetti Required
- `flowframe/laravel-trend`
- `jenssegers/agent`
- `laravel/passport`
- `socialiteproviders/auth0`
- `spatie/laravel-personal-data-export`

### Moduli Required
- Xot
- Tenant
- UI

## Database
### Factories
Namespace: `Modules\User\Database\Factories`

### Seeders
Namespace: `Modules\User\Database\Seeders`

## Testing
Comandi disponibili:
```bash
composer test           # Esegue i test
composer test-coverage  # Genera report di copertura
composer analyse       # Analisi statica del codice
composer format        # Formatta il codice
```

## Funzionalità
- Gestione utenti e profili
- Autenticazione OAuth
- Esportazione dati personali
- Integrazione con Auth0
- Analisi trend utenti
- Rilevamento dispositivi

## Configurazione
### OAuth
- Configurazione in `config/services.php`
- Chiavi richieste in `.env`:
  ```
  PASSPORT_PERSONAL_ACCESS_CLIENT_ID=
  PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=
  AUTH0_DOMAIN=
  AUTH0_CLIENT_ID=
  AUTH0_CLIENT_SECRET=
  ```
### Versione HEAD

- Per dettagli completi sull'integrazione di Laravel Passport, vedere [documentazione dedicata](./passport.md)

### Versione Incoming


---


## Best Practices
1. Seguire le convenzioni di naming Laravel
2. Documentare tutte le classi e i metodi pubblici
3. Mantenere la copertura dei test
4. Utilizzare il type hinting
5. Seguire i principi SOLID
6. Implementare validazione input
7. Gestire correttamente le password
8. Proteggere i dati sensibili

### Versione HEAD

### Filament
1. Tutti i componenti Filament devono essere nella directory `app/Filament`
2. I widget devono essere nella directory `app/Filament/Widgets`
3. Utilizzare i namespace corretti per i componenti
4. Seguire le convenzioni di naming di Filament
5. Documentare i componenti con PHPDoc
6. Utilizzare i trait e le interfacce appropriate
7. Gestire correttamente gli stati dei form
8. Implementare la validazione dei dati


### Versione Incoming


---

## Troubleshooting
### Problemi Comuni
1. **Errori di Autenticazione**
   - Verificare configurazione OAuth
   - Controllare le chiavi in `.env`
   - Verificare i redirect URI

2. **Problemi di Esportazione Dati**
   - Controllare i permessi di scrittura
   - Verificare la configurazione delle code
   - Controllare lo spazio disco

### Versione HEAD

3. **Problemi con i Widget Filament**
   - Verificare il namespace corretto
   - Controllare la posizione del file nella struttura
   - Verificare l'implementazione delle interfacce richieste
   - Controllare la configurazione del form

## Changelog
Le modifiche vengono tracciate nel repository GitHub. 

### Versione Incoming

## Changelog
Le modifiche vengono tracciate nel repository GitHub. 

---

