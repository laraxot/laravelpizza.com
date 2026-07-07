# 📁 Database Directory Naming Best Practices

**Discussion ID**: #1  
**Created**: 2026-03-13  
**Author**: @marco76tv  
**Status**: ✅ Active

---

Ciao a tutti! 👋

Ho appena creato una nuova convention document per standardizzare il naming delle directory del database in tutti i moduli Laravel.

## 🎯 Obiettivo

Assicurarsi che tutti i moduli seguano la convenzione Laravel standard:

✅ **CORRETTO**:
```
database/factories/
database/migrations/
database/seeders/
```

❌ **SBAGLIATO**:
```
database/Factories/
database/Migrations/
database/Seeders/
```

## 📚 Documentazione

Ho creato questi documenti:

1. **[Database Naming Convention](docs/conventions/database-naming.md)** - Guida completa
2. **[AGENTS.md Update](AGENTS.md)** - Rule aggiunta alle regole architetturali
3. **[GitHub Issue #5](https://github.com/laraxot/base_fixcity_fila5/issues/5)** - Tracking delle correzioni

## 🔍 Perché è Importante

1. **Laravel Convention**: Laravel usa snake_case per le directory
2. **PSR-4**: I namespace possono essere PascalCase, ma i path devono essere minuscoli
3. **Case Sensitivity**: Linux è case-sensitive, Windows/macOS no
4. **Consistency**: Migliore leggibilità e manutenzione

## 📋 Stato Attuale

### Moduli Verificati
- ✅ Blog - Documentazione corretta

### Da Verificare
- [ ] Activity
- [ ] AI
- [ ] Cms
- [ ] Comment
- [ ] Fixcity
- [ ] Gdpr
- [ ] Geo
- [ ] Job
- [ ] Lang
- [ ] Media
- [ ] Notify
- [ ] Rating
- [ ] Seo
- [ ] Tenant
- [ ] UI
- [ ] User
- [ ] Xot

## 🛠️ Come Contribuire

Se trovi riferimenti errati:

1. **Cerca** con grep:
   ```bash
   grep -r "database/Factories" docs/
   grep -r "database/Migrations" docs/
   grep -r "database/Seeders" docs/
   ```

2. **Correggi** la documentazione

3. **Verifica** le directory fisiche:
   ```bash
   find laravel/Modules -type d -name "Factories"
   find laravel/Modules -type d -name "Migrations"
   find laravel/Modules -type d -name "Seeders"
   ```

4. **Rinomina** se necessario:
   ```bash
   mv database/Factories database/factories
   ```

5. **Aggiorna** composer.json se necessario

## 💬 Domande?

Se avete domande o dubbi su questa convention, parliamone qui! 👇

## 📖 References

- [Laravel Directory Structure](https://laravel.com/docs/structure)
- [Laravel Factories](https://laravel.com/docs/eloquent-factories)
- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Laravel Seeders](https://laravel.com/docs/seeding)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)

---

**Maintainer**: @marco76tv  
**Created**: 2026-03-13
