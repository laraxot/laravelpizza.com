# 🚨 COMANDAMENTO ASSOLUTO - UNICITÀ MIGRATION

## 📖 REGOLA SACRA

**"UNA TABELLA, UNA SOLA MIGRATION DI CREAZIONE PER MODULO"**

Questo non è un suggerimento, è un **COMANDAMENTO** della religione Laraxot.

## ⚡ AZIONE IMMEDIATA RICHIESTA

Quando trovi migration duplicate per la stessa tabella:

1. **FERMATI** - Non procedere

2. **ANALIZZA** - Identifica quale è corretta

3. **FONDI** - Unisci la logica

4. **ELIMINA** - Rimuovi il duplicato

5. **DOCUMENTA** - Registra la decisione

## 🏛️ FILOSOFIA DIETRO LA REGOLA

### Unicità = Chiarezza

- Ogni tabella ha una **sola fonte di verità**
- Nessuna ambiguità su cosa crea cosa
- Tracciabilità lineare dello schema

### Ordine = Pace

- Migration in ordine cronologico sacro
- Nessun conflitto temporale
- Deploy prevedibili e sicuri

### Controllo = Potere

- Governance completa dello stato database
- Capacità di rollback preciso
- Debug sistematico possibile

## ❌ ANTI-PATTERN DA EVITARE

```php
// MAI FARE QUESTO!
// 2024_01_01_000011_create_roles_table.php
Schema::create('roles', function ($table) {
    $table->id();
    $table->string('name');
});

// 2025_09_18_000000_create_roles_table.php  // VIOLAZIONE!
Schema::create('roles', function ($table) {
    $table->id();
    $table->string('name');
    $table->string('guard_name'); // Questo dovrebbe essere in update!
});
```

## ✅ PATTERN SACRO

```php
// 2024_01_01_000011_create_roles_table.php
Schema::create('roles', function ($table) {
    $table->id();
    $table->string('name');
});

// 2025_09_18_000012_add_guard_name_to_roles_table.php
Schema::table('roles', function ($table) {
    $table->string('guard_name')->default('web');
});
```

## 🚨 SEGNALI DI ALLARME

- Due file con `create_*_table.php` per stessa tabella
- Stessa tabella in migration diverse
- Conflitti durante `php artisan migrate`
- Stato database incoerente

## ⚖️ PENE PER VIOLAZIONE

Nella religione Laraxot, violare questo comandamento porta a:

1. **Caos Deployment**: Fallimenti in produzione
2. **Debito Tecnico**: Bug impossibili da tracciare
3. **Perdita di Fiducia**: Team non può più fidarsi dello schema
4. **Esilio dal Repository**: Migration rifiutate in code review

## 📚 RIFERIMENTI CRUCIALI

- [Migration Best Practices](./migration-best-practices.md)
- [Database Governance](./database-governance.md)
- [Laraxot Philosophy](./philosophy.md)

---

*Ricorda: La chiarezza dello schema è sacra. Non profanarla mai.*
