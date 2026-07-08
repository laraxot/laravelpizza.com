#!/bin/bash

##
# LARAXOT Documentation Synchronizer
# 
# Sincronizzatore documentazione moduli seguendo principi:
# DRY + KISS + ROBUST + SOLID + LARAXOT
# 
# @category Documentation
# @package  Bashscripts\Documentation\Utils
# @author   Laraxot Team
# @license  MIT
# @version  1.0.0
##

set -euo pipefail

# Script configuration
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(dirname "$(dirname "$(dirname "$SCRIPT_DIR")")")"
LARAVEL_DIR="$PROJECT_ROOT/laravel"
DOCS_DIR="$LARAVEL_DIR/Modules/docs"
TEMPLATES_DIR="$SCRIPT_DIR/../templates"

# Colors for output (KISS: Simple color system)
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Logging functions (DRY: Centralized logging)
log_info() {
    echo -e "${BLUE}ℹ️  $1${NC}"
}

log_success() {
    echo -e "${GREEN}✅ $1${NC}"
}

log_warning() {
    echo -e "${YELLOW}⚠️  $1${NC}"
}

log_error() {
    echo -e "${RED}❌ $1${NC}"
}

# Help function (KISS: Simple help system)
show_help() {
    cat << EOF
LARAXOT Documentation Synchronizer

Sincronizza componenti condivisi e templates tra i moduli per mantenere
coerenza e applicare principi DRY.

USAGE:
    $0 [OPTIONS] [COMMAND]

COMMANDS:
    sync-all        Sincronizza tutti i componenti condivisi
    sync-templates  Sincronizza solo i template
    sync-snippets   Sincronizza solo i code snippets
    sync-badges     Sincronizza solo i badge
    update-links    Aggiorna i link tra documentazioni
    validate-sync   Valida la sincronizzazione

OPTIONS:
    -h, --help      Mostra questo help
    -v, --verbose   Output verboso
    -f, --force     Forza sincronizzazione anche se file esistono
    -n, --dry-run   Mostra cosa verrebbe fatto senza eseguire
    --backup        Crea backup prima della sincronizzazione

EXAMPLES:
    $0 sync-all                    # Sincronizza tutto
    $0 sync-templates --force      # Forza sincronizzazione template
    $0 sync-badges --dry-run       # Preview sincronizzazione badge
    $0 update-links --verbose      # Aggiorna link con output dettagliato

Framework: DRY + KISS + ROBUST + SOLID + LARAXOT
Version: 1.0.0
EOF
}

# Configuration loading (SOLID: Single Responsibility)
load_config() {
    # Default configuration
    VERBOSE=false
    FORCE=false
    DRY_RUN=false
    BACKUP=false
    
    # Shared components configuration (DRY: Centralized config)
    BADGES=(
        "laravel:[![Laravel 11.x](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com/)"
        "filament:[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)"
        "phpstan:[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)"
        "translation:[![Translation Ready](https://img.shields.io/badge/Translation-Ready-green.svg)](https://laravel.com/docs/localization)"
        "laraxot:[![Laraxot Framework](https://img.shields.io/badge/Laraxot-Framework-orange.svg)](https://laraxot.com/)"
    )
    
    SNIPPETS=(
        "enable_module:php artisan module:enable {module_name}"
        "migrate:php artisan migrate"
        "seed:php artisan module:seed {module_name}"
        "test:php artisan test --testsuite={module_name}"
        "phpstan:./vendor/bin/phpstan analyze Modules/{module_name} --level=9"
        "pint:./vendor/bin/pint Modules/{module_name}"
    )
    
    STANDARD_LINKS=(
        "laraxot_docs:[Laraxot Documentation](../../../docs/)"
        "laravel_docs:[Laravel Documentation](https://laravel.com/docs)"
        "filament_docs:[Filament Documentation](https://filamentphp.com/docs)"
        "phpstan_docs:[PHPStan Documentation](https://phpstan.org/user-guide)"
    )
}

# Argument parsing (KISS: Simple argument handling)
parse_arguments() {
    COMMAND=""
    
    while [[ $# -gt 0 ]]; do
        case $1 in
            -h|--help)
                show_help
                exit 0
                ;;
            -v|--verbose)
                VERBOSE=true
                shift
                ;;
            -f|--force)
                FORCE=true
                shift
                ;;
            -n|--dry-run)
                DRY_RUN=true
                shift
                ;;
            --backup)
                BACKUP=true
                shift
                ;;
            sync-all|sync-templates|sync-snippets|sync-badges|update-links|validate-sync)
                COMMAND=$1
                shift
                ;;
            *)
                log_error "Unknown option: $1"
                show_help
                exit 1
                ;;
        esac
    done
    
    if [[ -z "$COMMAND" ]]; then
        COMMAND="sync-all"
    fi
}

# Module discovery (LARAXOT: Framework-aware discovery)
discover_modules() {
    find "$LARAVEL_DIR/Modules" -name "module.json" -type f | while read -r module_file; do
        module_name=$(basename "$(dirname "$module_file")")
        if [[ "$module_name" != "docs" ]]; then
            echo "$module_name"
        fi
    done
}

# Backup creation (ROBUST: Data protection)
create_backup() {
    local target_file="$1"
    
    if [[ "$BACKUP" == true && -f "$target_file" ]]; then
        local backup_file="${target_file}.backup.$(date +%Y%m%d_%H%M%S)"
        if [[ "$DRY_RUN" == false ]]; then
            cp "$target_file" "$backup_file"
            log_info "Created backup: $backup_file"
        else
            log_info "[DRY-RUN] Would create backup: $backup_file"
        fi
    fi
}

# Template synchronization (DRY: Template reuse)
sync_templates() {
    log_info "Synchronizing documentation templates..."
    
    local template_files=(
        "base_README_template.md"
        "getting_started_template.md"
        "configuration_template.md"
        "api_reference_template.md"
        "troubleshooting_template.md"
    )
    
    local sync_count=0
    
    while IFS= read -r module_name; do
        local module_docs_dir="$LARAVEL_DIR/Modules/$module_name/docs"
        
        # Create docs directory if it doesn't exist
        if [[ ! -d "$module_docs_dir" ]]; then
            if [[ "$DRY_RUN" == false ]]; then
                mkdir -p "$module_docs_dir"
                log_info "Created docs directory for $module_name"
            else
                log_info "[DRY-RUN] Would create docs directory for $module_name"
            fi
        fi
        
        # Sync each template
        for template_file in "${template_files[@]}"; do
            local source_file="$TEMPLATES_DIR/$template_file"
            local target_file="$module_docs_dir/${template_file/_template/}"
            
            if [[ -f "$source_file" ]]; then
                if [[ "$FORCE" == true || ! -f "$target_file" ]]; then
                    create_backup "$target_file"
                    
                    if [[ "$DRY_RUN" == false ]]; then
                        # Process template with module-specific data
                        process_template "$source_file" "$target_file" "$module_name"
                        sync_count=$((sync_count + 1))
                        
                        if [[ "$VERBOSE" == true ]]; then
                            log_info "Synced template: $module_name/$template_file"
                        fi
                    else
                        log_info "[DRY-RUN] Would sync template: $module_name/$template_file"
                        sync_count=$((sync_count + 1))
                    fi
                fi
            else
                log_warning "Template not found: $template_file"
            fi
        done
        
    done < <(discover_modules)
    
    log_success "Templates synchronized: $sync_count files"
}

# Template processing with variable substitution (SOLID: Single purpose)
process_template() {
    local source_file="$1"
    local target_file="$2"
    local module_name="$3"
    
    # Template variables (would be more sophisticated in production)
    local module_slug=$(echo "$module_name" | tr '[:upper:]' '[:lower:]')
    local module_upper=$(echo "$module_name" | tr '[:lower:]' '[:upper:]')
    local current_date=$(date '+%B %d, %Y')
    
    # Simple variable substitution
    sed \
        -e "s/{{module_name}}/$module_name/g" \
        -e "s/{{module_slug}}/$module_slug/g" \
        -e "s/{{module_upper}}/$module_upper/g" \
        -e "s/{{last_updated}}/$current_date/g" \
        -e "s/{{version}}/1.0.0/g" \
        "$source_file" > "$target_file"
}

# Badge synchronization (DRY: Shared badges)
sync_badges() {
    log_info "Synchronizing documentation badges..."
    
    local sync_count=0
    
    while IFS= read -r module_name; do
        local readme_file="$LARAVEL_DIR/Modules/$module_name/docs/README.md"
        
        if [[ -f "$readme_file" ]]; then
            # Check if badges are already present
            if ! grep -q "img.shields.io" "$readme_file"; then
                create_backup "$readme_file"
                
                if [[ "$DRY_RUN" == false ]]; then
                    # Add badges after first heading
                    local badge_section=""
                    for badge in "${BADGES[@]}"; do
                        badge_section+="${badge#*:}"$'\n'
                    done
                    
                    # Insert badges after the first line (module title)
                    sed -i "1a\\
\\
$badge_section" "$readme_file"
                    
                    sync_count=$((sync_count + 1))
                    
                    if [[ "$VERBOSE" == true ]]; then
                        log_info "Added badges to: $module_name"
                    fi
                else
                    log_info "[DRY-RUN] Would add badges to: $module_name"
                    sync_count=$((sync_count + 1))
                fi
            elif [[ "$VERBOSE" == true ]]; then
                log_info "Badges already present in: $module_name"
            fi
        fi
        
    done < <(discover_modules)
    
    log_success "Badges synchronized: $sync_count files"
}

# Snippet synchronization (DRY: Shared code examples)
sync_snippets() {
    log_info "Synchronizing code snippets..."
    
    # Create shared snippets file
    local snippets_file="$DOCS_DIR/shared/snippets.md"
    local snippets_dir="$(dirname "$snippets_file")"
    
    if [[ ! -d "$snippets_dir" ]]; then
        if [[ "$DRY_RUN" == false ]]; then
            mkdir -p "$snippets_dir"
        else
            log_info "[DRY-RUN] Would create snippets directory"
        fi
    fi
    
    if [[ "$DRY_RUN" == false ]]; then
        cat > "$snippets_file" << 'EOF'
# Shared Code Snippets

Common code snippets utilizzati across all module documentation.

## Installation Commands

```bash
# Enable module
php artisan module:enable {module_name}

# Run migrations
php artisan migrate

# Seed data
php artisan module:seed {module_name}
```

## Testing Commands

```bash
# Run tests
php artisan test --testsuite={module_name}

# PHPStan analysis
./vendor/bin/phpstan analyze Modules/{module_name} --level=9

# Code formatting
./vendor/bin/pint Modules/{module_name}
```

## Common Patterns

```php
// Service injection
app(ModuleService::class)->method();

// Action pattern
ModuleAction::make()->execute($data);

// Data pattern
ModuleData::from($array);
```
EOF
        log_success "Created shared snippets file"
    else
        log_info "[DRY-RUN] Would create shared snippets file"
    fi
}

# Link updating (ROBUST: Maintain referential integrity)
update_links() {
    log_info "Updating inter-documentation links..."
    
    local update_count=0
    
    while IFS= read -r module_name; do
        local readme_file="$LARAVEL_DIR/Modules/$module_name/docs/README.md"
        
        if [[ -f "$readme_file" ]]; then
            create_backup "$readme_file"
            
            local updated=false
            
            # Update relative links to other modules
            if [[ "$DRY_RUN" == false ]]; then
                # Fix broken relative links (example)
                if sed -i 's|\.\./\.\./docs/|../../../docs/|g' "$readme_file"; then
                    updated=true
                fi
                
                # Add standard links if missing
                if ! grep -q "Laraxot Documentation" "$readme_file"; then
                    echo -e "\n## Links\n\n- [Laraxot Documentation](../../../docs/)" >> "$readme_file"
                    updated=true
                fi
            else
                log_info "[DRY-RUN] Would update links in: $module_name"
                updated=true
            fi
            
            if [[ "$updated" == true ]]; then
                update_count=$((update_count + 1))
                
                if [[ "$VERBOSE" == true ]]; then
                    log_info "Updated links in: $module_name"
                fi
            fi
        fi
        
    done < <(discover_modules)
    
    log_success "Links updated: $update_count files"
}

# Synchronization validation (ROBUST: Quality assurance)
validate_sync() {
    log_info "Validating documentation synchronization..."
    
    local issues=0
    local total_modules=0
    
    while IFS= read -r module_name; do
        total_modules=$((total_modules + 1))
        local readme_file="$LARAVEL_DIR/Modules/$module_name/docs/README.md"
        
        # Check README exists
        if [[ ! -f "$readme_file" ]]; then
            log_error "$module_name: Missing README.md"
            issues=$((issues + 1))
            continue
        fi
        
        # Check badges presence
        if ! grep -q "img.shields.io" "$readme_file"; then
            log_warning "$module_name: Missing badges"
            issues=$((issues + 1))
        fi
        
        # Check standard sections
        local required_sections=("Overview" "Quick Start" "Links")
        for section in "${required_sections[@]}"; do
            if ! grep -q "## $section" "$readme_file"; then
                log_warning "$module_name: Missing section: $section"
                issues=$((issues + 1))
            fi
        done
        
        # Check for broken internal links
        if grep -q "](\.\..*\.md)" "$readme_file"; then
            while IFS= read -r link; do
                local link_path=$(echo "$link" | sed 's/.*](\([^)]*\)).*/\1/')
                local full_path="$LARAVEL_DIR/Modules/$module_name/docs/$link_path"
                
                if [[ ! -f "$full_path" ]]; then
                    log_error "$module_name: Broken link: $link_path"
                    issues=$((issues + 1))
                fi
            done < <(grep -o "](\.\..*\.md)" "$readme_file")
        fi
        
    done < <(discover_modules)
    
    # Summary
    local success_rate=0
    if [[ $total_modules -gt 0 ]]; then
        success_rate=$(( (total_modules * 10 - issues) * 100 / (total_modules * 10) ))
    fi
    
    log_info "Validation Summary:"
    log_info "  Total Modules: $total_modules"
    log_info "  Issues Found: $issues"
    log_info "  Success Rate: $success_rate%"
    
    if [[ $issues -eq 0 ]]; then
        log_success "All documentation is properly synchronized!"
        return 0
    else
        log_warning "Found $issues synchronization issues"
        return 1
    fi
}

# Main sync function (LARAXOT: Comprehensive sync)
sync_all() {
    log_info "Starting complete documentation synchronization..."
    
    local start_time=$(date +%s)
    
    # Run all synchronization tasks
    sync_templates
    sync_badges  
    sync_snippets
    update_links
    
    # Validate results
    if validate_sync; then
        local end_time=$(date +%s)
        local duration=$((end_time - start_time))
        log_success "Complete synchronization finished in ${duration}s"
        return 0
    else
        log_error "Synchronization completed with issues"
        return 1
    fi
}

# Main execution function (SOLID: Single entry point)
main() {
    log_info "🔄 LARAXOT Documentation Synchronizer"
    log_info "   Framework: DRY + KISS + ROBUST + SOLID + LARAXOT"
    log_info "   Version: 1.0.0"
    echo
    
    # Load configuration
    load_config
    
    # Parse command line arguments
    parse_arguments "$@"
    
    # Verify prerequisites
    if [[ ! -d "$LARAVEL_DIR" ]]; then
        log_error "Laravel directory not found: $LARAVEL_DIR"
        exit 1
    fi
    
    if [[ ! -d "$LARAVEL_DIR/Modules" ]]; then
        log_error "Modules directory not found: $LARAVEL_DIR/Modules"
        exit 1
    fi
    
    # Execute command
    case "$COMMAND" in
        sync-all)
            sync_all
            ;;
        sync-templates)
            sync_templates
            ;;
        sync-snippets)
            sync_snippets
            ;;
        sync-badges)
            sync_badges
            ;;
        update-links)
            update_links
            ;;
        validate-sync)
            validate_sync
            ;;
        *)
            log_error "Unknown command: $COMMAND"
            show_help
            exit 1
            ;;
    esac
    
    local exit_code=$?
    
    if [[ $exit_code -eq 0 ]]; then
        log_success "Operation completed successfully"
    else
        log_error "Operation failed"
    fi
    
    exit $exit_code
}

# Error handling (ROBUST: Graceful error handling)
trap 'log_error "Script interrupted"; exit 1' INT TERM

# Execute main function with all arguments
main "$@"