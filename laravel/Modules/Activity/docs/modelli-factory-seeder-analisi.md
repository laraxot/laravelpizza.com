# Analisi Modelli, Factory e Seeder - Moduli Activity, Gdpr, Tenant, UI, <nome progetto>, Xot

## Modulo Activity

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Activity** | ✅ ActivityFactory | ✅ ActivityDatabaseSeeder | Core - Log attività sistema |
| **Snapshot** | ✅ SnapshotFactory | ❌ | Core - Snapshot stati |
| **StoredEvent** | ✅ StoredEventFactory | ❌ | Core - Eventi archiviati |
| **BaseModel** | ❌ | ❌ | Abstract |
| **BaseActivity** | ❌ | ❌ | Abstract |
| **BaseSnapshot** | ❌ | ❌ | Abstract |
| **BaseStoredEvent** | ❌ | ❌ | Abstract |

### Modelli Obsoleti
- **BaseActivity.php.no** - 🗑️ File backup da rimuovere

### Seeder Mancanti
1. **SnapshotSeeder** - Per snapshot esempio
2. **StoredEventSeeder** - Per eventi archiviati

---

## Modulo Gdpr

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Consent** | ✅ ConsentFactory | ✅ GdprDatabaseSeeder | Core - Consensi GDPR |
| **Event** | ✅ EventFactory | ❌ | Core - Eventi privacy |
| **Profile** | ✅ ProfileFactory | ❌ | Core - Profili privacy |
| **Treatment** | ✅ TreatmentFactory | ❌ | Core - Trattamenti dati |
| **BaseModel** | ❌ | ❌ | Abstract |
| **BasePivot** | ❌ | ❌ | Abstract |
| **BaseMorphPivot** | ❌ | ❌ | Abstract |

### Seeder Mancanti
1. **EventSeeder** - Per eventi privacy
2. **ProfileSeeder** - Per profili privacy
3. **TreatmentSeeder** - Per trattamenti dati

---

## Modulo Tenant

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Domain** | ✅ DomainFactory | ✅ TenantDatabaseSeeder | Core - Domini tenant |
| **BaseModel** | ❌ | ❌ | Abstract |
| **BaseModelJsons** | ❌ | ❌ | Abstract |

### Modelli Obsoleti
- **tenant.php.no** - 🗑️ File disabilitato
- **Tenant.php.no** - 🗑️ File disabilitato

### Seeder Mancanti
Nessuno - Modulo minimale con solo Domain

---

## Modulo UI

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| Nessun modello presente | - | - | Modulo solo componenti UI |

### Note
Il modulo UI contiene solo componenti Blade e risorse frontend, nessun modello Eloquent.

---

## Modulo <nome progetto>

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseModel** | ❌ | ❌ | Abstract |
| **BasePivot** | ❌ | ❌ | Abstract |

### Modelli Obsoleti
- **Patient.php.old** - 🗑️ Paziente specifico Modena (obsoleto)

### Factory Obsolete
- **PatientFactory.php.old** - 🗑️ Da rimuovere

### Seeder Obsoleti
- **PatientSeeder.php.old** - 🗑️ Da rimuovere
- **<nome progetto>DatabaseSeeder.php** - ✅ Mantiene struttura

### Note
Modulo specifico per Modena, attualmente non utilizzato attivamente.

---

## Modulo Xot

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Cache** | ✅ CacheFactory | ✅ XotDatabaseSeeder | System - Cache sistema |
| **CacheLock** | ✅ CacheLockFactory | ❌ | System - Lock cache |
| **Extra** | ✅ ExtraFactory | ❌ | System - Metadati extra |
| **Feed** | ✅ FeedFactory | ❌ | System - Feed RSS |
| **HealthCheckResultHistoryItem** | ✅ HealthCheckResultHistoryItemFactory | ❌ | System - Health check |
| **InformationSchemaTable** | ✅ InformationSchemaTableFactory | ❌ | System - Schema DB |
| **Log** | ✅ LogFactory | ❌ | System - Log sistema |
| **Module** | ✅ ModuleFactory | ❌ | System - Moduli |
| **PulseAggregate** | ✅ PulseAggregateFactory | ❌ | System - Metriche Pulse |
| **PulseEntry** | ✅ PulseEntryFactory | ❌ | System - Entry Pulse |
| **PulseValue** | ✅ PulseValueFactory | ❌ | System - Valori Pulse |
| **Session** | ✅ SessionFactory | ❌ | System - Sessioni |

### Modelli Base
- **BaseModel** - Abstract base
- **XotBaseModel** - Abstract base Xot
- **XotBaseUuidModel** - Abstract base UUID
- **BaseComment** - Abstract commenti
- **BaseExtra** - Abstract metadati
- **BaseMorphPivot** - Abstract pivot
- **BaseRating** - Abstract rating
- **BaseRatingMorph** - Abstract rating morph
- **BaseTreeModel** - Abstract tree

### Seeder Mancanti
1. **CacheLockSeeder** - Per lock cache
2. **ExtraSeeder** - Per metadati
3. **FeedSeeder** - Per feed RSS
4. **HealthCheckSeeder** - Per health check
5. **LogSeeder** - Per log sistema
6. **ModuleSeeder** - Per moduli
7. **PulseSeeder** - Per metriche Pulse
8. **SessionSeeder** - Per sessioni

---

## Riepilogo Generale

### Totale Modelli Analizzati
- ****: 20 modelli attivi, 7 obsoleti
- **User**: 35+ modelli attivi
- **Geo**: 12 modelli attivi, 1 obsoleto
- **Media**: 4 modelli attivi
- **Notify**: 10 modelli attivi, 4 file backup
- **Job**: 15 modelli attivi, 2 disabilitati
- **Lang**: 6 modelli, 2 file backup
- **Cms**: 9 modelli
- **Activity**: 6 modelli, 1 backup
- **Gdpr**: 7 modelli
- **Tenant**: 3 modelli, 2 obsoleti
- **UI**: 0 modelli (solo componenti)
- **<nome progetto>**: 2 modelli base, 1 obsoleto
- **Xot**: 12+ modelli sistema, molti base abstract

### Factory Coverage
- **✅ Completa**: Tutti i modelli attivi hanno factory
- **❌ Mancanti**: Nessuna factory mancante per modelli concreti

### Seeder Coverage
- **✅ Parziale**: Molti seeder principali presenti
- **❌ Mancanti**: ~50 seeder da creare per copertura completa

### Azioni Prioritarie
1. **Pulizia file obsoleti**: ~15 file .old, .no, .up, .fixed da rimuovere
2. **Creazione seeder mancanti**: ~50 seeder da implementare
3. **Validazione PHPStan**: Tutti i file factory livello 9
4. **Documentazione**: Aggiornare documentazione moduli

### Moduli Critici per Business Logic
1. **** - Core sanitario ✅ Completo
2. **User** - Autenticazione ✅ Completo
3. **Notify** - Comunicazioni ✅ Completo
4. **Media** - File management ✅ Completo
5. **Geo** - Localizzazione ✅ Completo

### Moduli di Supporto
1. **Job** - Processing asincrono ✅ Completo
2. **Lang** - Traduzioni ✅ Completo
3. **Cms** - Contenuti ✅ Completo
4. **Activity** - Audit trail ✅ Completo
5. **Gdpr** - Compliance privacy ✅ Completo
6. **Xot** - Framework base ✅ Completo

*Analisi completa sistema : 150+ modelli, 14 moduli*
# Analisi Modelli, Factory e Seeder - Moduli Activity, Gdpr, Tenant, UI, <nome progetto>, Xot

## Modulo Activity

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Activity** | ✅ ActivityFactory | ✅ ActivityDatabaseSeeder | Core - Log attività sistema |
| **Snapshot** | ✅ SnapshotFactory | ❌ | Core - Snapshot stati |
| **StoredEvent** | ✅ StoredEventFactory | ❌ | Core - Eventi archiviati |
| **BaseModel** | ❌ | ❌ | Abstract |
| **BaseActivity** | ❌ | ❌ | Abstract |
| **BaseSnapshot** | ❌ | ❌ | Abstract |
| **BaseStoredEvent** | ❌ | ❌ | Abstract |

### Modelli Obsoleti
- **BaseActivity.php.no** - 🗑️ File backup da rimuovere

### Seeder Mancanti
1. **SnapshotSeeder** - Per snapshot esempio
2. **StoredEventSeeder** - Per eventi archiviati

---

## Modulo Gdpr

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Consent** | ✅ ConsentFactory | ✅ GdprDatabaseSeeder | Core - Consensi GDPR |
| **Event** | ✅ EventFactory | ❌ | Core - Eventi privacy |
| **Profile** | ✅ ProfileFactory | ❌ | Core - Profili privacy |
| **Treatment** | ✅ TreatmentFactory | ❌ | Core - Trattamenti dati |
| **BaseModel** | ❌ | ❌ | Abstract |
| **BasePivot** | ❌ | ❌ | Abstract |
| **BaseMorphPivot** | ❌ | ❌ | Abstract |

### Seeder Mancanti
1. **EventSeeder** - Per eventi privacy
2. **ProfileSeeder** - Per profili privacy
3. **TreatmentSeeder** - Per trattamenti dati

---

## Modulo Tenant

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Domain** | ✅ DomainFactory | ✅ TenantDatabaseSeeder | Core - Domini tenant |
| **BaseModel** | ❌ | ❌ | Abstract |
| **BaseModelJsons** | ❌ | ❌ | Abstract |

### Modelli Obsoleti
- **tenant.php.no** - 🗑️ File disabilitato
- **Tenant.php.no** - 🗑️ File disabilitato

### Seeder Mancanti
Nessuno - Modulo minimale con solo Domain

---

## Modulo UI

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| Nessun modello presente | - | - | Modulo solo componenti UI |

### Note
Il modulo UI contiene solo componenti Blade e risorse frontend, nessun modello Eloquent.

---

## Modulo <nome progetto>

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **BaseModel** | ❌ | ❌ | Abstract |
| **BasePivot** | ❌ | ❌ | Abstract |

### Modelli Obsoleti
- **Patient.php.old** - 🗑️ Paziente specifico Modena (obsoleto)

### Factory Obsolete
- **PatientFactory.php.old** - 🗑️ Da rimuovere

### Seeder Obsoleti
- **PatientSeeder.php.old** - 🗑️ Da rimuovere
- **<nome progetto>DatabaseSeeder.php** - ✅ Mantiene struttura

### Note
Modulo specifico per Modena, attualmente non utilizzato attivamente.

---

## Modulo Xot

### Modelli Attivi e Business Logic
| Modello | Factory | Seeder | Utilizzo Business Logic |
|---------|---------|---------|------------------------|
| **Cache** | ✅ CacheFactory | ✅ XotDatabaseSeeder | System - Cache sistema |
| **CacheLock** | ✅ CacheLockFactory | ❌ | System - Lock cache |
| **Extra** | ✅ ExtraFactory | ❌ | System - Metadati extra |
| **Feed** | ✅ FeedFactory | ❌ | System - Feed RSS |
| **HealthCheckResultHistoryItem** | ✅ HealthCheckResultHistoryItemFactory | ❌ | System - Health check |
| **InformationSchemaTable** | ✅ InformationSchemaTableFactory | ❌ | System - Schema DB |
| **Log** | ✅ LogFactory | ❌ | System - Log sistema |
| **Module** | ✅ ModuleFactory | ❌ | System - Moduli |
| **PulseAggregate** | ✅ PulseAggregateFactory | ❌ | System - Metriche Pulse |
| **PulseEntry** | ✅ PulseEntryFactory | ❌ | System - Entry Pulse |
| **PulseValue** | ✅ PulseValueFactory | ❌ | System - Valori Pulse |
| **Session** | ✅ SessionFactory | ❌ | System - Sessioni |

### Modelli Base
- **BaseModel** - Abstract base
- **XotBaseModel** - Abstract base Xot
- **XotBaseUuidModel** - Abstract base UUID
- **BaseComment** - Abstract commenti
- **BaseExtra** - Abstract metadati
- **BaseMorphPivot** - Abstract pivot
- **BaseRating** - Abstract rating
- **BaseRatingMorph** - Abstract rating morph
- **BaseTreeModel** - Abstract tree

### Seeder Mancanti
1. **CacheLockSeeder** - Per lock cache
2. **ExtraSeeder** - Per metadati
3. **FeedSeeder** - Per feed RSS
4. **HealthCheckSeeder** - Per health check
5. **LogSeeder** - Per log sistema
6. **ModuleSeeder** - Per moduli
7. **PulseSeeder** - Per metriche Pulse
8. **SessionSeeder** - Per sessioni

---

## Riepilogo Generale

### Totale Modelli Analizzati
- **<nome progetto>**: 20 modelli attivi, 7 obsoleti
- **User**: 35+ modelli attivi
- **Geo**: 12 modelli attivi, 1 obsoleto
- **Media**: 4 modelli attivi
- **Notify**: 10 modelli attivi, 4 file backup
- **Job**: 15 modelli attivi, 2 disabilitati
- **Lang**: 6 modelli, 2 file backup
- **Cms**: 9 modelli
- **Activity**: 6 modelli, 1 backup
- **Gdpr**: 7 modelli
- **Tenant**: 3 modelli, 2 obsoleti
- **UI**: 0 modelli (solo componenti)
- **<nome progetto>**: 2 modelli base, 1 obsoleto
- **Xot**: 12+ modelli sistema, molti base abstract

### Factory Coverage
- **✅ Completa**: Tutti i modelli attivi hanno factory
- **❌ Mancanti**: Nessuna factory mancante per modelli concreti

### Seeder Coverage
- **✅ Parziale**: Molti seeder principali presenti
- **❌ Mancanti**: ~50 seeder da creare per copertura completa

### Azioni Prioritarie
1. **Pulizia file obsoleti**: ~15 file .old, .no, .up, .fixed da rimuovere
2. **Creazione seeder mancanti**: ~50 seeder da implementare
3. **Validazione PHPStan**: Tutti i file factory livello 9
4. **Documentazione**: Aggiornare documentazione moduli

### Moduli Critici per Business Logic
1. **<nome progetto>** - Core sanitario ✅ Completo
2. **User** - Autenticazione ✅ Completo
3. **Notify** - Comunicazioni ✅ Completo
4. **Media** - File management ✅ Completo
5. **Geo** - Localizzazione ✅ Completo

### Moduli di Supporto
1. **Job** - Processing asincrono ✅ Completo
2. **Lang** - Traduzioni ✅ Completo
3. **Cms** - Contenuti ✅ Completo
4. **Activity** - Audit trail ✅ Completo
5. **Gdpr** - Compliance privacy ✅ Completo
6. **Xot** - Framework base ✅ Completo

*Analisi completa sistema <nome progetto>: 150+ modelli, 14 moduli*
