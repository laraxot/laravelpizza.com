# Analisi Modelli, Factory e Seeder - Modulo Geo

## Panoramica
Questo documento analizza tutti i modelli del modulo Geo verificando la presenza di factory e seeder corrispondenti, identificando modelli non utilizzati nella business logic principale.

## Modelli Attivi e Business Logic

### Modelli Core Geografici (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Region** | ✅ RegionFactory | ✅ GeoDatabaseSeeder | Core - Regioni italiane |
| **Province** | ✅ ProvinceFactory | ✅ GeoDatabaseSeeder | Core - Province italiane |
| **Comune** | ✅ ComuneFactory | ✅ GeoDatabaseSeeder | Core - Comuni italiani |
| **Location** | ✅ LocationFactory | ❌ | Core - Posizioni geografiche |
| **Address** | ✅ AddressFactory | ❌ | Core - Indirizzi strutturati |

### Modelli Supporto Geografico (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **State** | ✅ StateFactory | ❌ | Estero - Stati internazionali |
| **County** | ✅ CountyFactory | ❌ | Estero - Contee/distretti |
| **Locality** | ✅ LocalityFactory | ❌ | Dettaglio - Località specifiche |
| **Place** | ✅ PlaceFactory | ❌ | POI - Punti di interesse |
| **PlaceType** | ✅ PlaceTypeFactory | ❌ | POI - Tipologie luoghi |

### Modelli Specializzati (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **ComuneJson** | ❌ | ❌ | ReadOnly - Facade per comuni.json |
| **GeoJsonModel** | ❌ | ❌ | Abstract - Base per modelli JSON |

### Modelli Base (Utilizzati)
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseModel** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BasePivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |
| **BaseMorphPivot** | ❌ | ❌ | Abstract - Non necessita factory/seeder |

## Modelli Obsoleti/Non Utilizzati

### Modelli .old (Da Rimuovere)
| Modello | Stato | Motivazione |
|---------|-------|-------------|
| **GeoNamesCap.php.old** | 🗑️ Obsoleto | Sistema CAP alternativo non utilizzato |

### Factory Obsolete Corrispondenti
| Factory | Stato | Azione |
|---------|-------|---------|
| **GeoNamesCapFactory.php.old** | 🗑️ Obsoleto | Da rimuovere |

### Seeder Obsoleti
| Seeder | Stato | Azione |
|---------|-------|---------|
| **SushiSeeder.php.old** | 🗑️ Obsoleto | Approccio Sushi non utilizzato |

## Modelli Specializzati - Analisi Dettagliata

### ComuneJson - Modello Facade
**Utilizzo**: Fornisce interfaccia unificata ai dati geografici italiani
**Caratteristiche**:
- ReadOnly - Dati da file JSON statico
- Cache multilivello per performance
- Metodi di ricerca avanzati (regione, provincia, CAP, nome)
- Validazione dati geografici
- Non necessita factory/seeder (dati statici)

**Metodi Principali**:
- `all()` - Tutti i comuni
- `byRegion()` - Comuni per regione
- `byProvince()` - Comuni per provincia
- `searchByName()` - Ricerca per nome
- `byCap()` - Comuni per CAP
- `isValidCap()` - Validazione CAP
- `getGerarchia()` - Gerarchia completa comune

### GeoJsonModel - Classe Base
**Utilizzo**: Base astratta per modelli geografici da JSON
**Caratteristiche**:
- Caricamento dati da file JSON
- Sistema di cache integrato
- Pattern Facade per accesso unificato
- Non necessita factory/seeder (base astratta)

## Seeder Mancanti Necessari

### Seeder Core da Creare
1. **LocationSeeder** - Per posizioni geografiche base
2. **AddressSeeder** - Per indirizzi strutturati esempio
3. **StateSeeder** - Per stati internazionali principali
4. **PlaceSeeder** - Per punti di interesse comuni
5. **PlaceTypeSeeder** - Per tipologie luoghi standard

### Seeder Specializzati (Opzionali)
1. **CountySeeder** - Per contee internazionali (se necessario)
2. **LocalitySeeder** - Per località specifiche (se necessario)

## Factory Mancanti (Nessuna per Modelli Attivi)
Tutti i modelli attivi che necessitano factory le hanno.

## Raccomandazioni

### Azioni Immediate
1. **Rimuovere file .old**: Eliminare GeoNamesCap.php.old e factory correlata
2. **Rimuovere SushiSeeder.old**: Pulizia seeder obsoleti
3. **Creare seeder base**: LocationSeeder, AddressSeeder, StateSeeder
4. **Documentare ComuneJson**: Aggiornare documentazione modello Facade

### Azioni Future
1. **Ottimizzazione cache**: Migliorare sistema cache ComuneJson
2. **Estensione internazionale**: Valutare necessità dati geografici esteri
3. **Integrazione API**: Considerare integrazione con servizi geografici esterni
4. **Validazione dati**: Implementare validatori geografici completi

## Struttura Seeder Esistenti

### Seeder Principali
- **GeoDatabaseSeeder** - Seeder principale del modulo
- **GeoDataMigrator** - Migrazione dati geografici esistenti

### Dati Gestiti
- **Regioni**: 20 regioni italiane
- **Province**: 110+ province italiane  
- **Comuni**: 8000+ comuni italiani
- **CAP**: Sistema CAP completo
- **Codici ISTAT**: Codici identificativi ufficiali

## Note Tecniche

### Pattern Architetturali
- **Facade Pattern**: ComuneJson fornisce interfaccia unificata
- **Repository Pattern**: Accesso dati geografici centralizzato
- **Cache Strategy**: Sistema cache multilivello per performance
- **Static Data**: Dati geografici da file JSON statici

### Performance e Cache
- **Cache TTL**: 1 settimana per dati statici
- **Cache Keys**: Strutturate per regione/provincia/ricerca
- **Memory Optimization**: Caricamento lazy dei dati
- **Query Optimization**: Filtri e ricerche ottimizzate

### Integrazione Sistema
Il modulo Geo si integra con:
- **<main module>**: Indirizzi studi medici e pazienti
- **User**: Localizzazione utenti
- **Cms**: Contenuti geo-localizzati
- **Notify**: Notifiche geo-localizzate

### Validazione PHPStan
Tutti i file factory devono essere validati con PHPStan livello 9:
```bash
./vendor/bin/phpstan analyze Modules/Geo/database/factories --level=9
```

### Struttura Dati comuni.json
```json
{
  "nome": "Nome Comune",
  "codice": "Codice ISTAT",
  "regione": {
    "codice": "Codice Regione",
    "nome": "Nome Regione"
  },
  "provincia": {
    "codice": "Sigla Provincia",
    "nome": "Nome Provincia"
  },
  "cap": ["12345", "12346"],
  "codiceCatastale": "A123",
  "popolazione": 12345
}
```

## Collegamenti

### Documentazione Correlata
- [Geo JSON Model](./geo_json_model.md)
- [Comune Unificazione](./comune_unificazione_analisi.md)
- [Consolidamento Modelli](./consolidamento_modelli_geografici.md)
- [Cache Strategy](./cache_strategy.md)

### Moduli Collegati
- [<main module> Module](../../<main module>/docs/modelli_factory_seeder_analisi.md)
- [User Module](../../User/docs/modelli_factory_seeder_analisi.md)
- [Cms Module](../../Cms/docs/modelli_factory_seeder_analisi.md)

### Risorse Esterne
- [ISTAT Comuni](https://www.istat.it/it/archivio/6789)
- [Codici Postali](https://www.poste.it/cap.html)
- [OpenStreetMap](https://www.openstreetmap.org/)

*Ultimo aggiornamento: Gennaio 2025*
*Analisi completa di 12 modelli attivi, 1 modello obsoleto identificato*
*Sistema geografico completo per Italia con supporto internazionale*
