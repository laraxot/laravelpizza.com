# ModelContactContract

## Descrizione
Questa interfaccia estende `ModelContract` aggiungendo funzionalità specifiche per i modelli che rappresentano contatti nel sistema Laraxot.

## Struttura
```php
interface ModelContactContract extends ModelContract
{
    public function getEmail(): ?string;
    public function getPhone(): ?string;
    public function getAddress(): ?string;
    public function getCity(): ?string;
    public function getCountry(): ?string;
    public function getZipCode(): ?string;
    public function getFullName(): string;
    public function getFirstName(): ?string;
    public function getLastName(): ?string;
}
```

## Funzionalità
1. Gestione delle informazioni di contatto
2. Supporto per:
   - Email
   - Telefono
   - Indirizzo completo
   - Dati anagrafici
3. Integrazione con:
   - Sistema di notifiche
   - Gestione utenti
   - CRM

## Implementazioni
- `Contact`: Modello base per i contatti
- `Customer`: Estensione per i clienti
- `Supplier`: Estensione per i fornitori
- Altri modelli specifici per i contatti

## Best Practices Implementate
1. Utilizzo di strict types
2. Documentazione PHPDoc completa
3. Supporto per PHPStan livello 9
4. Conforme alle convenzioni Laraxot/<nome progetto>
5. Gestione null-safety

## Collegamenti
- [Model Guidelines](../models/README.md)
- [Contact Management](../features/CONTACT-MANAGEMENT.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
- [Contracts Overview](./README.md) 