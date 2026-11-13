#!/bin/bash
# Wiki Search Benchmark - Measure performance of wiki-search under various conditions
# Usage: ./benchmark-search.sh [OPTIONS]
#
# Runs comprehensive benchmarks for keyword and semantic search,
# measures indexing time, and generates performance reports.

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../../.." && pwd)"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m'

# Defaults
RESULTS_FILE="${PROJECT_ROOT}/_bmad-output/performance/search-benchmark-$(date +%Y%m%d-%H%M%S).json"
VERBOSE=false
SAMPLE_QUERIES=(
    "context-mode"
    "semantic search"
    "user permissions"
    "gdpr consent"
    "event sourcing"
    "actions over services"
    "architectural patterns"
    "testing strategies"
)

mkdir -p "$(dirname "$RESULTS_FILE")"

# Benchmark functions
benchmark_keyword_search() {
    local query="$1"
    local runs=5
    local total_ms=0
    local times=()

    echo -n "  Benchmarking keyword: '$query'... "

    for ((i=1; i<=runs; i++)); do
        START=$(date +%s%N)
        "$SCRIPT_DIR/wiki-search" "$query" >/dev/null 2>&1 || true
        END=$(date +%s%N)
        ms=$(( (END - START) / 1000000 ))
        times+=($ms)
        total_ms=$((total_ms + ms))
    done

    local avg=$((total_ms / runs))
    echo "${GREEN}avg ${avg}ms (${times[@]})${NC}"
    echo $avg
}

benchmark_semantic_search() {
    local query="$1"
    local runs=3
    local total_ms=0
    local times=()

    echo -n "  Benchmarking semantic: '$query'... "

    for ((i=1; i<=runs; i++)); do
        START=$(date +%s%N)
        "$SCRIPT_DIR/wiki-search" --semantic "$query" >/dev/null 2>&1 || true
        END=$(date +%s%N)
        ms=$(( (END - START) / 1000000 ))
        times+=($ms)
        total_ms=$((total_ms + ms))
    done

    local avg=$((total_ms / runs))
    echo "${GREEN}avg ${avg}ms (${times[@]})${NC}"
    echo $avg
}

benchmark_module_search() {
    local module="$1"
    local query="testing"
    local runs=5
    local total_ms=0

    echo -n "  Benchmarking module '$module': '$query'... "

    for ((i=1; i<=runs; i++)); do
        START=$(date +%s%N)
        "$SCRIPT_DIR/wiki-search" --module "$module" "$query" >/dev/null 2>&1 || true
        END=$(date +%s%N)
        ms=$(( (END - START) / 1000000 ))
        total_ms=$((total_ms + ms))
    done

    local avg=$((total_ms / runs))
    echo "${GREEN}avg ${avg}ms${NC}"
    echo $avg
}

# Get collection stats
get_collection_stats() {
    echo -e "${BLUE}Collection Statistics:${NC}"
    echo "  Checking QMD status..."
    qmd status 2>/dev/null || echo "  QMD not initialized"
}

# Main benchmarking
echo -e "${BLUE}Wiki Search Performance Benchmark${NC}"
echo "=================================="
echo ""

echo -e "${BLUE}Starting benchmarks...${NC}"
echo ""

# Get baseline stats
get_collection_stats
echo ""

# Keyword search benchmarks
echo -e "${BLUE}Keyword Search Benchmarks:${NC}"
keyword_results=()
for query in "${SAMPLE_QUERIES[@]}"; do
    avg=$(benchmark_keyword_search "$query")
    keyword_results+=($avg)
done
echo ""

# Semantic search benchmarks
echo -e "${BLUE}Semantic Search Benchmarks:${NC}"
semantic_results=()
for query in "${SAMPLE_QUERIES[@]:0:3}"; do
    avg=$(benchmark_semantic_search "$query")
    semantic_results+=($avg)
done
echo ""

# Module-specific search benchmarks
echo -e "${BLUE}Module-Specific Search Benchmarks:${NC}"
module_results=()
for module in "gdpr" "activity" "user"; do
    if [[ -d "$PROJECT_ROOT/laravel/Modules/$module" ]]; then
        avg=$(benchmark_module_search "$module")
        module_results+=($avg)
    fi
done
echo ""

# Calculate statistics
calc_stats() {
    local -n arr=$1
    if [[ ${#arr[@]} -eq 0 ]]; then
        echo "N/A"
        return
    fi

    local sum=0
    local min=${arr[0]}
    local max=${arr[0]}

    for val in "${arr[@]}"; do
        sum=$((sum + val))
        [[ $val -lt $min ]] && min=$val
        [[ $val -gt $max ]] && max=$val
    done

    local avg=$((sum / ${#arr[@]}))
    echo "avg: ${avg}ms, min: ${min}ms, max: ${max}ms"
}

# Summary
echo -e "${BLUE}Performance Summary:${NC}"
echo "  Keyword Search:     $(calc_stats keyword_results)"
echo "  Semantic Search:    $(calc_stats semantic_results)"
echo "  Module Search:      $(calc_stats module_results)"
echo ""

# Performance targets
echo -e "${BLUE}Performance Targets:${NC}"
keyword_avg=$((${keyword_results[0]:-0} + ${keyword_results[1]:-0} + ${keyword_results[2]:-0}) / 3)
semantic_avg=$((${semantic_results[0]:-0} + ${semantic_results[1]:-0}) / 2)

if [[ $keyword_avg -lt 2000 ]]; then
    echo -e "  ${GREEN}✓ Keyword search meets target (< 2000ms)${NC}"
else
    echo -e "  ${RED}✗ Keyword search exceeds target (${keyword_avg}ms > 2000ms)${NC}"
fi

if [[ $semantic_avg -lt 2000 ]]; then
    echo -e "  ${GREEN}✓ Semantic search meets target (< 2000ms)${NC}"
else
    echo -e "  ${YELLOW}⚠ Semantic search near/exceeds target (${semantic_avg}ms >= 2000ms)${NC}"
fi

echo ""
echo -e "${GREEN}Benchmark complete. Results can be analyzed for optimization targets.${NC}"
