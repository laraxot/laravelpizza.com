# Limesurvey Survey Data Analysis - Database Deep Dive

## Database Connections Overview

The system utilizes three main database connections:

### 1. Limesurvey Database (`limesurvey` connection)
- **Schema**: `txaesfry_quaeris_survey` 
- **Purpose**: Main Limesurvey installation with surveys, questions, and responses
- **Key tables**: 
  - `lime_questions` - Question structure and metadata
  - `lime_question_l10ns` - Question translations
  - `lime_survey_{sid}` - Dynamic survey response tables (one per survey)
  - `lime_tokens_{sid}` - Participant tokens and status tracking
  - `lime_answers` - Possible answer options
  - `lime_answer_l10ns` - Answer translations

### 2. Quaeris Database (`quaeris` connection) 
- **Purpose**: Application-specific data including survey mappings
- **Key tables**:
  - `survey_pdfs` - Links Limesurvey surveys to Quaeris functionality
  - `question_charts` - Custom chart configurations for survey data
  - `charts` - Chart visualization settings
  - `contacts` - Participant contact and communication tracking

### 3. Default Database (`mysql` connection)
- **Purpose**: Core application data storage
- **Contains**: User management, authentication, etc.

## Survey Data Flow Analysis

### Data Extraction Process
1. **Survey Identification**: System identifies target survey by `survey_id` (sid)
2. **Question Structure**: Retrieves question definitions from `lime_questions` and `lime_question_l10ns`
3. **Response Data**: Extracts responses from `lime_survey_{sid}` table
4. **Participant Info**: Joins with `lime_tokens_{sid}` for participant details
5. **Answer Mapping**: Links response codes to actual answer text via `lime_answers`

### Dynamic Table Naming
- Survey response tables: `lime_survey_{survey_id}` (e.g., `lime_survey_139982`)
- Token tables: `lime_tokens_{survey_id}` (e.g., `lime_tokens_139982`)
- System dynamically checks for table existence before querying

## Key Analysis Functions

### 1. get_all_answers() 
- **Purpose**: Extracts all answers for a given survey
- **Process**: Joins responses with question structure and participant data
- **Output**: Organized by question ID with answer groupings

### 2. get_all_answers_grouped()
- **Purpose**: Advanced analysis with time-based grouping
- **Features**:
  - Groups responses by month and week
  - Applies date filtering (date_from, date_to parameters)
  - Supports survey filtering by specific question values
  - Generates comprehensive statistics and totals

### 3. Question-Response Mapping
- **Field Format**: `{sid}X{gid}X{qid}` (e.g., `139982X23X543`)
- **Sub-questions**: Handles parent-child question relationships
- **Other Fields**: Supports "other" text fields with `-oth-` placeholder

## Database Schema Insights

### Survey Response Tables
- Each survey creates a dedicated table: `lime_survey_{survey_id}`
- Columns follow the pattern: `id`, `submitdate`, `token`, and question fields
- Question fields named as: `{sid}X{gid}X{qid}`
- Contains participant responses and metadata

### Token Tables
- Each survey may have associated token table: `lime_tokens_{survey_id}`
- Contains participant details: name, email, attributes
- Tracks survey status: sent, completed, reminders

### Answer Lookup Process
1. Response contains answer code (e.g., 'A1', 'B2')
2. Code maps to aid in `lime_answers` table
3. aid maps to actual text in `lime_answer_l10ns`
4. Returns localized answer text for analysis

## Performance Considerations

### Table Joins
- Complex queries joining multiple tables across different connections
- Dynamic table names require existence checks
- Time-based filtering reduces result set size

### Data Aggregation
- Response grouping by various criteria (by answer, by time period)
- Monthly and weekly aggregation for trend analysis
- Per-record response tracking for detailed analysis

## Integration Points

### Quaeris-Specific Features
- Links Limesurvey data to `survey_pdfs` table via survey_id mapping
- Custom chart configurations in `question_charts` table
- Participant tracking through `contacts` table
- SMS/email response tracking and statistics

### Date Filtering
- Supports date range filtering for response analysis
- Uses `date_from` and `date_to` parameters
- Applies to `submitdate` field in survey response tables

## Security Considerations
- Database connections properly separated by purpose
- Survey-specific table access verified before queries
- Participant data handling follows privacy guidelines
- Token-based access control for survey participation