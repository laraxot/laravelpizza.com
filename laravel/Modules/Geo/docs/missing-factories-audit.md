# Factory Mancanti - Modulo Geo

## Situazione Critica Identificata

**Data audit**: 2025-01-06  
**Gravità**: CRITICA - 8 factory mancanti su 11 models

## Models senza Factory

### 1. AddressFactory.php
- **Model**: Address.php
- **Scopo**: Indirizzi geografici completi
- **Priorità**: CRITICA - Usato in tutto il sistema

### 2. CountyFactory.php  
- **Model**: County.php
- **Scopo**: Contee/Province geografiche
- **Priorità**: ALTA

### 3. GeoNamesCapFactory.php
- **Model**: GeoNamesCap.php  
- **Scopo**: Codici postali GeoNames
- **Priorità**: ALTA

### 4. LocalityFactory.php
- **Model**: Locality.php
- **Scopo**: Località geografiche
- **Priorità**: MEDIA

### 5. LocationFactory.php
- **Model**: Location.php
- **Scopo**: Posizioni geografiche generiche
- **Priorità**: ALTA

### 6. PlaceFactory.php
- **Model**: Place.php
- **Scopo**: Luoghi geografici
- **Priorità**: ALTA

### 7. PlaceTypeFactory.php
- **Model**: PlaceType.php
- **Scopo**: Tipologie di luoghi
- **Priorità**: MEDIA

### 8. StateFactory.php
- **Model**: State.php
- **Scopo**: Stati/Regioni geografiche  
- **Priorità**: ALTA

## Factory Esistenti ✅

- ComuneFactory.php ✅
- ProvinceFactory.php ✅  
- RegionFactory.php ✅

## Impatto Critico

### Moduli Dipendenti Compromessi
- **<main module>**: Address per studi medici
- **User**: Address per profili utenti
- **Cms**: Location per contenuti geografici
- **Tutti i form**: Selezione geografica rotta

### Test Impossibili
- Form geografici non testabili
- Seeding geografico fallimentare
- Demo data incomplete

### Sviluppo Bloccato
- Impossibile testare funzionalità geografiche
- Sviluppo locale compromesso
- CI/CD fallimentare per test geografici

## Struttura Geografica Italiana

### Gerarchia Corretta
1. **Region** (Regione) ✅ Factory presente
2. **Province** (Provincia) ✅ Factory presente  
3. **Comune** (Comune) ✅ Factory presente
4. **Address** (Indirizzo) ❌ MANCA
5. **Place** (Luogo) ❌ MANCA
6. **Location** (Posizione) ❌ MANCA

## Azioni Richieste IMMEDIATE

1. **AddressFactory** - PRIORITÀ MASSIMA
2. **PlaceFactory** - PRIORITÀ MASSIMA
3. **LocationFactory** - PRIORITÀ ALTA
4. **StateFactory** - PRIORITÀ ALTA
5. **CountyFactory** - PRIORITÀ MEDIA
6. **GeoNamesCapFactory** - PRIORITÀ MEDIA
7. **LocalityFactory** - PRIORITÀ MEDIA
8. **PlaceTypeFactory** - PRIORITÀ MEDIA

## Checklist Correzione

### Priorità CRITICA
- [ ] AddressFactory.php
- [ ] PlaceFactory.php
- [ ] LocationFactory.php

### Priorità ALTA  
- [ ] StateFactory.php
- [ ] CountyFactory.php
- [ ] GeoNamesCapFactory.php

### Priorità MEDIA
- [ ] LocalityFactory.php
- [ ] PlaceTypeFactory.php

## Relazioni tra Models

### Address (CRITICO)
```php
// Relazioni principali
- belongsTo: Region, Province, Comune
- morphTo: Addressable (User, Studio, etc.)
```

### Place (CRITICO)
```php  
// Relazioni principali
- belongsTo: PlaceType, Address
- morphTo: Placeable
```

### Location (ALTA)
```php
// Relazioni principali  
- belongsTo: Address, Place
- hasMany: Locations (nested)
```

## Note Implementazione

### Dati Realistici Italiani
- Usare nomi città italiane reali
- CAP italiani validi (00100-99999)
- Coordinate GPS Italia
- Province/Regioni esistenti

### Integrazione Sushi
- Alcuni modelli usano Laravel Sushi
- Factory devono essere compatibili
- Dati JSON potrebbero essere coinvolti

## Collegamenti

- [README Modulo Geo](./README.md)
- [Factory Audit Root](../../../docs/factory-audit-2025.md)
- [Address Implementation](./address-implementation.md)
- [Sushi Implementation](./sushi-implementation.md)

---
**Errore gravissimo da non ripetere mai più**  
*Ultimo aggiornamento: 2025-01-06*
