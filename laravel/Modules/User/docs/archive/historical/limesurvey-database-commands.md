# Database Analysis Commands and Tools for quaeris_survey

## Essential Database Queries

### 1. Survey Structure Analysis
```sql
-- List all active surveys in the database
SELECT sid, surveyls_title, startdate, expires 
FROM lime_surveys 
WHERE active = 'Y';

-- Get all questions for a specific survey
SELECT q.qid, q.type, q.title, q.question, ql.question as text
FROM lime_questions q
LEFT JOIN lime_question_l10ns ql ON ql.qid = q.qid
WHERE q.sid = [SURVEY_ID]
ORDER BY q.group_order, q.question_order;

-- Identify sub-questions (child questions)
SELECT q.qid, q.parent_qid, q.title, ql.question
FROM lime_questions q
LEFT JOIN lime_question_l10ns ql ON ql.qid = q.qid  
WHERE q.parent_qid IS NOT NULL
AND q.sid = [SURVEY_ID];
```

### 2. Response Data Analysis
```sql
-- Count total responses for a survey
SELECT COUNT(*) as total_responses
FROM lime_survey_[SURVEY_ID]
WHERE submitdate IS NOT NULL;

-- Get response statistics by date range
SELECT 
    DATE(submitdate) as response_date,
    COUNT(*) as daily_responses
FROM lime_survey_[SURVEY_ID]
WHERE submitdate BETWEEN '2023-01-01' AND '2023-12-31'
GROUP BY DATE(submitdate)
ORDER BY response_date;

-- Analyze specific question responses
SELECT [FIELD_NAME], COUNT(*) as count
FROM lime_survey_[SURVEY_ID]
WHERE [FIELD_NAME] IS NOT NULL
GROUP BY [FIELD_NAME]
ORDER BY count DESC;
```

### 3. Participant Analysis
```sql
-- Check token usage for a survey
SELECT 
    COUNT(*) as total_tokens,
    SUM(CASE WHEN sent != 'N' THEN 1 ELSE 0 END) as tokens_sent,
    SUM(CASE WHEN completed != 'N' THEN 1 ELSE 0 END) as responses_completed
FROM lime_tokens_[SURVEY_ID];

-- Identify incomplete responses
SELECT t.token, t.firstname, t.lastname, t.email
FROM lime_tokens_[SURVEY_ID] t
LEFT JOIN lime_survey_[SURVEY_ID] s ON t.token = s.token
WHERE t.completed = 'N' AND s.id IS NOT NULL;
```

## MCP Tools for Database Operations

### 1. MySQL MCP Commands
```bash
# Connect to specific database
mcp mysql --database=txaesfry_quaeris_survey

# Execute complex queries
mcp mysql --query="SELECT table_name FROM information_schema.tables WHERE table_schema = 'txaesfry_quaeris_survey' AND table_name LIKE 'lime_survey_%'"

# Export survey data
mcp mysql --export --table=lime_survey_139982 --format=csv
```

### 2. Laravel Tinker for Analysis
```php
// Check survey table existence
$surveyId = 139982;
$tableName = "lime_survey_{$surveyId}";
$exists = DB::connection('limesurvey')->getSchemaBuilder()->hasTable($tableName);

// Count responses with date filtering
$responses = DB::connection('limesurvey')
    ->table($tableName)
    ->whereNotNull('submitdate')
    ->whereBetween('submitdate', ['2023-01-01', '2023-12-31'])
    ->count();

// Get unique participants
$uniqueParticipants = DB::connection('limesurvey')
    ->table($tableName)
    ->whereNotNull('submitdate')
    ->distinct()
    ->count('id');
```

### 3. Configuration Verification
```bash
# Check database connection settings
php artisan tinker --execute="DB::connection('limesurvey')->select('SELECT 1')"

# Verify all required connections
php artisan tinker --execute="
[
    'limesurvey' => DB::connection('limesurvey')->getPdo() ? 'OK' : 'ERROR',
    'quaeris' => DB::connection('quaeris')->getPdo() ? 'OK' : 'ERROR',
    'mysql' => DB::connection('mysql')->getPdo() ? 'OK' : 'ERROR'
]
"
```

## Performance Optimization

### 1. Index Analysis
```sql
-- Check indexes on survey tables
SHOW INDEX FROM lime_survey_[SURVEY_ID];

-- Most important indexes for performance
-- 1. submitdate (for date filtering)
-- 2. token (for participant joins)
-- 3. ID primary key
```

### 2. Query Optimization
```sql
-- Use EXPLAIN to analyze slow queries
EXPLAIN SELECT COUNT(*) FROM lime_survey_[SURVEY_ID] WHERE submitdate > '2023-01-01';

-- Optimize large table queries
SELECT SQL_CALC_FOUND_ROWS * FROM lime_survey_[SURVEY_ID] LIMIT 0, 1000;
SELECT FOUND_ROWS();
```

## Data Integrity Checks

### 1. Survey Consistency
```sql
-- Verify token-response matching
SELECT 
    t.token,
    CASE WHEN s.token IS NULL THEN 'NO_RESPONSE' ELSE 'RESPONDED' END as status
FROM lime_tokens_[SURVEY_ID] t
LEFT JOIN lime_survey_[SURVEY_ID] s ON t.token = s.token;
```

### 2. Question-Response Mapping
```sql
-- Identify orphaned responses
SELECT DISTINCT field_name
FROM (
    SELECT column_name as field_name
    FROM information_schema.columns
    WHERE table_name = 'lime_survey_[SURVEY_ID]'
    AND column_name LIKE '[SURVEY_ID]%X%X%'
) as survey_fields
LEFT JOIN lime_questions q ON CONCAT(q.sid, 'X', q.gid, 'X', q.qid) = field_name
WHERE q.qid IS NULL;
```

## Backup and Recovery

### 1. Survey Data Backup
```bash
# Backup specific survey data
mysqldump -u[user] -p[pass] txaesfry_quaeris_survey lime_survey_[SURVEY_ID] > survey_[SURVEY_ID].sql

# Backup question structure
mysqldump -u[user] -p[pass] txaesfry_quaeris_survey lime_questions lime_question_l10ns --where="sid=[SURVEY_ID]" > survey_[SURVEY_ID]_structure.sql
```

### 2. Data Validation Script
```php
// Validate survey data integrity
function validateSurveyData($surveyId) {
    $responseTable = "lime_survey_{$surveyId}";
    $tokenTable = "lime_tokens_{$surveyId}";
    
    $responses = DB::connection('limesurvey')->table($responseTable)->count();
    $tokens = DB::connection('limesurvey')->table($tokenTable)->count();
    $questions = DB::connection('limesurvey')
        ->table('lime_questions')
        ->where('sid', $surveyId)
        ->count();
    
    return [
        'responses' => $responses,
        'tokens' => $tokens,
        'questions' => $questions,
        'valid' => $responses >= 0 && $tokens >= 0 && $questions > 0
    ];
}
```

## Monitoring and Maintenance

### 1. Regular Checks
```sql
-- Monitor survey response rates
SELECT 
    s.sid,
    s.surveyls_title,
    COALESCE(t.total_tokens, 0) as total_tokens,
    COALESCE(r.responses, 0) as total_responses,
    ROUND(COALESCE(r.responses, 0) * 100.0 / NULLIF(t.total_tokens, 0), 2) as response_rate
FROM lime_surveys s
LEFT JOIN (
    SELECT 
        SUBSTRING(table_name, 13) as sid,  -- Extract survey ID from lime_survey_XXXX
        COUNT(*) as responses
    FROM information_schema.tables 
    WHERE table_name LIKE 'lime_survey_%'
    AND table_schema = 'txaesfry_quaeris_survey'
) r ON s.sid = r.sid
LEFT JOIN (
    SELECT 
        SUBSTRING(table_name, 12) as sid,  -- Extract survey ID from lime_tokens_XXXX
        COUNT(*) as total_tokens
    FROM information_schema.tables 
    WHERE table_name LIKE 'lime_tokens_%'
    AND table_schema = 'txaesfry_quaeris_survey'
) t ON s.sid = t.sid
WHERE s.active = 'Y';
```

These commands and tools provide comprehensive access to analyze, maintain, and optimize the quaeris_survey database used by the Limesurvey integration.