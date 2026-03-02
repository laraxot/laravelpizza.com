# Regole di Naming per Documentazione

## Regole Assolute

### ❌ COSA NON FARE MAI
- ❌ **NON** usare caratteri MAIUSCOLI nei nomi file .md
- ❌ **NON** creare nuove cartelle docs - usare quelle esistenti
- ❌ **NON** mettere file .md fuori dalle cartelle docs (eccetto README.md e CHANGELOG.md)

### ✅ COSA FARE SEMPRE
- ✅ Usare **solo lowercase** per nomi file .md
- ✅ Usare **hyphens** invece di underscores: `file-name.md` non `file_name.md`
- ✅ **SOLO** README.md e CHANGELOG.md possono avere maiuscole
- ✅ Tutti gli altri file .md devono essere in **lowercase**
- ✅ Usare cartelle docs esistenti, NON crearne di nuove

## Esempi Corretti

### ✅ CORRETTO
```
Modules/Meetup/docs/
├── README.md                    # ✅ Permesso - maiuscole OK
├── CHANGELOG.md                # ✅ Permesso - maiuscole OK
├── project-purpose.md          # ✅ lowercase
├── implementation-plan.md      # ✅ lowercase
├── folio-volt-architecture.md  # ✅ lowercase + hyphens
├── seo-marketing-plan.md       # ✅ lowercase
└── monetization-strategy.md    # ✅ lowercase
```

### ❌ SBAGLIATO
```
Modules/Meetup/docs/
├── PROJECT-PURPOSE.md          # ❌ MAIUSCOLE non permesse
├── Implementation-Plan.md      # ❌ Maiuscole miste
├── folio_volt_architecture.md  # ❌ underscores invece di hyphens
├── SEO-Marketing-Plan.md       # ❌ MAIUSCOLE non permesse
└── MonetizationStrategy.md     # ❌ CamelCase non permesso
```

## File che DEVONO rimanere fuori docs/

### Permessi
- **README.md** - In qualsiasi directory (root progetto, moduli, tema, ecc.)
- **CHANGELOG.md** - In root moduli
- **LICENSE.md** - In root progetto
- **CONTRIBUTING.md** - In root progetto

### Non Permessi
- ❌ **Nessun altro file .md** può stare fuori dalle cartelle docs/
- ❌ Tutti gli altri file .md devono essere dentro `docs/`

## Regole per Cartelle Docs

### ✅ Cartelle Docs Esistenti da Usare
```
Modules/Meetup/docs/            # ✅ Usare questa
Themes/Meetup/docs/             # ✅ Usare questa
docs/                           # ✅ Usare questa (root progetto)
```

### ❌ Cartelle Docs NON da Creare
- ❌ **NON** creare `docs/` nuove in altre directory
- ❌ **NON** creare `documentation/` invece di `docs/`
- ❌ **NON** creare sottocartelle docs personalizzate

## Script di Verifica

### Controllare File con Maiuscole
```bash
# Trova tutti i file .md con maiuscole (eccetto README/CHANGELOG)
find . -name "*.md" -type f | grep -E "[A-Z]" | grep -v -E "(README|CHANGELOG)"

# Conta quanti file hanno problemi
find . -name "*.md" -type f | grep -E "[A-Z]" | grep -v -E "(README|CHANGELOG)" | wc -l
```

### Controllare File Fuori Docs
```bash
# Trova file .md fuori cartelle docs (eccetto README/CHANGELOG)
find . -name "*.md" -type f | grep -v "/docs/" | grep -v -E "(README|CHANGELOG)"
```

## Correzione Automatica

### Rinominare File con Maiuscole
```bash
# Per ogni file con maiuscole, converti in lowercase
find . -name "*.md" -type f | grep -E "[A-Z]" | grep -v -E "(README|CHANGELOG)" | while read file; do
    new_name=$(echo "$file" | tr '[:upper:]' '[:lower:]')
    mv "$file" "$new_name"
    echo "Renamed: $file -> $new_name"
done
```

### Spostare File in Docs
```bash
# Sposta file .md fuori docs/ (eccetto README/CHANGELOG)
find . -name "*.md" -type f | grep -v "/docs/" | grep -v -E "(README|CHANGELOG)" | while read file; do
    # Determina cartella docs di destinazione
    if [[ "$file" == *"Modules/"* ]]; then
        module_name=$(echo "$file" | grep -o "Modules/[^/]*" | head -1)
        target_dir="${module_name}/docs/"
    elif [[ "$file" == *"Themes/"* ]]; then
        theme_name=$(echo "$file" | grep -o "Themes/[^/]*" | head -1)
        target_dir="${theme_name}/docs/"
    else
        target_dir="docs/"
    fi

    # Crea target se non esiste
    mkdir -p "$target_dir"

    # Sposta file
    mv "$file" "$target_dir"
    echo "Moved: $file -> $target_dir"
done
```

## Eccezioni Speciali

### File di Configurazione
Alcuni file .md sono di configurazione e DEVONO rimanere dove sono:
```
config/localhost/terms.md       # ✅ Permesso - file di configurazione
config/localhost/policy.md      # ✅ Permesso - file di configurazione
config/local/laravelpizza/terms.md  # ✅ Permesso - file di configurazione
```

### File AI/Claude
I file di istruzioni per AI possono avere naming speciale:
```
.ai/guidelines/architecture.md  # ✅ Permesso - directory speciale
.claude/instructions.md         # ✅ Permesso - directory speciale
```

## Best Practices

### Naming Semantico
- Usare nomi descrittivi: `event-management.md` invece di `events.md`
- Includere scope: `module-meetup-architecture.md`
- Usare verbi per azioni: `implementing-folio-routes.md`

### Organizzazione Logica
```
docs/
├── 01-getting-started/
│   ├── installation.md
│   └── quickstart.md
├── 02-architecture/
│   ├── folio-volt-architecture.md
│   └── database-schema.md
├── 03-development/
│   ├── development-workflow.md
│   └── testing-guide.md
└── 04-deployment/
    ├── deployment-guide.md
    └── production-checklist.md
```

## Regole da Ricordare Sempre

1. ❌ **NO** maiuscole in nomi file .md (eccetto README.md e CHANGELOG.md)
2. ❌ **NO** file .md fuori docs/ (eccetto README.md e CHANGELOG.md)
3. ❌ **NO** nuove cartelle docs - usare quelle esistenti
4. ✅ **SI** lowercase + hyphens per tutti i file .md
5. ✅ **SI** organizzazione logica dentro docs/

---

**Stato**: ✅ Regole Verificate e Applicabili
