
-----------------------------------------------------------------------------------
https://github.com/cheesegrits/filament-google-maps
star:204
updated:4 months ago
----------------------------------------------------------------------------------
https://github.com/Traineratwot/filament-openstreetmap
star:14
updated: 2 weeks ago
----------------------------------------------------------------------------------
https://github.com/humaidem/filament-map-picker
star:32
updated: 8 months ago
----------------------------------------------------------------------------------
https://github.com/webbingbrasil/filament-maps
star:53
updated: 3 months ago
----------------------------------------------------------------------------------
https://github.com/dotswan/filament-map-picker
star:28
updated: 2 days ago
----------------------------------------------------------------------------------
https://github.com/arbermustafa/filament-locationpickr-field
star: 11
updated: 7 months ago
----------------------------------------------------------------------------------


https://packagist.org/packages/tanthammar/filament-extras

https://github.com/tanthammar/filament-extras/blob/main/src/Forms/AddressFields.php


https://github.com/Lecturize/Laravel-Addresses/blob/master/src/Models/Address.php


https://laraveldaily.com/code-examples/example/laravel-filament-filamentadmin-com/map

https://laraveldaily.com/post/laravel-get-latitude-longitude-from-address-geocoder


https://dev.to/bradisrad83/browser-location-with-laravel-livewire-54bd



<script>
 function getLocation() {
   if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(showPosition);
   } else {
     console.log("Geolocation is not supported by this browser.");
   }
 }

function showPosition(position) {
  var Latitude = position.coords.latitude;
  var Longitude = position.coords.longitude;
}
</script>





https://polodev.github.io/tuts/2018/11/05/nearby-location-using-latitude-and-longitude-in-laravel-application-mysql-query-plus-vue-implementation/

https://github.com/geocoder-php/GeocoderLaravel

# Integrazione Filament nel Modulo Geo

## AddressResource: regole, filosofia e best practice

### Filosofia
- AddressResource è la risorsa centrale per la gestione CRUD degli indirizzi geografici.
- Segue la policy: **mai estendere direttamente le classi Filament**, ma sempre XotBaseResource e XotBasePage.
- Tutti i form e le tabelle devono usare solo chiavi di traduzione, mai label inline.
- La relazione polimorfica (model_type/model_id) va gestita in modo trasparente e neutro.
- La UI deve essere neutra, riusabile, multi-tenant e pronta per ogni contesto (utente, studio, azienda, ecc.).

### Naming e struttura
- Resource: `AddressResource`
- Namespace: `Modules\Geo\Filament\Resources`
- Pagine: `ListAddresses`, `CreateAddress`, `EditAddress`, `ViewAddress` in `Modules\Geo\Filament\Resources\AddressResource\Pages`
- Traduzioni: `lang/it/address-resource.php`
- Widget: solo se necessario, in `AddressResource/Widgets`

### Best practice
- Usare sempre array associativi con chiavi stringa per form/table.
- I form devono coprire tutti i campi principali di Address (vedi address-implementation.md).
- Per la selezione della posizione, integrare un map picker (vedi link in testa a questo file).
- La relazione polimorfica va gestita come select dinamica o hidden, a seconda del contesto.
- I filtri devono permettere ricerca per città, provincia, regione, CAP, tipo, is_primary.
- Le azioni devono essere neutre e non legate a un solo contesto (es. non "Assegna a utente" ma "Assegna a modello").
- Le colonne della tabella devono essere leggibili e ordinabili.
- Le viste devono essere responsive e accessibili.
- **Quando un modulo (es. StudioResource) gestisce indirizzi, usare sempre**:
  ```php
  'addresses' => Forms\Components\Repeater::make('addresses')
      ->relationship('addresses')
      ->schema(Modules\Geo\Filament\Resources\AddressResource::getFormSchema())
  ```
- Aggiornare sempre la documentazione e i collegamenti relativi.

### Esempio di struttura

```
Modules/Geo/app/Filament/Resources/
├── AddressResource.php
└── AddressResource/
    └── Pages/
        ├── ListAddresses.php
        ├── CreateAddress.php
        ├── EditAddress.php
        └── ViewAddress.php
```

### Mapping campi principali
- name, description, type, is_primary
- route, street_number, locality, province, region, country, postal_code
- latitude, longitude, formatted_address, place_id
- extra_data (solo in advanced)

### Traduzioni
- Tutte le label, placeholder, help, ecc. vanno in `lang/it/address-resource.php`
- Le chiavi devono essere coerenti con la struttura del form/table

### Integrazione Map Picker
- Usare un map picker compatibile Filament (vedi link in testa a questo file)
- Il campo lat/lng deve essere aggiornato in tempo reale
- Il map picker deve essere opzionale e non obbligatorio

### Gestione relazioni polimorfiche
- Se Address è creato da una risorsa polimorfica, i campi model_type/model_id vanno gestiti come hidden o precompilati
- Se Address è gestito standalone, permettere la selezione del modello associato (solo per admin)

### UI/UX
- Le viste devono essere semplici, chiare, accessibili
- I campi principali devono essere sempre visibili
- I campi avanzati (extra_data, place_id) possono essere in una sezione collapsible
- Le azioni devono essere chiare e neutre

### Collegamenti
- [address-implementation.md](./address-implementation.md)
- [Xot/docs/filament/README.md](../../Xot/docs/filament/README.md)
- [place-address-schemaorg.md](./place-address-schemaorg.md)

### TODO
- Implementare AddressResource e relative pagine secondo questa policy
- Aggiornare la documentazione ogni volta che si aggiunge un campo o una feature

## Perché i collegamenti sono sempre relativi?

- **Logica**: I link relativi garantiscono portabilità, versionamento e refactoring sicuro della documentazione.
- **Politica**: Ogni modulo è autonomo e la sua documentazione deve essere navigabile anche se spostata o estratta.
- **Filosofia**: Un solo punto di verità, nessun path assoluto, nessun lock-in.
- **Religione**: "Non avrai altro path all'infuori del relativo".
- **Zen**: Serenità nella navigazione, nessun errore di path, nessun link rotto dopo un refactor.

