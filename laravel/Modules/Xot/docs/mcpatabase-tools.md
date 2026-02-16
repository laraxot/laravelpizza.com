# MCP (Management Control Panel) Tools for Database Analysis

## Overview
MCP (Model Context Protocol) tools provide enhanced capabilities for database analysis, including access to the quaeris_survey database used in the Limesurvey integration.

## Available MCP Tools for Database Work

### 1. MySQL MCP Server
**Purpose**: Direct MySQL database access using credentials from Laravel .env file
**Configuration**:
```json
{
  "command": "node",
  "args": [
    "/var/www/_bases/base_techplanner_fila4_mono/bashscripts/mcp/mysql-db-connector.js"
  ]
}
```

**Use Cases for quaeris_survey Database**:
- Query Limesurvey tables directly
- Analyze survey responses in `lime_survey_{sid}` tables
- Examine question structures in `lime_questions`
- Inspect participant tokens in `lime_tokens_{sid}`
- Verify answer mappings in `lime_answers`

### 2. Filesystem MCP Server
**Purpose**: File system operations for Laravel project
**Use Cases**:
- Access configuration files (database credentials)
- Read/write application logs
- Manage migration files
- Access model definitions

### 3. Laravel Boost MCP
**Purpose**: Native Laravel integration
**Use Cases**:
- Run artisan commands for database operations
- Execute tinker sessions for database exploration
- Run migrations and seeders
- Query database using Eloquent

### 4. Sequential Thinking MCP
**Purpose**: Extended reasoning for complex analysis
**Use Cases**:
- Complex query analysis
- Database relationship mapping
- Performance optimization strategies

## Database Analysis Commands

### Direct Database Queries (using MySQL MCP)
```sql
-- List all survey tables in quaeris_survey database
SHOW TABLES LIKE 'lime_survey_%';

-- Analyze question structure
SELECT qid, sid, gid, type, title FROM lime_questions WHERE sid = [survey_id];

-- Check survey responses
SELECT * FROM lime_survey_[survey_id] LIMIT 10;

-- Examine answer options
SELECT aid, qid, code, answer FROM lime_answers WHERE qid = [question_id];
```

### Laravel Tinker Commands
```php
// Connect to specific database
DB::connection('limesurvey')->select('SHOW TABLES');

// Query survey data
DB::connection('limesurvey')->table('lime_survey_139982')->get();

// Analyze question translations
DB::connection('limesurvey')->table('lime_question_l10ns')->where('qid', 543)->first();
```

## Installation Requirements

### Node.js Dependencies
```bash
# Install global packages
npm install -g mysql2
npm install -g @modelcontextprotocol/server-mysql
```

### Laravel Configuration
Ensure database connections are properly configured in:
- `config/database.php`
- Environment files with proper credentials

## MCP Configuration File
Location: `~/.cursor/mcp.json`

Current configuration includes MySQL access that automatically uses Laravel's .env credentials, making it ideal for accessing the quaeris_survey database without additional configuration.

## Best Practices for Database Analysis

1. **Always verify survey IDs** before querying dynamic tables like `lime_survey_{id}`
2. **Use proper connection** (`limesurvey` connection for quaeris_survey database)
3. **Limit result sets** when exploring large survey response tables
4. **Check table existence** before querying survey-specific tables
5. **Respect data privacy** when handling survey responses

## Troubleshooting

### MCP Server not responding
- Verify node version (should be >= 18)
- Check if required npm packages are installed
- Ensure Laravel .env file contains correct database credentials

### MySQL MCP connection issues
- Verify database server is running
- Check database credentials in .env file
- Ensure MySQL MCP server script exists at specified path