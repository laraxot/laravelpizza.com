#!/usr/bin/env bash

#######################################
# MCP Servers Verification Script
# Laravel Pizza Meetups Project
#######################################

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Project root
PROJECT_ROOT="/var/www/_bases/base_laravelpizza/laravel"

echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${BLUE}  MCP Servers Verification - Laravel Pizza Meetups${NC}"
echo -e "${BLUE}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""

#######################################
# 1. Check if .mcp.json exists
#######################################
echo -e "${YELLOW}[1/7]${NC} Checking .mcp.json configuration..."
if [ -f "$PROJECT_ROOT/.mcp.json" ]; then
    echo -e "      ${GREEN}✓${NC} .mcp.json found"
    # Validate JSON syntax
    if jq empty "$PROJECT_ROOT/.mcp.json" 2>/dev/null; then
        echo -e "      ${GREEN}✓${NC} Valid JSON syntax"
    else
        echo -e "      ${RED}✗${NC} Invalid JSON syntax"
        exit 1
    fi
else
    echo -e "      ${RED}✗${NC} .mcp.json not found"
    echo -e "      ${YELLOW}ℹ${NC} Run: cp .mcp.json.example .mcp.json"
    exit 1
fi

#######################################
# 2. Check Node.js and npx
#######################################
echo -e "${YELLOW}[2/7]${NC} Checking Node.js environment..."
if command -v node &> /dev/null; then
    NODE_VERSION=$(node --version)
    echo -e "      ${GREEN}✓${NC} Node.js installed: $NODE_VERSION"

    # Check version >= 18
    MAJOR_VERSION=$(echo "$NODE_VERSION" | cut -d'v' -f2 | cut -d'.' -f1)
    if [ "$MAJOR_VERSION" -ge 18 ]; then
        echo -e "      ${GREEN}✓${NC} Node.js version is compatible (>= 18.x)"
    else
        echo -e "      ${YELLOW}⚠${NC} Node.js version may be too old (recommended >= 18.x)"
    fi
else
    echo -e "      ${RED}✗${NC} Node.js not installed"
    echo -e "      ${YELLOW}ℹ${NC} Install: sudo apt install nodejs npm"
    exit 1
fi

if command -v npx &> /dev/null; then
    echo -e "      ${GREEN}✓${NC} npx available"
else
    echo -e "      ${RED}✗${NC} npx not found"
    exit 1
fi

#######################################
# 3. Check Claude CLI
#######################################
echo -e "${YELLOW}[3/7]${NC} Checking Claude Code CLI..."
if command -v claude &> /dev/null; then
    CLAUDE_VERSION=$(claude --version 2>&1 | head -n1 || echo "unknown")
    echo -e "      ${GREEN}✓${NC} Claude CLI installed: $CLAUDE_VERSION"
else
    echo -e "      ${RED}✗${NC} Claude CLI not installed"
    echo -e "      ${YELLOW}ℹ${NC} Install: https://code.claude.com"
    exit 1
fi

#######################################
# 4. Check SQLite Database
#######################################
echo -e "${YELLOW}[4/7]${NC} Checking SQLite database..."
DB_PATH="$PROJECT_ROOT/database/database.sqlite"
if [ -f "$DB_PATH" ]; then
    DB_SIZE=$(du -h "$DB_PATH" | cut -f1)
    echo -e "      ${GREEN}✓${NC} Database exists: $DB_PATH"
    echo -e "      ${GREEN}✓${NC} Database size: $DB_SIZE"

    # Check if database is readable
    if sqlite3 "$DB_PATH" "SELECT 1;" &> /dev/null; then
        echo -e "      ${GREEN}✓${NC} Database is readable"

        # Count tables
        TABLE_COUNT=$(sqlite3 "$DB_PATH" "SELECT COUNT(*) FROM sqlite_master WHERE type='table';" 2>/dev/null || echo "0")
        echo -e "      ${GREEN}✓${NC} Tables found: $TABLE_COUNT"
    else
        echo -e "      ${RED}✗${NC} Database is not readable (may be corrupt)"
    fi
else
    echo -e "      ${YELLOW}⚠${NC} Database not found: $DB_PATH"
    echo -e "      ${YELLOW}ℹ${NC} Run: php artisan migrate"
fi

#######################################
# 5. Check Project Structure
#######################################
echo -e "${YELLOW}[5/7]${NC} Checking project structure..."
CHECKS=(
    "Modules/Meetup:Meetup Module"
    "Themes/Meetup:Meetup Theme"
    "config/local/laravelpizza:LaravelPizza Config"
    "Modules/Meetup/docs:Meetup Docs"
)

for CHECK in "${CHECKS[@]}"; do
    PATH_TO_CHECK=$(echo "$CHECK" | cut -d':' -f1)
    DESC=$(echo "$CHECK" | cut -d':' -f2)

    if [ -d "$PROJECT_ROOT/$PATH_TO_CHECK" ]; then
        echo -e "      ${GREEN}✓${NC} $DESC exists"
    else
        echo -e "      ${YELLOW}⚠${NC} $DESC not found: $PATH_TO_CHECK"
    fi
done

#######################################
# 6. Test MCP Package Availability
#######################################
echo -e "${YELLOW}[6/7]${NC} Testing MCP packages availability..."

# Test filesystem server package
echo -e "      ${BLUE}↓${NC} Testing @modelcontextprotocol/server-filesystem..."
if npx -y @modelcontextprotocol/server-filesystem --version &> /dev/null || npx -y @modelcontextprotocol/server-filesystem --help &> /dev/null 2>&1; then
    echo -e "      ${GREEN}✓${NC} Filesystem server package available"
else
    echo -e "      ${YELLOW}⚠${NC} Filesystem server may not be properly installed"
fi

# Test database server package
echo -e "      ${BLUE}↓${NC} Testing @bytebase/dbhub..."
if npx -y @bytebase/dbhub --version &> /dev/null || npx -y @bytebase/dbhub --help &> /dev/null 2>&1; then
    echo -e "      ${GREEN}✓${NC} Database server package available"
else
    echo -e "      ${YELLOW}⚠${NC} Database server may not be properly installed"
fi

#######################################
# 7. Summary & Next Steps
#######################################
echo -e "${YELLOW}[7/7]${NC} Summary"
echo ""
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo -e "${GREEN}  ✓ MCP Setup Verification Complete${NC}"
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
echo ""
echo -e "${BLUE}Next Steps:${NC}"
echo ""
echo -e "  1. List configured MCP servers:"
echo -e "     ${YELLOW}claude mcp list${NC}"
echo ""
echo -e "  2. Launch Claude Code:"
echo -e "     ${YELLOW}claude${NC}"
echo ""
echo -e "  3. Test MCP servers inside Claude Code:"
echo -e "     ${YELLOW}/mcp${NC} (to see server status)"
echo ""
echo -e "  4. Test filesystem server:"
echo -e "     ${YELLOW}> \"Show me the APP_NAME from .env\"${NC}"
echo ""
echo -e "  5. Test database server:"
echo -e "     ${YELLOW}> \"How many tables are in the database?\"${NC}"
echo ""
echo -e "  6. Authenticate GitHub (optional):"
echo -e "     ${YELLOW}/mcp${NC} → Select GitHub → Authenticate"
echo ""
echo -e "${BLUE}Documentation:${NC}"
echo -e "  → Modules/Meetup/docs/mcp-servers-setup.md"
echo ""
echo -e "${GREEN}━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━${NC}"
