# ⚠️ CRITICAL: MAI FARE migrate:refresh/fresh/rollback O --force 🔴🔴

## I Dati Sono SACRI

**QUESTO È UN PROMEMORIA PERMANENTE PER TUTTI GLI AI AGENTI**

### ❌ MAI E POI MAI FARE

```bash
php artisan migrate:refresh    # CANCELLA I DATI
php artisan migrate:fresh      # CANCELLA I DATI
php artisan migrate:rollback   # CANCELLA I DATI
php artisan migrate --force    # PERICOLOSO IN PRODUZIONE
```

### ✅ SOLO FARE QUESTO

```bash
php artisan migrate                         # ✅ Preserva i dati
php artisan migrate --path=...              # ✅ Preserva i dati

# Produzione (con backup e maintenance)
php artisan down                            # Maintenance mode
mysqldump -u user -p db > backup.sql        # Backup
php artisan migrate --path=...              # Migration SENZA --force
php artisan up                              # Riattiva
```

## Perché

Le migration Laraxot sono **IDEMPOTENTI**:
- Usano `if (! $this->hasColumn())`
- Aggiungono solo ciò che manca
- **NON cancellano MAI i dati**

`migrate:refresh` esegue `down()` che **DISTRUGGE** la tabella e **CANCELLA** tutti i dati.

`migrate --force` **BYPASSA LA SICUREZZA** di produzione:
- Nessuna conferma richiesta
- Può eseguire migration distruttive
- **SOLO per CI/CD automatizzato**

## Conseguenze

Se esegui `migrate:refresh`:
1. **Perdi tutti i dati** nella tabella
2. **Violazione grave** delle regole del progetto
3. **Devi ripristinare** da backup

Se esegui `migrate --force` in produzione:
1. **Bypassi le protezioni** di Laravel
2. **Rischio corruzione** dati
3. **Possibile downtime** non pianificato

## Documentazione Completa

📖 `laravel/Modules/Activity/docs/errori/MAI_FARE_MIGRATE_REFRESH.md`

## Regole Correlate

<<<<<<< .merge_file_c84ABB
<<<<<<< .merge_file_SS3FA3
<<<<<<< .merge_file_TzeDVu
<<<<<<< .merge_file_3SnNmz
- [Forward-Only Philosophy](../claude/project-rules-summary.md)
- [QWEN.md](qwen.md) - Sezione 7: Database SACRO
=======
=======
>>>>>>> .merge_file_xNxe7s
=======
>>>>>>> .merge_file_vD0qXu
=======
>>>>>>> .merge_file_idqGDu
<<<<<<< HEAD
- [Forward-Only Philosophy](docs/claude/project-rules-summary.md)
- [qwen.md](qwen.md) - Sezione 7: Database SACRO
=======
<<<<<<< .merge_file_0fOKfh
- [Forward-Only Philosophy](../claude/project-rules-summary.md)
- [QWEN.md](qwen.md) - Sezione 7: Database SACRO
=======
- [Forward-Only Philosophy](docs/claude/project-rules-summary.md)
- [qwen.md](qwen.md) - Sezione 7: Database SACRO
>>>>>>> .merge_file_UZiUHv
>>>>>>> laraxot/dev
<<<<<<< .merge_file_c84ABB
<<<<<<< .merge_file_SS3FA3
<<<<<<< .merge_file_TzeDVu
>>>>>>> .merge_file_d2aWFB
=======
>>>>>>> .merge_file_xNxe7s
=======
>>>>>>> .merge_file_vD0qXu
=======
>>>>>>> .merge_file_idqGDu
- [AGENTS.md](AGENTS.md) - Regola Critica

---

**URLATO PER ESSERE LETTO PRIMA DI OGNI MIGRATION** 🔴🔴🔴
