# Filosofia dei Componenti Riutilizzabili

**Modulo**: Geo
**Status**: 📚 **DOCUMENTAZIONE**

## Principio Fondamentale

I componenti riutilizzabili devono risiedere nel modulo che ne definisce la **logica centrale**, non nei moduli che li utilizzano.

### Logica della Filosofia

1. **Single Source of Truth** - Il modulo Geo è la fonte della verità per tutto ciò che riguarda gli indirizzi
2. **DRY Principle** - Un solo componente, utilizzabile da tutti i moduli
3. **Separazione delle Responsabilità** - Geo gestisce la logica, TechPlanner la usa
4. **Manutenibilità Centralizzata** - Modifiche in un solo posto

## Esempio Concreto: AddressColumn

### ❌ Approccio Errato (Prima)
```
Modules/TechPlanner/Filament/Tables/Columns/AddressColumn.php
```
- Violazione del principio DRY
- Duplicazione del codice
- Manutenzione distribuita

### ✅ Approccio Corretto (Dopo)
```
Modules/Geo/Filament/Tables/Columns/AddressColumn.php
```
- Single source of truth
- Riutilizzabile da tutti i moduli
- Manutenzione centralizzata

## Utilizzo in Altri Moduli

```php
// In TechPlanner/ListClients.php
use Modules\Geo\Filament\Tables\Columns\AddressColumn;

// La colonna è disponibile per tutti
AddressColumn::make('address')
```

## Politica di Organizzazione

### Componenti nel Modulo Geo
- **AddressColumn** - Visualizzazione indirizzi
- **AddressItemEnum** - Definizione campi indirizzo
- **Geocoding Actions** - Logica geocodifica
- **Coordinate Utilities** - Gestione coordinate
- **UpdateCoordinatesBulkAction** - BulkAction riutilizzabile per aggiornamento coordinate
- **UpdateCoordinatesFromAddressAction** - Action Spatie per business logic geocoding
- **UpdateCoordinatesBulkAction** - BulkAction riutilizzabile per aggiornamento coordinate
- **UpdateCoordinatesFromAddressAction** - Action Spatie per business logic geocoding

### Componenti nel Modulo Notify
- **ContactColumn** - Visualizzazione contatti
- **ContactTypeEnum** - Definizione campi contatto
- **Notification Actions** - Logica notifiche

### Componenti nel Modulo TechPlanner
- **Business Logic** - Logica specifica del business
- **Domain Models** - Modelli specifici del dominio
- **Business Rules** - Regole di business

## Religione dell'Architettura

1. **Ogni modulo ha la sua responsabilità** - Non mischiare logiche di dominio diversi
2. **I componenti riutilizzabili vivono nel modulo della loro logica** - Non dove vengono usati
3. **La dipendenza è chiara e esplicita** - `use Modules\Geo\...` è una dichiarazione di dipendenza

## Zen della Struttura

> "Il componente non è dove viene creato, ma dove la sua anima risiede."

L'AddressColumn risiede in Geo perché la sua anima è la logica degli indirizzi, anche se viene manifestato in TechPlanner.

## Pattern da Seguire

### Quando creare un componente in un modulo:
1. **Definisce logica del dominio** del modulo
2. **È riutilizzabile** da altri moduli
3. **Centralizza funzionalità** altrimenti duplicate

### Quando usare un componente da altro modulo:
1. **Hai bisogno della logica** definita altrove
2. **Non vuoi duplicare** il codice
3. **Vuoi beneficiare** degli aggiornamenti del modulo originale

## Vantaggi

1. **Manutenzione Semplificata** - Un punto di modifica
2. **Consistenza Garantita** - Stesso comportamento ovunque
3. **Dipendenze Chiare** - Sa cosa usi da chi
4. **Test Centralizzati** - Test una volta, usa ovunque

## Best Practices

1. **Documenta sempre** i componenti riutilizzabili
2. **Usa namespace chiari** che indicano l'origine
3. **Non creare dipendenze cicliche**
4. **Pensa alla riutilizzabilità** fin dall'inizio

## Conclusione

Seguendo questa filosofia, manteniamo un'architettura pulita, manutenibile e scalabile dove ogni modulo ha le sue responsabilità chiare e i componenti riutilizzabili sono centralizzati dove la loro logica appartiene.
