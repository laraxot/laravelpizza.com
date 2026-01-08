# Proposta: Implementazione di Laravel Passport in un Filament Cluster

## Riepilogo

Attualmente, le risorse OAuth di Laravel Passport sono gestite separatamente come risorse individuali (`OauthClientResource`, `OauthAccessTokenResource`, ecc.). Questo documento propone di organizzare tutte le risorse OAuth in un cluster dedicato chiamato `Passport` per una migliore organizzazione e usabilità.

## Attuale Struttura

Le risorse OAuth sono attualmente distribuite come:

- `OauthClientResource`
- `OauthAccessTokenResource`
- `OauthAuthCodeResource`
- `OauthPersonalAccessClientResource`
- `OauthRefreshTokenResource`
- `ClientResource`

## Proposta

### 1. Creare un Cluster Passport

```php
// Modules/User/app/Filament/Clusters/Passport.php
<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters;

use Modules\Xot\Filament\Clusters\XotBaseCluster;

class Passport extends XotBaseCluster
{
    protected static ?string $navigationGroup = 'API';

    protected static ?string $navigationIcon = 'heroicon-o-key';
}
```

### 2. Spostare le risorse esistenti nel cluster

Spostare le seguenti risorse nel cluster Passport:

- `OauthClientResource` → Diventa una pagina del cluster
- `OauthAccessTokenResource` → Diventa una pagina del cluster
- `OauthAuthCodeResource` → Diventa una pagina del cluster
- `OauthPersonalAccessClientResource` → Diventa una pagina del cluster
- `OauthRefreshTokenResource` → Diventa una pagina del cluster
- `ClientResource` → Diventa una pagina del cluster

### 3. Estendere le risorse per il cluster

```php
// Nelle risorse OAuth, aggiungere:
protected static ?string $cluster = \Modules\User\Filament\Clusters\Passport::class;
```

## Vantaggi

1. **Organizzazione migliore**: Tutte le risorse OAuth in un unico posto
2. **Usabilità**: Interfaccia più pulita e organizzata
3. **Manutenibilità**: Più facile trovare e gestire le risorse OAuth
4. **Conformità Laravel**: Segue le best practices di Laravel Filament

## Schema.org: Campi e Modelli Proposti

### 1. Estensione del modello User

Basato sulla documentazione schema.org per [Person](https://schema.org/Person), si potrebbero aggiungere i seguenti campi al modello User:

```php
// Campo aggiuntivo nel modello User
'job_title'        // Schema: jobTitle
'works_for'        // Schema: worksFor
'address'          // Schema: address (già presente in relazione)
'birth_date'       // Schema: birthDate
'family_name'      // Schema: familyName (già coperto da last_name)
'given_name'       // Schema: givenName (già coperto da first_name)
'gender'           // Schema: gender
'nationality'      // Schema: nationality
'knows_language'   // Schema: knowsLanguage
```

### 2. Nuovo modello Organization

Basato su [Organization](https://schema.org/Organization), si potrebbe creare un nuovo modello:

```php
// Modules/Geo/Models/Organization.php
class Organization extends BaseModel
{
    // name, legalName, description, address, telephone, email, url
    // employees (relazione con User)
    // departments (relazioni con altre entità)
}
```

### 3. Estensione del modello Address

Già implementato parzialmente, si potrebbe espandere ulteriormente con campi come:

```php
// Campo aggiuntivo in Address
'address_country_code'  // Per codice ISO del paese
'po_box_number'        // Schema: postOfficeBoxNumber
'area_served'          // Schema: areaServed
'geo'                  // Schema: geo (coordinate più dettagliate)
```

### 4. Nuovo modello Place

Basato su [Place](https://schema.org/Place), si potrebbe estendere il modello Location:

```php
// Estensione del modello Location
public function toSchemaOrg(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Place',
        'name' => $this->name,
        'description' => $this->description,
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => $this->lat,
            'longitude' => $this->lng,
        ],
        'address' => $this->formatted_address,
        'telephone' => $this->phone_number ?? null,
        'openingHours' => $this->opening_hours ?? null,
    ];
}
```

## Conclusione

L'implementazione di un cluster Passport migliorerebbe significativamente l'organizzazione dell'interfaccia admin per tutto ciò che riguarda l'autenticazione OAuth. Allo stesso tempo, l'estensione dei modelli con campi ispirati a schema.org aumenterebbe la conformità semantica del sistema e la sua interoperabilità con altri sistemi.