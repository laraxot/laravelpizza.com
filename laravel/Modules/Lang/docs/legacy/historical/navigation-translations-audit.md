# Audit Traduzioni con ".navigation" - <nome progetto>

## Panoramica
Questo documento elenca tutte le occorrenze di chiavi di traduzione che contengono ".navigation" nei file di lingua dei moduli. Queste chiavi violano le regole di traduzione e devono essere sistematizzate secondo i principi DRY + KISS.

## Regola Violata
**MAI** usare chiavi o valori che terminano con `.navigation` nei file di traduzione. Le chiavi devono essere esplicite e localizzate.

## Occorrenze Trovate

### Modulo User

#### File: `/Modules/User/lang/it/device.php`
- **Linea 88**: `'label' => 'device.navigation',`
- **Linea 89**: `'group' => 'device.navigation',`
- **Linea 90**: `'icon' => 'device.navigation',`

#### File: `/Modules/User/lang/it/permission.php`
- **Linea 39**: `'label' => 'permission.navigation',`
- **Linea 40**: `'group' => 'permission.navigation',`
- **Linea 41**: `'icon' => 'permission.navigation',`

### Modulo Geo

#### File: `/Modules/Geo/lang/it/.php` (file con nome problematico)
- **Linea 4**: `'label' => '.navigation',`
- **Linea 5**: `'group' => '.navigation',`

### Modulo Lang

#### File: `/Modules/Lang/lang/en/edit_translation_file.php`
Questo file contiene molteplici occorrenze problematiche:

**Sezione content.navigation.name (Linee 14-17):**
- `'label' => 'content.navigation.name',`
- `'placeholder' => 'content.navigation.name',`
- `'helper_text' => 'content.navigation.name',`
- `'description' => 'content.navigation.name',`

**Sezione content.navigation.plural (Linee 21-24):**
- `'label' => 'content.navigation.plural',`
- `'placeholder' => 'content.navigation.plural',`
- `'helper_text' => 'content.navigation.plural',`
- `'description' => 'content.navigation.plural',`

**Sezione content.navigation.group.name (Linee 30-33):**
- `'label' => 'content.navigation.group.name',`
- `'placeholder' => 'content.navigation.group.name',`
- `'helper_text' => 'content.navigation.group.name',`
- `'description' => 'content.navigation.group.name',`

**Sezione content.navigation.group.description (Linee 37-40):**
- `'label' => 'content.navigation.group.description',`
- `'placeholder' => 'content.navigation.group.description',`
- `'helper_text' => 'content.navigation.group.description',`
- `'description' => 'content.navigation.group.description',`

**Sezione content.navigation.group (Linee 42-44):**
- `'label' => 'content.navigation.group',`
- `'placeholder' => 'content.navigation.group',`
- `'helper_text' => 'content.navigation.group',`

**Sezione content.navigation.label (Linee 48-51):**
- `'label' => 'content.navigation.label',`
- `'placeholder' => 'content.navigation.label',`
- `'helper_text' => 'content.navigation.label',`
- `'description' => 'content.navigation.label',`

**Sezione content.navigation.sort (Linee 55-58):**
- `'label' => 'content.navigation.sort',`
- `'placeholder' => 'content.navigation.sort',`
- `'helper_text' => 'content.navigation.sort',`
- `'description' => 'content.navigation.sort',`

**Sezione content.navigation.icon (Linee 62-65):**
- `'label' => 'content.navigation.icon',`
- `'placeholder' => 'content.navigation.icon',`
- `'helper_text' => 'content.navigation.icon',`
- `'description' => 'content.navigation.icon',`

**Sezione content.navigation.color (Linee 69-72):**
- `'label' => 'content.navigation.color',`
- `'placeholder' => 'content.navigation.color',`
- `'helper_text' => 'content.navigation.color',`
- `'description' => 'content.navigation.color',`

**Sezione content.navigation.tooltip (Linee 76-79):**
- `'label' => 'content.navigation.tooltip',`
- `'placeholder' => 'content.navigation.tooltip',`
- `'helper_text' => 'content.navigation.tooltip',`
- `'description' => 'content.navigation.tooltip',`

**Sezione doctor navigation (Linea 2812):**
- `'description' => 'content.resources.doctor.navigation.group',`

## Riepilogo per Modulo

| Modulo | File | Occorrenze | Priorità |
|--------|------|------------|----------|
| User | device.php | 3 | Alta |
| User | permission.php | 3 | Alta |
| Geo | .php (nome file problematico) | 2 | Critica |
| Lang | edit_translation_file.php | 43 | Critica |

## Piano di Sistemazione

1. **Priorità Critica**: Modulo Geo (file con nome problematico) - ✅ **COMPLETATO**
2. **Priorità Alta**: Moduli User (device.php, permission.php) - ✅ **COMPLETATO**
3. **Priorità Alta**: Modulo Lang (edit_translation_file.php) - ✅ **VERIFICATO CONFORME**

## Stato Finale delle Correzioni

### ✅ Modulo Geo - RISOLTO
- **File corrotto rimosso**: `/lang/it/.php` eliminato completamente
- **Struttura corretta**: Confermata in `geo.php` con navigazione appropriata
- **Documentazione**: [Correzioni Geo](../Modules/Geo/docs/navigation-translations-fixes.md)

### ✅ Modulo User - RISOLTO
- **device.php**: Traduzioni corrette (Dispositivi → Sicurezza)
- **permission.php**: Traduzioni corrette (Permessi → Sicurezza)
- **Documentazione**: [Correzioni User](../Modules/User/docs/navigation-translations-fixes.md)

### ✅ Modulo Lang - CONFORME
- **edit_translation_file.php**: Verificato già conforme agli standard
- **Nessuna correzione necessaria**: File già strutturato correttamente
- **Documentazione**: [Verifica Lang](../Modules/Lang/docs/navigation-translations-fixes.md)

## Note
- Ogni file deve essere studiato nel contesto del modulo
- Le traduzioni devono essere localizzate e significative
- Aggiornare sempre la documentazione del modulo dopo le correzioni
- Mantenere la struttura espansa (label, placeholder, helper_text, description)

## Collegamenti
- [Regole Traduzioni](../Modules/Xot/docs/translation-rules.md)
- [Standard Qualità Traduzioni](../Modules/<nome progetto>/docs/translation-quality-standards.md)

*Audit creato il: 2025-08-07*
*Ultimo aggiornamento: 2025-08-07*
