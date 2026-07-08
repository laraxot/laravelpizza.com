#!/bin/bash

# Questo script rinomina in minuscolo i file specificati mantenendo README.md maiuscolo

# Array dei file da rinominare
files=(
  "/var/www/html/YOUR_PROJECT/laravel/Modules/Activity/CHANGELOG.md"
  "/var/www/html/base_project/laravel/Modules/Chart/.github/CONTRIBUTING.md"
  "/var/www/html/base_project/laravel/Modules/Notify/app/Datas/NetfunSMSMessage.php"
  "/var/www/html/base_project/laravel/Modules/Xot/CHANGELOG.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/ASSETS.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/AUTH.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/BUILD_ERRORS.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/COMPONENTS.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/FILAMENT_COMPONENTS.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/JSON_CONTENT.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/LINKS.md"
  "/var/www/html/base_project/laravel/Themes/One/docs/THEME.md"
)

# Rinomina i file in minuscolo
for file in "${files[@]}"; do
  if [ -f "$file" ]; then
    dir=$(dirname "$file")
    filename=$(basename "$file")
    
    # Salta README.md
    if [ "$filename" = "README.md" ]; then
      echo "Mantengo: $file"
      continue
    fi
    
    lowercase_filename=$(echo "$filename" | tr '[:upper:]' '[:lower:]')
    
    if [ "$filename" != "$lowercase_filename" ]; then
      # Verifica se esiste già un file con il nome in minuscolo
      if [ -f "$dir/$lowercase_filename" ]; then
        # Se esiste già, confronta i contenuti
        if diff -q "$file" "$dir/$lowercase_filename" >/dev/null; then
          echo "Rimuovo duplicato (contenuto identico): $file"
          rm "$file"
        else
          echo "ATTENZIONE: Esiste già un file con lo stesso nome ma contenuto diverso: $dir/$lowercase_filename"
          echo "Backup del file originale in: $file.backup"
          cp "$file" "$file.backup"
          echo "Unisco i contenuti in: $dir/$lowercase_filename"
          cat "$file" >> "$dir/$lowercase_filename"
          rm "$file"
        fi
      else
        echo "Rinomino: $file -> $dir/$lowercase_filename"
        mv "$file" "$dir/$lowercase_filename"
      fi
    else
      echo "Già corretto: $file"
    fi
  else
    echo "File non trovato: $file"
  fi
done

echo "Operazione completata!"
