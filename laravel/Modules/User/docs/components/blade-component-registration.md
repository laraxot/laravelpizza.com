# Registrazione dei componenti Blade

> **NOTA IMPORTANTE**: Questo documento è un riferimento specifico per il modulo User.
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/docs/components/blade-component-registration.md).
> La documentazione principale e completa si trova nel [modulo UI](../../../UI/project_docs/components/blade-component-registration.md).
## Automatic Blade Component Registration
In moduli che estendono `XotBaseServiceProvider`, **non è necessario** registrare manualmente i componenti Blade con `Blade::component()` o `Blade::componentNamespace()`.
Il provider base si occupa automaticamente di scansionare la directory `Modules/User/View/Components` e di esporre i componenti con il prefisso `user` e lo schema dash-case.
### Usage
Utilizzare direttamente i componenti nei template:
```blade
<x-user-profile-dropdown />
<x-user-profile-dropdown-link href="{{ route('profile.show') }}" />
```
### Convenzioni di naming
- **Cartella**: `Modules/User/View/Components/Profile/Dropdown.php`
- **Tag**: `user-profile-dropdown`
- Seguire sempre il formato dash-case e il prefisso del modulo
### Soluzione consigliata
### 5. Evitare notazione punto per i nomi dei componenti Blade
- **MAI** utilizzare la notazione punto per i componenti (es. `profile.dropdown`)
- **USARE** sempre trattini e prefisso modulo (es. `user-profile-dropdown`)
```php
// ORA corretto
<x-user-profile-dropdown>...</x-user-profile-dropdown>
<x-user-profile-dropdown-link href="{{ route('profile.show') }}">...</x-user-profile-dropdown-link>
### 6. Aggiornare i template
- Cercare tutte le occorrenze di `<x-profile.dropdown>` e `<x-profile.dropdown-link>` e sostituirle con la nuova convenzione.
**Collegamenti aggiuntivi**:
- [UI Module Blade Components Registration](../../../UI/docs/components/blade-component-registration.md)
- [UI Module Blade Components Registration](../../../UI/project_docs/components/blade-component-registration.md)
- [Regole LangServiceProvider](../langserviceprovider-labels.md)
