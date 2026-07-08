#!/usr/bin/env bash
set -e

# Script per eseguire PHPStan su ogni modulo in laravel/Modules
dir_root="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$dir_root/laravel"

for module in Modules/*; do
  if [ -d "$module" ]; then
    mkdir -p "$module/docs/phpstan"
    for level in $(seq 1 10); do
      json_file="$module/docs/phpstan/level_${level}.json"
      md_file="$module/docs/phpstan/level_${level}.md"
      # Esegui PHPStan e salva JSON
      ./vendor/bin/phpstan analyse "$module" --level=$level --error-format=json > "$json_file" || true
      # Genera file Markdown con riepilogo errori e sezione soluzioni
      cat > "$md_file" <<EOF
# PHPStan Report - Livello $level

## Errori rilevati
EOF
      php -r '$data=json_decode(file_get_contents($argv[1]), true); foreach($data["files"] as $file => $info){ if(isset($info["messages"])) { foreach($info["messages"] as $msg){ echo "* $file: {$msg["message"]} (line {$msg["line"]})\n"; } } }' "$json_file" >> "$md_file"
      echo -e "\n## Soluzioni proposte\n\n> TODO: descrivere soluzioni architetturali e funzionali" >> "$md_file"
      # Aggiunge collegamento all'indice principale
      echo -e "\n## Collegamenti\n\n- Torna all'indice principale: [Indice Report PHPStan Moduli](/docs/phpstan_modules_index.md)" >> "$md_file"
    done
  fi
done
