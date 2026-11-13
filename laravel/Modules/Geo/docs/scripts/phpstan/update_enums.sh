#!/bin/bash

# Script to update enum files to follow the project's standards
# This script will:
# 1. Add 'Enum' suffix to enum class names if not present
# 2. Add proper documentation and formatting
# 3. Ensure proper implementation of interfaces
# 4. Add backward compatibility aliases

ENUMS_DIR="/var/www/html/_bases/base_<nome progetto>/laravel/Modules/<nome progetto>/app/Enums"

# Function to add standard enum documentation
generate_enum_docs() {
    local enum_name=$1
    local description=$2
    
    echo "/**"
    echo " * $description"
    echo " * "
    echo " * @method static self fromName(string \$name)"
    echo " * @method static self fromValue(string \$value)"
    echo " * @method static self tryFromName(string \$name)"
    echo " * @method static self tryFromValue(string \$value)"
    echo " * @method static self[] cases()"
    echo " */"
}

# Process each PHP file in the Enums directory
for file in "$ENUMS_DIR"/*.php; do
    filename=$(basename -- "$file")
    
    # Skip files that don't contain enum definitions
    if ! grep -q "^enum" "$file"; then
        echo "Skipping $filename (not an enum)"
        continue
    fi
    
    # Extract base name
    if [[ "$filename" == *"Enum.php" ]]; then
        base_name="${filename%Enum.php}"
        new_filename="$filename"
        is_renamed=false
    else
        base_name="${filename%.*}"
        new_filename="${base_name}Enum.php"
        is_renamed=true
    fi
    
    # Skip if the file is being renamed but new filename exists
    if [ "$is_renamed" = true ] && [ -f "$ENUMS_DIR/$new_filename" ]; then
        echo "Skipping $filename (${new_filename} already exists)"
        continue
    fi
    
    echo "Processing $filename"
    
    # Rename the file if needed
    if [ "$is_renamed" = true ]; then
        mv "$file" "$ENUMS_DIR/$new_filename"
        file="$ENUMS_DIR/$new_filename"
    fi
    
    # Update the class name inside the file if needed
    if [ "$is_renamed" = true ]; then
        sed -i "s/enum ${base_name}:/enum ${base_name}Enum:/g" "$file"
    fi
    
    # Add standard interfaces if not present
    if ! grep -q "implements" "$file"; then
        sed -i "/^enum/s/:/ implements \\Filament\\Support\\Contracts\\HasLabel:/" "$file"
    fi
    
    # Add getLabel method if not present
    if ! grep -q "function getLabel" "$file"; then
        echo -e "\n    /**"
        echo -e "     * Get the translated label for the enum case."
        echo -e "     */"
        echo -e '    public function getLabel(): ?string'
        echo -e '    {'
        echo -e '        return match ($this) {'
        grep -oP 'case \K\w+' "$file" | while read -r case_name; do
            echo -e "            self::$case_name => __('<nome progetto>::enums.${base_name,,}.${case_name,,}'),"
        done
        echo -e '        };'
        echo -e '    }'
    fi >> "$file"
    
    # Add backward compatibility alias if not present
    if ! grep -q "class_alias" "$file"; then
        echo -e "\n// Alias for backward compatibility\nclass_alias(${base_name}Enum::class, 'Modules\\\\<nome progetto>\\\\Enums\\\\${base_name}');" >> "$file"
    fi
    
    # Update all references in the codebase if file was renamed
    if [ "$is_renamed" = true ]; then
        find /var/www/html/_bases/base_<nome progetto> -type f -name "*.php" -exec sed -i "s/\\${base_name}::/${base_name}Enum::/g" {} \;
        find /var/www/html/_bases/base_<nome progetto> -type f -name "*.php" -exec sed -i "s/use Modules\\\\<nome progetto>\\\\Enums\\\\${base_name};/use Modules\\\\<nome progetto>\\\\Enums\\\\${base_name}Enum;/g" {} \;
    fi
done

# Update language files with enum translations
LANG_FILE="/var/www/html/_bases/base_<nome progetto>/laravel/Modules/<nome progetto>/resources/lang/it/<nome progetto>.php"

# Ensure enums section exists in language file
if ! grep -q "'enums' => " "$LANG_FILE"; then
    sed -i "/return \[/a \    'enums' => [\n    ]," "$LANG_FILE"
fi

echo "Enum update completed."
echo "Please review the changes and update the language files with appropriate translations."
