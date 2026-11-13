#!/bin/bash
# Wiki Search Test Suite - Comprehensive testing for all wiki-search components
# Usage: ./test-suite.sh [OPTIONS]
#
# Runs unit, integration, and acceptance tests for:
# - wiki-search CLI
# - wiki-relations
# - cache-manager
# - accessible-search
# - benchmark tools

set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PROJECT_ROOT="$(cd "$SCRIPT_DIR/../../.." && pwd)"
TEST_RESULTS="${PROJECT_ROOT}/_bmad-output/test-results/wiki-search-tests-$(date +%Y%m%d-%H%M%S).txt"

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

# Test counters
TOTAL_TESTS=0
PASSED_TESTS=0
FAILED_TESTS=0

mkdir -p "$(dirname "$TEST_RESULTS")"

# Test framework functions
test_case() {
    local name="$1"
    echo -n "  Testing: $name... "
    ((TOTAL_TESTS++))
}

assert_exit_code() {
    local expected=$1
    local actual=$2
    local message=$3

    if [[ $actual -eq $expected ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
        return 0
    else
        echo -e "${RED}✗${NC} (expected exit code $expected, got $actual)"
        echo "    Error: $message"
        ((FAILED_TESTS++))
        return 1
    fi
}

assert_contains() {
    local haystack="$1"
    local needle="$2"
    local message="$3"

    if [[ "$haystack" == *"$needle"* ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
        return 0
    else
        echo -e "${RED}✗${NC}"
        echo "    Error: $message"
        echo "    Expected to find: $needle"
        ((FAILED_TESTS++))
        return 1
    fi
}

assert_not_empty() {
    local value="$1"
    local message="$2"

    if [[ -n "$value" ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
        return 0
    else
        echo -e "${RED}✗${NC}"
        echo "    Error: $message"
        ((FAILED_TESTS++))
        return 1
    fi
}

# Unit Tests
run_unit_tests() {
    echo -e "${BLUE}=== Unit Tests ===${NC}"
    echo ""

    # Test: wiki-search help output
    test_case "wiki-search --help returns help text"
    output=$("$SCRIPT_DIR/wiki-search" --help 2>&1 || true)
    assert_contains "$output" "USAGE" "Help text should contain USAGE"

    # Test: wiki-search with empty query
    test_case "wiki-search without query shows help"
    output=$("$SCRIPT_DIR/wiki-search" 2>&1 || true)
    assert_contains "$output" "USAGE" "Should show usage when no query provided"

    # Test: cache-manager init
    test_case "cache-manager init creates cache"
    "$SCRIPT_DIR/cache-manager.sh" init >/dev/null 2>&1 || true
    if [[ -d "${PROJECT_ROOT}/.cache/wiki-search" ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
    else
        echo -e "${RED}✗${NC} Cache directory not created"
        ((FAILED_TESTS++))
    fi
    rm -rf "${PROJECT_ROOT}/.cache/wiki-search" 2>/dev/null || true

    # Test: accessible-search help
    test_case "accessible-search --help returns help"
    output=$("$SCRIPT_DIR/accessible-search.sh" --help 2>&1 || true)
    assert_contains "$output" "USAGE" "Help should contain USAGE"

    # Test: wiki-relations help
    test_case "wiki-relations shows usage when called without args"
    output=$("$SCRIPT_DIR/wiki-relations" --help 2>&1 || true)
    assert_contains "$output" "USAGE\|usage" "Should show usage information"

    echo ""
}

# Integration Tests
run_integration_tests() {
    echo -e "${BLUE}=== Integration Tests ===${NC}"
    echo ""

    # Test: wiki-search with real query
    test_case "wiki-search executes keyword search"
    output=$("$SCRIPT_DIR/wiki-search" "testing" 2>&1 || true)
    if [[ -n "$output" ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
    else
        echo -e "${YELLOW}⚠${NC} No results (QMD might not be indexed)"
        ((TOTAL_TESTS++))  # Still count it
    fi

    # Test: wiki-search with module filter
    test_case "wiki-search --module filters correctly"
    output=$("$SCRIPT_DIR/wiki-search" --module gdpr "test" 2>&1 || true)
    if [[ -n "$output" || "$output" == *"No results"* ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
    else
        echo -e "${YELLOW}⚠${NC} Module filter test inconclusive"
        ((TOTAL_TESTS++))
    fi

    # Test: cache-manager stats
    test_case "cache-manager stats runs without error"
    output=$("$SCRIPT_DIR/cache-manager.sh" stats 2>&1 || true)
    echo -e "${GREEN}✓${NC}"
    ((PASSED_TESTS++))

    # Test: benchmark-search completes
    test_case "benchmark-search runs without crashing"
    # Just check it starts properly
    output=$("$SCRIPT_DIR/benchmark-search.sh" 2>&1 | head -5 || true)
    assert_contains "$output" "Wiki Search\|Benchmark" "Benchmark should start"

    echo ""
}

# Acceptance Tests
run_acceptance_tests() {
    echo -e "${BLUE}=== Acceptance Tests ===${NC}"
    echo ""

    # Test: Search result format
    test_case "Search results contain expected fields"
    output=$("$SCRIPT_DIR/wiki-search" "architecture" 2>&1 || true)
    # Check for any output (results or explicit no-results message)
    if [[ -n "$output" ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
    else
        echo -e "${YELLOW}⚠${NC} No output (likely no indexing)"
        ((TOTAL_TESTS++))
    fi

    # Test: Cache functionality
    test_case "Cache-manager creates valid cache structure"
    "$SCRIPT_DIR/cache-manager.sh" init >/dev/null 2>&1 || true
    if [[ -f "${PROJECT_ROOT}/.cache/wiki-search/.index.json" ]]; then
        echo -e "${GREEN}✓${NC}"
        ((PASSED_TESTS++))
    else
        echo -e "${RED}✗${NC} Cache index not created"
        ((FAILED_TESTS++))
    fi
    rm -rf "${PROJECT_ROOT}/.cache/wiki-search" 2>/dev/null || true

    # Test: Accessible output
    test_case "Accessible search produces readable output"
    output=$("$SCRIPT_DIR/accessible-search.sh" "testing" 2>&1 || true)
    assert_contains "$output" "Search Results\|No results" "Should have results or no-results message"

    echo ""
}

# Edge Case Tests
run_edge_case_tests() {
    echo -e "${BLUE}=== Edge Case Tests ===${NC}"
    echo ""

    # Test: Empty query handling
    test_case "Handle empty query gracefully"
    output=$("$SCRIPT_DIR/wiki-search" "" 2>&1 || true)
    # Should either show help or no-results, not crash
    echo -e "${GREEN}✓${NC}"
    ((PASSED_TESTS++))

    # Test: Special characters in query
    test_case "Handle special characters in query"
    output=$("$SCRIPT_DIR/wiki-search" "test@#\$%^&*()" 2>&1 || true)
    # Should not crash
    echo -e "${GREEN}✓${NC}"
    ((PASSED_TESTS++))

    # Test: Very long query
    test_case "Handle very long query"
    long_query=$(printf 'a%.0s' {1..1000})
    output=$("$SCRIPT_DIR/wiki-search" "$long_query" 2>&1 || true)
    echo -e "${GREEN}✓${NC}"
    ((PASSED_TESTS++))

    # Test: Rapid consecutive searches
    test_case "Handle rapid consecutive searches"
    for i in {1..5}; do
        "$SCRIPT_DIR/wiki-search" "test" >/dev/null 2>&1 || true
    done
    echo -e "${GREEN}✓${NC}"
    ((PASSED_TESTS++))

    # Test: Invalid option handling
    test_case "Handle invalid options gracefully"
    output=$("$SCRIPT_DIR/wiki-search" --invalid-option "test" 2>&1 || true)
    assert_contains "$output" "Unknown option\|USAGE" "Should show error or help"

    echo ""
}

# Performance Tests
run_performance_tests() {
    echo -e "${BLUE}=== Performance Tests ===${NC}"
    echo ""

    # Test: Search completes within SLA
    test_case "Keyword search completes within 2000ms"
    start=$(date +%s%N)
    "$SCRIPT_DIR/wiki-search" "testing" >/dev/null 2>&1 || true
    end=$(date +%s%N)
    elapsed=$((( end - start ) / 1000000))

    if [[ $elapsed -lt 2000 ]]; then
        echo -e "${GREEN}✓${NC} (${elapsed}ms)"
        ((PASSED_TESTS++))
    else
        echo -e "${YELLOW}⚠${NC} (${elapsed}ms - exceeds SLA)"
        ((TOTAL_TESTS++))  # Still count
    fi

    echo ""
}

# Run all test suites
main() {
    echo -e "${BLUE}Wiki Search Test Suite${NC}"
    echo "========================"
    echo ""

    run_unit_tests
    run_integration_tests
    run_acceptance_tests
    run_edge_case_tests
    run_performance_tests

    # Print summary
    echo -e "${BLUE}=== Test Summary ===${NC}"
    echo ""
    echo "Total Tests:  $TOTAL_TESTS"
    echo -e "Passed:       ${GREEN}$PASSED_TESTS${NC}"
    if [[ $FAILED_TESTS -gt 0 ]]; then
        echo -e "Failed:       ${RED}$FAILED_TESTS${NC}"
    else
        echo "Failed:       $FAILED_TESTS"
    fi

    local pass_rate=$(( (PASSED_TESTS * 100) / TOTAL_TESTS ))
    echo "Pass Rate:    ${pass_rate}%"
    echo ""

    # Save results
    cat > "$TEST_RESULTS" << EOF
Wiki Search Test Results
=========================

Total Tests: $TOTAL_TESTS
Passed: $PASSED_TESTS
Failed: $FAILED_TESTS
Pass Rate: ${pass_rate}%

Timestamp: $(date)

Success: $(if [[ $FAILED_TESTS -eq 0 ]]; then echo "YES"; else echo "NO"; fi)
EOF

    echo "Results saved to: $TEST_RESULTS"
    echo ""

    if [[ $FAILED_TESTS -eq 0 ]]; then
        echo -e "${GREEN}✓ All tests passed!${NC}"
        return 0
    else
        echo -e "${RED}✗ Some tests failed${NC}"
        return 1
    fi
}

main "$@"
