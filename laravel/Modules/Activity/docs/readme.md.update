# Aggiornamento README Activity - Sezione Testing

## Sezione da Aggiungere

### Testing Best Practices

Il modulo Activity segue la strategia testing documentata in `Modules/Xot/docs/testing-strategy.md`.

#### Policy: NO RefreshDatabase

**🔴 VIETATO l'uso di `RefreshDatabase` trait nei test.**

**Motivazioni**:
1. Database multi-connection (activity, notify, user, etc.)
2. Event Sourcing richiede persistenza eventi
3. Real-world fidelity con MySQL production
4. Manual cleanup per controllo granulare

**Pattern Corretto**:
```php
test('snapshot test', function () {
    $snapshot = Snapshot::create([
        'aggregate_uuid' => Str::uuid()->toString(),
        'aggregate_version' => 1,
        'state' => json_encode(['data' => 'value']),
    ]);
    
    // ... test logic ...
    
    // ✅ Cleanup manuale
    $snapshot->delete();
});
```

**Documentazione**:
- [No RefreshDatabase Policy](./testing/no-refresh-database-policy.md)
- [Snapshot Testing Patterns](./testing/snapshot-testing-patterns.md)
- [Xot Testing Strategy](../../Xot/docs/testing-strategy.md)

#### Test Coverage

✅ **SnapshotBusinessLogicTest**: 10+ test scenari
- Creazione snapshot base e complessi
- Versioning e chronology
- Query by UUID e version
- State management (empty, null, complex)
- Date range filtering
- Metadata handling

✅ **ActivityBusinessLogicTest**: 15+ test scenari Event Sourcing

#### Esecuzione Test

```bash
cd /var/www/html/ptvx/laravel

# Test modulo Activity
php artisan test Modules/Activity

# Test specifici Snapshot
php artisan test --filter=Snapshot

# Con coverage
php artisan test Modules/Activity --coverage
```

