# phpstan status

## stato attuale - 2025-10-14

### configurazione
- **level**: max
- **file analizzati**: 4129
- **baseline**: phpstan-baseline.neon (attivo)
- **estensioni**: larastan, carbon, bleeding edge, safe-rule, pest

### errori corretti oggi
1. **media module** - rimossi metodi duplicati in AwsTest e S3Test
2. **activity module** - aggiunti type hints Collection con Assert
3. **blog module** - riscrittura GetTreeOptions type-safe, ArticleSeeder validato, ShowArticleCommand con Assert

### performance issue
- analisi completa timeout dopo 5+ minuti
- necessario analizzare modulo per modulo
- `_ide_helper_models.php` commentato (conflitto con Spatie)

### moduli verificati
- ✅ **comment**: 27 file, 0 errori
- ⏳ **activity**: 101 file, timeout (>30s)
- ⏳ **altri**: non ancora verificati

### strategia
1. baseline cattura stato attuale (1108 errori legacy)
2. nuovi errori bloccati immediatamente
3. correzione graduale modulo per modulo
4. ogni nuovo codice deve essere pulito (level max)

### comandi
```bash
# analisi completa (lenta!)
./vendor/bin/phpstan analyse --memory-limit=1G

# singolo modulo
./vendor/bin/phpstan analyse Modules/Comment --memory-limit=512M

# rigenera baseline
./vendor/bin/phpstan analyse --generate-baseline
```

### note
- livello MAX molto strict, molti errori legacy
- baseline approccio pragmatico per codice esistente
- focus: zero nuovi errori, fix progressivi legacy

## aggiornamento operativo

- modulo `ai` riportato a **0 errori** con `./vendor/bin/phpstan analyse Modules/AI --level=max --no-progress`
- eliminati cast da `mixed` non sicuri in:
  - `app/Actions/GeneratePredictionsAction.php`
  - `app/Actions/Predict/GeneratePredictionDraftsAction.php`
  - `app/Datas/PredictionData.php`
  - `app/Services/AIService.php`
- rimossi ignore obsoleti nei test unitari AI (`CompletionActionTest`, `SentimentActionTest`) che generavano errori `ignore.unmatchedLine`

## motivazione tecnica

- ridurre fragilita runtime (cast diretti da `mixed`)
- rendere esplicita la validazione dei dati esterni (config/api payload)
- allineare il modulo a phpstan max senza suppressions artificiali
