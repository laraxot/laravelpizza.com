#!/usr/bin/env bash
# Script per generare collegamenti bidirezionali tra file con lo stesso nome in cartelle docs
# Esegue la scansione dei file *.md in tutte le directory */docs/ e */_docs/

docs_root="/var/www/html/project"
cd "$docs_root" || exit 1

# Trova tutti i file markdown in docs directories
mapfile -t files < <(find . -type f \( -path '*/docs/*.md' -o -path '*/docs/**/*.md' -o -path '*/_docs/*.md' -o -path '*/_docs/**/*.md' \))

declare -A groups
# Raggruppa per nome base
for file in "${files[@]}"; do
  name=$(basename "$file")
  groups["$name"]+="$file|"
done

# Per ogni gruppo con più file, genera collegamenti
for name in "${!groups[@]}"; do
  IFS='|' read -r -a paths <<< "${groups[$name]}"
  if [ "${#paths[@]}" -gt 1 ]; then
    for p in "${paths[@]}"; do
      [[ -f "$p" ]] || continue
      if ! grep -q "## Collegamenti tra versioni di $name" "$p"; then
        links=""
        for q in "${paths[@]}"; do
          [[ -z "$q" || "$q" == "$p" ]] && continue
          rel=$(realpath --relative-to="$(dirname "$p")" "$q")
          links+="* [$name]($rel)\n"
        done
        echo -e "\n## Collegamenti tra versioni di $name\n$links" >> "$p"
      fi
    done
  fi
done
