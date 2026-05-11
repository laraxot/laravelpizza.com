# Limesurvey Database Analysis - healthcare_app_survey

## Overview
The `healthcare_app_survey` database (identified as `txaesfry_healthcare_app_survey` in the code) is a Limesurvey database used by the system for handling survey data, questions, answers, and responses.

## Database Schema Analysis

### Connection Configuration
- Database: `txaesfry_healthcare_app_survey`
- Connection name: `limesurvey` (configured in config files)
- Access through: `DB::connection('limesurvey')`

### Core Tables

#### 1. lime_questions
- Contains survey question definitions
- Key fields: `qid`, `sid` (survey id), `gid` (group id), `type`, `title`, `parent_qid`
- Used for storing question structure and metadata

#### 2. lime_question_l10ns
- Contains localized question text
- Key fields: `qid`, `question` (text content)
- Links to lime_questions via qid

#### 3. lime_survey_{sid}
- Dynamic survey response tables (one per survey ID)
- Named as `lime_survey_{survey_id}` (e.g., `lime_survey_139982`)
- Contains actual survey responses from participants
- Each survey has its own table with fields for each question

#### 4. lime_tokens_{sid}
- Dynamic token tables (one per survey for participant management)
- Named as `lime_tokens_{survey_id}`
- Contains participant tokens, names, emails, and participation status
- Fields: `token`, `firstname`, `lastname`, `email`, `sent`, `completed`

#### 5. lime_answers
- Stores possible answers for questions
- Key fields: `aid`, `qid`, `code`, `answer`
- Used for multiple choice, radio, dropdown questions

#### 6. lime_answer_l10ns
- Localized answer text
- Key fields: `aid`, `answer`
- Links to lime_answers via aid

### Integration with healthcare_app
- The system connects to the survey database to extract answers and generate reports
- Uses LimeSurvey Remote Control API pattern (though direct DB access is also implemented)
- Maps survey responses to question structures for analysis
- Links survey data with healthcare_app survey_pdf records

### Survey Data Flow
1. Survey structure defined in `lime_questions` and `lime_question_l10ns`
2. Participant responses stored in `lime_survey_{sid}`
3. Token management in `lime_tokens_{sid}`
4. Analysis performed by joining tables and aggregating responses
5. Results integrated with healthcare_app data for comprehensive reporting

### Key Methods in LimeSurveyKK
- `get_all_answers()`: Retrieves all answers for a given survey
- `get_all_answers_grouped()`: Groups answers by various criteria including time periods
- `get_questions()`: Extracts question structure from database
- `get_answers_by_question_id()`: Gets answers for specific questions
- Uses complex SQL joins across multiple survey-related tables

### Database Schema References
From the code, it's evident that Limesurvey follows the standard schema where:
- Tables are prefixed with `lime_`
- Survey-specific data is stored in dynamically named tables (`lime_survey_{id}`)
- Token tables follow the same pattern (`lime_tokens_{id}`)
- Translation tables use `_l10ns` suffix (localization)

## Usage in Application
The healthcare_app_survey database is used primarily for:
- Survey response analysis
- Question/answer extraction
- Response aggregation by time periods
- Integration with healthcare_app reporting features
- Participant management and tracking