#!/bin/bash

# Script per analizzare la struttura dei moduli in laravel/Modules
# e creare documentazione con informazioni sui namespace e altre proprietà

cd $(dirname $0)/../..

echo "Iniziando l'analisi della struttura dei moduli..."

# Assicuriamoci che la directory docs/phpstan esista
mkdir -p docs/phpstan

# File di output per l'analisi complessiva
MODULES_ANALYSIS="docs/phpstan/modules_structure_analysis.md"

# Intestazione del file di analisi
cat > $MODULES_ANALYSIS << EOL
# Analisi strutturale dei moduli

Data: $(date +"%Y-%m-%d %H:%M:%S")

Questo documento contiene un'analisi dettagliata della struttura dei moduli presenti in laravel/Modules.

## Riepilogo moduli

| Modulo | Namespace principale | Composer package | Dipendenze | File | Classi |
|--------|----------------------|------------------|------------|------|--------|
EOL

# Funzione per contare ricorsivamente i file PHP in una directory
count_php_files() {
  find "$1" -type f -name "*.php" | wc -l
}

# Funzione per contare le classi PHP in una directory
count_php_classes() {
  grep -r "^class\s\|^abstract\sclass\s\|^interface\s" "$1" --include="*.php" | wc -l
}

# Analisi di ogni modulo
for MODULE_DIR in laravel/Modules/*/; do
  MODULE_NAME=$(basename "$MODULE_DIR")
  echo "Analizzando il modulo $MODULE_NAME..."
  
  # Crea directory per la documentazione nel modulo se non esiste
  mkdir -p "$MODULE_DIR/docs"
  
  # Path del file composer.json del modulo
  COMPOSER_FILE="$MODULE_DIR/composer.json"
  
  # Estrai il namespace dal composer.json se esiste
  if [ -f "$COMPOSER_FILE" ]; then
    NAMESPACE=$(grep -A 10 "autoload" "$COMPOSER_FILE" | grep "psr-4" -A 3 | grep -oP '"\K[^"]*(?=\\\\": ")')
    PACKAGE_NAME=$(grep -oP '"name": "\K[^"]*' "$COMPOSER_FILE")
    DEPENDENCIES=$(grep -A 20 '"require"' "$COMPOSER_FILE" | grep -v "require" | grep -oP '"[^"]*"' | tr '\n' ' ' | sed 's/"//g')
  else
    NAMESPACE="Modules\\\\$MODULE_NAME"
    PACKAGE_NAME="laraxot/$MODULE_NAME"
    DEPENDENCIES="N/A"
  fi
  
  # Conta i file PHP
  FILE_COUNT=$(count_php_files "$MODULE_DIR")
  
  # Conta le classi/interfacce
  CLASS_COUNT=$(count_php_classes "$MODULE_DIR")
  
  # Aggiungi informazioni al riepilogo
  echo "| $MODULE_NAME | $NAMESPACE | $PACKAGE_NAME | $DEPENDENCIES | $FILE_COUNT | $CLASS_COUNT |" >> $MODULES_ANALYSIS
  
  # Crea documentazione dettagliata per il modulo
  MODULE_DOC="$MODULE_DIR/docs/structure.md"
  
  cat > "$MODULE_DOC" << EOL
# Modulo $MODULE_NAME

Data: $(date +"%Y-%m-%d %H:%M:%S")

## Informazioni generali

- **Namespace principale**: $NAMESPACE
- **Pacchetto Composer**: $PACKAGE_NAME
- **Dipendenze**: $DEPENDENCIES
- **Totale file PHP**: $FILE_COUNT
- **Totale classi/interfacce**: $CLASS_COUNT

## Struttura delle directory

\`\`\`
$(find "$MODULE_DIR" -type d | sort | sed "s|$MODULE_DIR||")
\`\`\`

## Namespace e autoload

\`\`\`json
$([ -f "$COMPOSER_FILE" ] && grep -A 15 "autoload" "$COMPOSER_FILE" || echo "Configurazione autoload non trovata")
\`\`\`

## Dipendenze da altri moduli

$(grep -r "use Modules\\\\[^$MODULE_NAME]" "$MODULE_DIR" --include="*.php" | sed 's/.*use //' | sort | uniq -c | sort -nr | head -10 | sed 's/^/- /')

## Collegamenti alla documentazione generale

- [Analisi strutturale complessiva](/docs/phpstan/modules_structure_analysis.md)
- [Report PHPStan](/docs/phpstan/)

EOL

  echo "Documentazione per il modulo $MODULE_NAME completata."

  # Crea link alla documentazione modulo nella cartella docs/modules
  mkdir -p docs/modules
  
  cat > "docs/modules/$MODULE_NAME.md" << EOL
# Documentazione del modulo $MODULE_NAME

Questo file contiene link alla documentazione relativa al modulo $MODULE_NAME.

- [Struttura del modulo](../../laravel/Modules/$MODULE_NAME/docs/structure.md)
- [Report PHPStan](/docs/phpstan/)
EOL

done

# Completamento del file di analisi con sezioni aggiuntive
cat >> $MODULES_ANALYSIS << EOL

## Dipendenze tra moduli

Di seguito è riportato un riepilogo delle dipendenze tra i vari moduli, basato sui riferimenti di codice:

$(grep -r "use Modules\\" laravel/Modules --include="*.php" | sed 's/.*use //' | grep -v ";" | sort | uniq -c | sort -nr | head -20 | sed 's/^/- /')

## Naming convention e coerenza

Dall'analisi dei namespace e delle strutture dei moduli emergono i seguenti pattern:

- La maggior parte dei moduli segue un namespace principale di tipo Modules\\NomeModulo
- Le classi sono generalmente organizzate in sottocartelle per tipo (Controllers, Models, Services)
- Alcuni moduli potrebbero non seguire completamente le convenzioni standardizzate

## Raccomandazioni

- Uniformare la struttura dei namespace in tutti i moduli
- Assicurarsi che ogni modulo abbia un composer.json valido con configurazioni di autoload corrette
- Mantenere coerenza nella nomenclatura delle classi e dei file
- Documentare le dipendenze tra moduli in modo esplicito
EOL

echo "Analisi strutturale dei moduli completata. Il report è disponibile in $MODULES_ANALYSIS" 