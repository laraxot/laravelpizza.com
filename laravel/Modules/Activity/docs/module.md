# Modulo Activity - Logging e Event Sourcing

## Scopo Principale

Il modulo **Activity** fornisce un sistema completo di **activity logging e event sourcing** per il monolite Laraxot. Traccia tutte le operazioni significative del sistema con storage ottimizzato e capacità di auditing.

## Funzionalità Implementate

### ✅ Core Logging System
1. **Spatie ActivityLog Integration**
   - Logging automatico delle operazioni CRUD
   - Configurazione per哪些 modelli tracciare
   - Custom activity descriptions
   - Causalità e relazioni eventi

2. **Event Sourcing Pattern**
   - Spatie Event Sourcing integration
   - Stored events reconstruction
   - Snapshot management
   - Event replay capabilities

3. **Activity Dashboard**
   - Filament admin panel per gestione log
   - Filtri avanzati per ricerca attività
   - Export capabilities (CSV, PDF)
   - Timeline visualization

### ✅ Advanced Features
1. **Multi-Tenant Support**
   - Isolamento log per tenant
   - Cross-tenant activity tracking
   - Tenant-specific reporting

2. **Performance Optimization**
   - Efficient query patterns
   - Batch processing capabilities
   - Memory-conscious logging
   - Async event processing

## Architettura del Sistema

### Component Architecture
```
Activity Module Stack:
├── Logging Layer
│   ├── ActivityLogger (Spatie)
│   ├── CustomLoggers
│   └── EventSourcing (Spatie)
├── Storage Layer
│   ├── Activity Table
│   ├── Event Store
│   └── Snapshot Store
├── Admin Layer
│   ├── ActivityResource
│   ├── ActivityFilters
│   └── ExportActions
└── Analytics Layer
    ├── ActivityAggregator
    ├── TimelineBuilder
    └── ReportGenerator
```

### Data Flow
```
User Action → Event → ActivityLogger → Database → Dashboard → Analytics
     ↓
Event Store ← Snapshot ← Aggregate ← Event Sourcing
```

## Componenti Principali

### Core Services
- `ActivityLoggingService` - Centralized logging
- `EventSourcingService` - Event management
- `ActivityFilterService` - Filter operations
- `TimelineService` - Timeline construction

### Models
- `Activity` - Extended Spatie Activity model
- `ActivityEvent` - Custom event model
- `ActivityTimeline` - Timeline aggregation
- `ActivityAggregation` - Precomputed analytics

### Filament Integration
- `ActivityResource` - Admin interface
- `ActivityList` - Activity listing
- `ActivityFilters` - Advanced filtering
- `ActivityExport` - Export functionality

### Event Sourcing
- `AggregateRoot` - Base aggregate
- `StoredEvent` - Event wrapper
- `Snapshot` - State snapshots
- `EventReplayer` - Reconstruction logic

## Configurazione e Setup

### Logging Configuration
```php
// config/activity.php
'loggers' => [
    'default' => SpatieActivityLogger::class,
    'audit' => AuditLogger::class,
    'performance' => PerformanceLogger::class,
],

'tracked_models' => [
    'user' => ['created', 'updated', 'deleted'],
    'survey' => ['created', 'activated', 'deactivated'],
    'response' => ['created', 'updated'],
],
```

### Event Sourcing Setup
```php
// Event store configuration
'event_store' => [
    'driver' => 'mysql',
    'table' => 'stored_events',
    'snapshots' => [
        'interval' => 100, // events per snapshot
        'table' => 'snapshots',
    ],
],
```

## Dipendenze e Integration

### Dependencies Esterne
- `spatie/laravel-activitylog: *` - Activity logging
- `spatie/laravel-event-sourcing: *` - Event sourcing

### Inter-Modulo Dependencies
- **User**: Activity的主体 (user actions)
- **Limesurvey**: Survey lifecycle tracking
- **Tenant**: Multi-tenancy isolation
<<<<<<< .merge_file_Pm80fk
- **healthcare_app**: Dashboard activity tracking
=======
- **ModuloEsempio**: Dashboard activity tracking
>>>>>>> .merge_file_Va7dgg

## Lacune e Funzionalità Mancanti

### 🔴 CRITICHE (Priorità Alta)
1. **Advanced Analytics Engine**
   - Missing: Activity pattern detection
   - Missing: Anomaly detection
   - No predictive analytics
   - Missing behavior analysis

2. **Real-time Monitoring**
   - No WebSocket support for live activity
   - Missing alert system for anomalies
   - No real-time dashboard updates
   - Missing notification system

3. **Compliance & Governance**
   - Missing GDPR compliance tools
   - No data retention policies
   - Missing audit trail certification
   - No legal hold functionality

### 🟡 ALTE (Priorità Media)
1. **Advanced Filtering & Search**
   - Limited filter complexity
   - Missing full-text search
   - No saved filter templates
   - Missing date range presets

2. **Report Generation**
   - Basic export capabilities only
   - Missing scheduled reports
   - No custom report templates
   - Limited visualization options

3. **Integration APIs**
   - Missing external system sync
   - No webhook support
   - Missing REST API for activity data
   - No integration with external SIEM

### 🟢 MEDIE (Priorità Bassa)
1. **Machine Learning Features**
   - No automated categorization
   - Missing smart tagging
   - No sentiment analysis
   - Missing clustering algorithms

2. **Collaboration Features**
   - No shared activity views
   - Missing team analytics
   - No annotation system
   - Missing collaborative filtering

## Performance Analysis

### Current Optimizations
✅ Implemented:
- Efficient indexing strategy
- Batch processing for bulk operations
- Memory-conscious event storage
- Query optimization for dashboard

### Identificati Bottlenecks
❌ Issues:
- Large table scans in timeline queries
- Missing partitioning for historical data
- Synchronous event processing
- Limited caching for aggregations

### Raccomandazioni Performance
1. **Event Streaming**: Kafka/RabbitMQ integration
2. **Data Archiving**: Automatic old data archival
3. **Caching Strategy**: Redis for frequent queries
4. **Async Processing**: Queue-based event handling

## Security Considerations

### Data Protection
- Immutable audit trail
- Encrypted sensitive activity data
- Access control per tenant
- Tamper-evident logging

### Compliance Requirements
- GDPR right to explanation
- Data portability exports
- Retention policy enforcement
- Legal hold capabilities

## Use Cases Comuni

### 1. User Activity Tracking
```php
// Tracciamento automatico
activity()->performedOn($user)
    ->causedBy($admin)
    ->withProperties(['action' => 'login', 'ip' => $request->ip()])
    ->log('user_login');
```

### 2. Survey Lifecycle Monitoring
```php
// Event sourcing per survey
$survey->recordThat(new SurveyCreated($survey->id, $user->id));
$survey->recordThat(new SurveyActivated($survey->id, $user->id));
```

### 3. Performance Analytics
```php
// Logging performance metriche
$timer = microtime(true);
// ... operation ...
activity()->withProperties([
    'operation' => 'report_generation',
    'duration' => microtime(true) - $timer,
    'memory' => memory_get_usage(),
])->log('performance_metric');
```

## Roadmap Sviluppo

### Fase 1: Analytics Foundation (2-3 settimane)
- [ ] Advanced pattern detection
- [ ] Anomaly detection algorithms
- [ ] Real-time monitoring dashboard
- [ ] Alert system implementation

### Fase 2: Compliance & Security (2-3 settimane)
- [ ] GDPR compliance tools
- [ ] Data retention policies
- [ ] Legal hold functionality
- [ ] Audit trail certification

### Fase 3: Advanced Features (3-4 settimane)
- [ ] Machine learning categorization
- [ ] Predictive analytics
- [ ] Advanced filtering system
- [ ] Custom report builder

### Fase 4: Enterprise Features (3-4 settimane)
- [ ] External system integrations
- [ ] Webhook support
- [ ] API for external access
- [ ] Advanced collaboration tools

## Best Practices

### Development Guidelines
1. **Event Design**: Keep events small and focused
2. **Immutability**: Never modify stored events
3. **Versioning**: Event schema evolution
4. **Testing**: Event replay unit testing

### Operational Guidelines
1. **Monitoring**: System performance metrics
2. **Archiving**: Regular data archival
3. **Backups**: Event store backup strategy
4. **Recovery**: Disaster recovery procedures

### Security Guidelines
1. **Access Control**: Principle of least privilege
2. **Encryption**: Sensitive data protection
3. **Audit Trail**: Complete operation traceability
4. **Compliance**: Regular compliance audits

## Collegamenti Documentation

### Internal Links
- `../User/docs/` - User activity tracking
- `../Limesurvey/docs/` - Survey lifecycle
- `../Tenant/docs/` - Multi-tenancy patterns
- `./event-sourcing-patterns.md` - Advanced patterns

### External References
- [Spatie ActivityLog](https://github.com/spatie/laravel-activitylog)
- [Spatie Event Sourcing](https://github.com/spatie/laravel-event-sourcing)
- [Event Sourcing Pattern](https://martinfowler.com/eaaDev/EventSourcing.html)

---

**Versione**: v2.5.0-beta  
**Stato**: Production Ready with Compliance Enhancement