# PHPMD — Installazione Standalone

**Versione**: v2.15.0+ (in `tools/phpmd.phar`)
**Stato**: ✅ Installato

---

## Perché Standalone?

PHPMD (PHP Mess Detector) può avere dipendenze che confliggono con il core di Laravel o altri pacchetti. L'uso della versione `.phar` garantisce un ambiente di esecuzione pulito e privo di effetti collaterali sulle dipendenze del progetto.

---

## Utilizzo

```bash
# Versione
php tools/phpmd.phar --version

# Analisi di un modulo (usando il wrapper)
bash tools/phpmd.sh Modules/Rating/app text codesize,unusedcode,naming

# Analisi con ruleset specifico
bash tools/phpmd.sh Modules/Rating/app text phpmd.ruleset.xml
```

---

## Struttura

```
laravel/
├── tools/
│   ├── phpmd.sh          # Wrapper script
│   └── phpmd.phar        # Eseguibile standalone
```

---

## Aggiornamento

```bash
curl -L https://phpmd.org/static/latest/phpmd.phar -o tools/phpmd.phar
chmod +x tools/phpmd.phar
```

---

## Per altri Agenti AI

> [!IMPORTANT]
> Quando devi eseguire PHPMD:
> - **Usa**: `bash tools/phpmd.sh` o `php tools/phpmd.phar`
> - **NON usare**: `./vendor/bin/phpmd`
> - **NON aggiungere**: `phpmd/phpmd` nel `composer.json` principale se vuoi evitare conflitti.

## Riferimenti

- [PHPMD Official Site](https://phpmd.org/)
- [PHPMD Rules](https://phpmd.org/rules/index.html)
