#!/bin/bash
# Wiki Search Cache Manager - Manage query result caching and cache statistics
# Usage: ./cache-manager.sh [COMMAND] [OPTIONS]
#
# Commands:
#   init            Initialize cache system
#   clear           Clear all cached results
#   stats           Show cache statistics
#   warm            Pre-warm cache with common queries
#   monitor         Monitor cache hit rates

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../../.." && pwd)"
CACHE_DIR="${PROJECT_ROOT}/.cache/wiki-search"
CACHE_INDEX="${CACHE_DIR}/.index.json"

# Colors
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

# Initialize cache directory
init_cache() {
    mkdir -p "$CACHE_DIR"

    if [[ ! -f "$CACHE_INDEX" ]]; then
        echo '{"queries": {}, "metadata": {"created": "'$(date -u +%Y-%m-%dT%H:%M:%SZ)'", "hits": 0, "misses": 0}}' > "$CACHE_INDEX"
        echo -e "${GREEN}✓ Cache initialized at ${CACHE_DIR}${NC}"
    else
        echo -e "${YELLOW}Cache already exists${NC}"
    fi
}

# Clear cache
clear_cache() {
    if [[ -d "$CACHE_DIR" ]]; then
        rm -rf "$CACHE_DIR"
        echo -e "${GREEN}✓ Cache cleared${NC}"
    fi
}

# Get cache statistics
show_stats() {
    if [[ ! -f "$CACHE_INDEX" ]]; then
        echo -e "${YELLOW}Cache not initialized. Run 'init' first.${NC}"
        return 1
    fi

    echo -e "${BLUE}Cache Statistics:${NC}"

    local total_size=$(du -sh "$CACHE_DIR" 2>/dev/null | cut -f1 || echo "0")
    local file_count=$(find "$CACHE_DIR" -type f -name "*.json" 2>/dev/null | wc -l || echo "0")

    echo "  Location: ${CACHE_DIR}"
    echo "  Total Size: ${total_size}"
    echo "  Cached Queries: ${file_count}"

    if command -v jq &> /dev/null; then
        if [[ -f "$CACHE_INDEX" ]]; then
            local hits=$(jq -r '.metadata.hits // 0' "$CACHE_INDEX")
            local misses=$(jq -r '.metadata.misses // 0' "$CACHE_INDEX")
            local total=$((hits + misses))

            if [[ $total -gt 0 ]]; then
                local hit_rate=$(( (hits * 100) / total ))
                echo "  Cache Hits: ${hits}"
                echo "  Cache Misses: ${misses}"
                echo "  Hit Rate: ${hit_rate}%"
            fi
        fi
    fi
}

# Warm cache with common queries
warm_cache() {
    echo -e "${BLUE}Pre-warming cache with common queries...${NC}"

    local queries=(
        "context-mode"
        "semantic search"
        "testing"
        "gdpr"
        "performance"
        "architecture"
        "event sourcing"
        "actions"
    )

    init_cache

    for query in "${queries[@]}"; do
        echo -n "  Caching '$query'... "

        # Generate cache filename from query hash
        local hash=$(echo -n "$query" | sha256sum | cut -d' ' -f1)
        local cache_file="${CACHE_DIR}/${hash}.json"

        # Execute search and cache result
        if "$SCRIPT_DIR/wiki-search" "$query" > "$cache_file" 2>/dev/null; then
            echo -e "${GREEN}✓${NC}"
        else
            echo -e "${RED}✗${NC}"
        fi
    done

    echo -e "${GREEN}Cache warming complete${NC}"
}

# Monitor cache effectiveness (runs continuous monitoring)
monitor_cache() {
    echo -e "${BLUE}Cache Monitor (Ctrl+C to stop)${NC}"
    echo ""

    init_cache

    echo -e "${BLUE}Monitoring cache hits and misses...${NC}"

    # Display header
    printf "${BLUE}%-40s %10s %10s %10s${NC}\n" "Query" "Hits" "Misses" "Hit Rate"
    echo "-----------------------------------------------------------"

    local prev_hits=0
    local prev_misses=0

    while true; do
        if [[ -f "$CACHE_INDEX" ]]; then
            local hits=$(jq -r '.metadata.hits // 0' "$CACHE_INDEX")
            local misses=$(jq -r '.metadata.misses // 0' "$CACHE_INDEX")

            if [[ $((hits + misses)) -gt 0 ]]; then
                local hit_rate=$(( (hits * 100) / (hits + misses) ))
                printf "%-40s %10d %10d %9d%%\n" "Total" "$hits" "$misses" "$hit_rate"
            fi
        fi

        sleep 5
    done
}

# Parse arguments
case "${1:-}" in
    init)
        init_cache
        ;;
    clear)
        clear_cache
        ;;
    stats)
        show_stats
        ;;
    warm)
        warm_cache
        ;;
    monitor)
        monitor_cache
        ;;
    *)
        cat << 'EOF'
Wiki Search Cache Manager

USAGE:
  cache-manager.sh [COMMAND]

COMMANDS:
  init              Initialize cache system
  clear             Clear all cached results
  stats             Show cache statistics and hit rates
  warm              Pre-warm cache with common queries
  monitor           Monitor cache performance (continuous)

EXAMPLES:
  # Initialize cache
  ./cache-manager.sh init

  # Pre-warm cache
  ./cache-manager.sh warm

  # Check cache stats
  ./cache-manager.sh stats

  # Monitor cache in real-time
  ./cache-manager.sh monitor

CACHE LOCATION:
  ${PROJECT_ROOT}/.cache/wiki-search
EOF
        ;;
esac
