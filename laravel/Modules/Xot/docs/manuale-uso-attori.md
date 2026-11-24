# Manuale d'uso per attori — Xot

## Scopo e perimetro

Xot è la base infrastrutturale condivisa: contratti utente, policy comuni,
provider e base dei pannelli Filament, discovery di risorse/pagine/widget,
navigazione, impostazioni tecniche e supporto opzionale alla tenancy. Non è
un'area business né un'area personale per gli utenti finali.

## Attori e capacità effettive

| Attore | Capacità nel modulo Xot |
|---|---|
| Ospite | N/A per funzioni infrastrutturali riservate. Può incontrare il chrome o la resa di un pannello pubblico, ma Xot non gli attribuisce capacità di dominio. |
| Utente autenticato | N/A come operatore Xot. Usa indirettamente login, middleware e pannelli forniti dalle basi Xot, se il modulo applicativo lo abilita. |
| Utente in gruppo/ruolo | N/A: Xot non trasforma membership o ruolo applicativo in permessi di business. |
| Admin | N/A come ruolo globale. Il ruolo `<modulo>::admin` viene interpretato dalle policy del modulo proprietario, non da Xot come amministrazione universale. |
| Operatore/moderatore | N/A: Xot non definisce CRUD o moderazione per questi ruoli. Le policy del modulo concreto decidono le operazioni. |
| Super-admin | Supera il `before()` di `XotBasePolicy` e può accedere alle pagine infrastrutturali esplicitamente protette dal tratto `SuperAdminOnlyTrait`, come impostazioni, ambiente, salute e gestione comandi, quando registrate nel pannello. |

## Flussi operativi

### Accesso ai pannelli

`XotBasePanelProvider` fornisce la base comune per login, reset password,
middleware di autenticazione, discovery di risorse/pagine/widget e tenancy
opzionale. L'accesso effettivo al pannello è poi deciso dal modello User e dal
ruolo richiesto dal pannello; Xot non apre automaticamente tutte le aree.

### Autorizzazione delle risorse

`XotBasePolicy` concede il bypass al super-admin e, quando la policy concreta lo
ricava dal namespace, al ruolo `<modulo>::admin`. Il default `viewAny()` è
negato. Le abilità Filament non dichiarate, incluse operazioni come delete
massivo, restore, reorder e attach/detach, sono negate dal trait comune; una
policy concreta deve dichiararle per concederle. Eventuali permessi operativi
restano responsabilità del modulo proprietario.

### Impostazioni infrastrutturali

Le pagine base di ambiente, salute, comandi e impostazioni usano una protezione
esplicita super-admin. Non sono funzioni destinate all'ospite, all'utente
ordinario o al moderatore.

## Prerequisiti

- autenticazione e ruolo ammesso dal pannello;
- policy concreta del modulo risorsa, con abilità dichiarate;
- registrazione/discovery del pannello e dei componenti applicativi;
- super-admin per le pagine protette con `SuperAdminOnlyTrait`.

## Limiti e casi N/A

- Xot non assegna ruoli né permessi e non sostituisce le policy applicative.
- Il bypass `<modulo>::admin` vale solo quando la policy concreta estende il
  comportamento comune e ricava quel ruolo.
- Un ruolo di ingresso al pannello non implica automaticamente delete, restore,
  reorder, attach o detach.
- La tenancy è opzionale e deve essere configurata dal pannello; non è una
  garanzia globale dell'applicazione.

## Fonti verificabili

- `app/Models/Policies/XotBasePolicy.php` — bypass, ruolo modulo-admin e
  default `viewAny()` negato.
- `app/Models/Policies/Concerns/DeniesUndeclaredFilamentAbilities.php` —
  abilità Filament non dichiarate negate.
- `app/Models/Policies/Concerns/RequiresOperationalPermissions.php` —
  distinzione tra ingresso al pannello e permessi operativi.
- `app/Filament/Traits/SuperAdminOnlyTrait.php` e
  `app/Filament/Pages/BaseSettingPage.php` — pagine riservate.
- `app/Providers/Filament/XotBasePanelProvider.php` — basi dei pannelli e
  tenancy opzionale.
- `app/Actions/Filament/GetModulesNavigationItems.php` — filtraggio della
  navigazione per ruolo modulo.
- `app/Contracts/UserContract.php` — contratto comune per autenticazione,
  ruoli e tenant.
