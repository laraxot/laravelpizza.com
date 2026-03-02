# Schema.org EducationEvent and Attendee Management

## Overview

This document provides comprehensive implementation guidance for Schema.org EducationEvent type and attendee management for LaravelPizza's educational workshops, tutorials, and training events.

## EducationEvent Type

### Core EducationEvent Properties

#### Education-Specific Properties
- `teaches` (DefinedTerm/Text) - Learning outcomes or competencies taught
- `educationalLevel` (DefinedTerm/Text/URL) - Target skill level (beginner, intermediate, advanced)
- `assesses` (DefinedTerm/Text) - Competencies or outcomes that are assessed

#### Standard Event Properties (Inherited)
- All properties from base Event type
- Additional emphasis on `audience`, `typicalAgeRange`, `inLanguage`

### Educational Level Standardization

**Recommended Values**:
- `Beginner` - New to the topic
- `Intermediate` - Some prior knowledge required
- `Advanced` - Experienced practitioners
- `Expert` - Professional level expertise

**Custom Levels for Laravel Pizza**:
- `Laravel Beginner` - New to Laravel
- `Laravel Intermediate` - Basic Laravel knowledge
- `Laravel Advanced` - Experienced Laravel developer
- `Laravel Expert` - Professional Laravel architect

## Implementation Tasks

### Task 1: EducationEvent Model Enhancement

**File**: `Modules/Meetup/app/Models/EducationEvent.php`

**Requirements**:
1. Extend base Event model or add education-specific attributes
2. Support for competency-based learning outcomes
3. Educational level classification
4. Assessment and evaluation tracking
5. Prerequisite management

**Implementation Checklist**:
- [ ] Create EducationEvent model with educational properties
- [ ] Implement learning outcome tracking
- [ ] Add educational level validation
- [ ] Create prerequisite relationship system
- [ ] Add competency assessment features
- [ ] Implement certification tracking

**Model Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class EducationEvent extends Event
{
    protected $table = 'events'; // Use same table with type discrimination
    
    protected $fillable = [
        // Inherited from Event
        'name', 'description', 'start_date', 'end_date', 'location_id',
        
        // EducationEvent specific
        'teaches', // JSON array of learning outcomes
        'educational_level', // beginner, intermediate, advanced, expert
        'assesses', // JSON array of assessed competencies
        'prerequisites', // JSON array of required knowledge
        'learning_objectives', // Text description
        'materials_included', // JSON array of provided materials
        'certificate_offered', // Boolean
        'duration_hours', // Specific duration in hours
        'difficulty_rating' // 1-10 scale
    ];

    protected $casts = [
        'teaches' => 'array',
        'assesses' => 'array',
        'prerequisites' => 'array',
        'materials_included' => 'array',
        'certificate_offered' => 'boolean',
        'difficulty_rating' => 'integer'
    ];

    public function instructors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_instructors')
            ->withPivot('role'); // lead_instructor, assistant, guest
    }

    public function learningOutcomes(): array
    {
        return $this->teaches ?? [];
    }

    public function hasPrerequisites(): bool
    {
        return !empty($this->prerequisites);
    }

    public function isBeginnerLevel(): bool
    {
        return in_array($this->educational_level, ['beginner', 'laravel-beginner']);
    }

    public function toSchemaOrg(): array
    {
        return array_merge(parent::toSchemaOrg(), [
            '@type' => 'EducationEvent',
            'teaches' => $this->teaches,
            'educationalLevel' => $this->getSchemaOrgLevel(),
            'assesses' => $this->assesses,
            'audience' => [
                '@type' => 'EducationalAudience',
                'educationalRole' => 'student'
            ]
        ]);
    }

    private function getSchemaOrgLevel(): string
    {
        return match($this->educational_level) {
            'laravel-beginner' => 'https://schema.org/Beginner',
            'laravel-intermediate' => 'https://schema.org/Intermediate',
            'laravel-advanced' => 'https://schema.org/Advanced',
            'laravel-expert' => 'https://schema.org/Expert',
            default => $this->educational_level
        };
    }
}
```

### Task 2: Attendee Management System

**Files**:
- `Modules/Meetup/app/Models/Attendee.php`
- `Modules/Meetup/app/Services/AttendeeService.php`

**Requirements**:
1. Comprehensive attendee tracking
2. Check-in/check-out functionality
3. Attendance analytics
4. Certificate management
5. Feedback collection

**Implementation Checklist**:
- [ ] Create Attendee model with proper relationships
- [ ] Implement check-in/out workflows
- [ ] Add attendance analytics tracking
- [ ] Build certificate generation system
- [ ] Create feedback collection system
- [ ] Add GDPR compliance features

**Attendee Model Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendee extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'registration_type', // rsvp, paid, comped, speaker
        'check_in_time',
        'check_out_time',
        'attendance_status', // registered, checked_in, completed, no_show
        'certificate_issued',
        'certificate_url',
        'feedback_submitted',
        'rating',
        'notes',
        'plus_ones_count'
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'certificate_issued' => 'boolean',
        'feedback_submitted' => 'boolean',
        'rating' => 'decimal:1',
        'plus_ones_count' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function isCheckedIn(): bool
    {
        return !is_null($this->check_in_time);
    }

    public function hasCompleted(): bool
    {
        return $this->attendance_status === 'completed';
    }

    public function canIssueCertificate(): bool
    {
        return $this->hasCompleted() && !$this->certificate_issued;
    }

    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $this->user->name,
            'identifier' => $this->user->id,
            'attendeeOf' => [
                '@type' => 'EducationEvent',
                'name' => $this->event->name,
                'identifier' => $this->event->id,
                'startDate' => $this->event->start_date->toIso8601String()
            ]
        ];
    }
}
```

### Task 3: Learning Outcome Management

**File**: `Modules/Meetup/app/Services/LearningOutcomeService.php`

**Requirements**:
1. Structured learning outcome definitions
2. Competency framework mapping
3. Assessment criteria
4. Progress tracking
5. Certification standards

**Implementation Checklist**:
- [ ] Define competency frameworks
- [ ] Create learning outcome taxonomy
- [ ] Implement assessment criteria
- [ ] Add progress tracking
- [ ] Build certification standards
- [ ] Create skill validation system

### Task 4: Certificate Generation System

**Files**:
- `Modules/Meetup/app/Services/CertificateService.php`
- `Modules/Meetup/app/Jobs/GenerateCertificateJob.php`

**Requirements**:
1. Dynamic certificate generation
2. QR code verification
3. PDF generation and storage
4. Email delivery
5. Public verification page

**Implementation Checklist**:
- [ ] Create certificate templates
- [ ] Implement QR code generation
- [ ] Add PDF generation
- [ ] Build email delivery system
- [ ] Create verification endpoints
- [ ] Add certificate analytics

**Certificate Service Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Services;

use Modules\Meetup\Models\Attendee;
use Modules\Meetup\Models\EducationEvent;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateService
{
    public function generateCertificate(Attendee $attendee): string
    {
        $event = $attendee->event;
        $certificateData = [
            'certificate_id' => $this->generateCertificateId(),
            'attendee_name' => $attendee->user->name,
            'event_name' => $event->name,
            'completion_date' => $event->end_date->format('F j, Y'),
            'learning_outcomes' => $event->learningOutcomes(),
            'instructor_names' => $event->instructors->pluck('name')->implode(', '),
            'verification_url' => route('certificate.verify', $certificateId)
        ];

        return $this->generatePDF($certificateData);
    }

    public function generateVerificationQrCode(string $certificateId): string
    {
        $url = route('certificate.verify', $certificateId);
        return QrCode::format('png')->size(200)->generate($url);
    }

    private function generateCertificateId(): string
    {
        return 'LPM-' . now()->format('Y') . '-' . strtoupper(Str::random(8));
    }

    private function generatePDF(array $data): string
    {
        $pdf = Pdf::loadView('meetup::certificates.template', $data);
        $filename = 'certificate-' . $data['certificate_id'] . '.pdf';
        
        // Store in secure location
        $path = 'certificates/' . $filename;
        Storage::disk('private')->put($path, $pdf->output());
        
        return $path;
    }
}
```

### Task 5: EducationEvent Filament Resources

**File**: `Modules/Meetup/app/Filament/Resources/EducationEventResource.php`

**Requirements**:
1. Educational content management
2. Learning outcome editor
3. Instructor assignment
4. Assessment configuration
5. Certificate management

**Implementation Checklist**:
- [ ] Extend EventResource with education-specific fields
- [ ] Create learning outcome editor component
- [ ] Add instructor management interface
- [ ] Implement assessment configuration
- [ ] Build certificate preview tools
- [ ] Add competency tracking dashboards

## JSON-LD Implementation Examples

### Basic EducationEvent

```json
{
  "@context": "https://schema.org",
  "@type": "EducationEvent",
  "name": "Laravel Advanced Eloquent Workshop",
  "description": "Deep dive into advanced Eloquent relationships, query optimization, and performance tuning",
  "startDate": "[DATE]T09:00:00+01:00",
  "endDate": "[DATE]T17:00:00+01:00",
  "location": {
    "@type": "Place",
    "name": "TechHub Milano",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Via Roma 123",
      "addressLocality": "Milano",
      "postalCode": "20121",
      "addressCountry": "IT"
    }
  },
  "organizer": {
    "@type": "Organization",
    "name": "Laravel Italy Community"
  },
  "educationalLevel": "https://schema.org/Advanced",
  "teaches": [
    "Advanced Eloquent Relationships",
    "Query Optimization Techniques",
    "Database Performance Tuning",
    "Eloquent Caching Strategies"
  ],
  "assesses": [
    "Understanding of complex relationships",
    "Ability to optimize database queries",
    "Knowledge of caching patterns"
  ],
  "audience": {
    "@type": "EducationalAudience",
    "educationalRole": "student"
  },
  "inLanguage": "it",
  "offers": {
    "@type": "Offer",
    "price": "150.00",
    "priceCurrency": "EUR",
    "availability": "https://schema.org/InStock"
  }
}
```

### Multi-level EducationEvent Series

```json
{
  "@context": "https://schema.org",
  "@type": "EventSeries",
  "name": "Laravel Learning Path 2026",
  "description": "Complete Laravel learning track from beginner to expert level",
  "eventSchedule": {
    "@type": "Schedule",
    "startDate": "[DATE]",
    "endDate": "[DATE]",
    "repeatFrequency": "P1M",
    "startTime": "09:00:00",
    "endTime": "17:00:00",
    "scheduleTimezone": "Europe/Rome"
  },
  "subEvent": [
    {
      "@type": "EducationEvent",
      "name": "Laravel Basics for Beginners",
      "educationalLevel": "https://schema.org/Beginner",
      "teaches": ["Laravel installation", "Routing basics", "Blade fundamentals"],
      "startDate": "[DATE]T09:00:00+01:00"
    },
    {
      "@type": "EducationEvent", 
      "name": "Advanced Laravel Patterns",
      "educationalLevel": "https://schema.org/Advanced",
      "teaches": ["Design patterns", "Architecture", "Performance optimization"],
      "startDate": "[DATE]T09:00:00+01:00"
    }
  ]
}
```

### Attendee with Certificate Information

```json
{
  "@context": "https://schema.org",
  "@type": "EventReservation",
  "reservationFor": {
    "@type": "EducationEvent",
    "name": "Laravel Advanced Eloquent Workshop"
  },
  "underName": {
    "@type": "Person",
    "name": "Maria Bianchi"
  },
  "attendee": {
    "@type": "Person",
    "name": "Maria Bianchi",
    "identifier": "user_456"
  },
  "bookingTime": "[DATE]T10:30:00+01:00",
  "reservationStatus": "https://schema.org/ReservationConfirmed",
  "reservedTicket": {
    "@type": "Ticket",
    "ticketNumber": "EDU-LRM-001",
    "ticketToken": "qrCode:LPM20260215001ABC123"
  }
}
```

## Database Schema

### Education Events Table Enhancements

```sql
ALTER TABLE events 
ADD COLUMN IF NOT EXISTS event_type ENUM('general', 'education', 'social', 'conference') DEFAULT 'general',
ADD COLUMN IF NOT EXISTS educational_level VARCHAR(50) NULL,
ADD COLUMN IF NOT EXISTS teaches JSON NULL,
ADD COLUMN IF NOT EXISTS assesses JSON NULL,
ADD COLUMN IF NOT EXISTS prerequisites JSON NULL,
ADD COLUMN IF NOT EXISTS learning_objectives TEXT NULL,
ADD COLUMN IF NOT EXISTS materials_included JSON NULL,
ADD COLUMN IF NOT EXISTS certificate_offered BOOLEAN DEFAULT FALSE,
ADD COLUMN IF NOT EXISTS duration_hours DECIMAL(5,2) NULL,
ADD COLUMN IF NOT EXISTS difficulty_rating INT NULL,
ADD COLUMN IF NOT EXISTS max_instructors INT DEFAULT 5;

-- Indexes for performance
CREATE INDEX idx_education_type ON events(event_type, educational_level);
CREATE INDEX idx_difficulty ON events(difficulty_rating, duration_hours);
```

### Attendees Table

```sql
CREATE TABLE attendees (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    event_id BIGINT NOT NULL,
    registration_type ENUM('rsvp', 'paid', 'comped', 'speaker', 'organizer') NOT NULL DEFAULT 'rsvp',
    check_in_time TIMESTAMP NULL,
    check_out_time TIMESTAMP NULL,
    attendance_status ENUM('registered', 'checked_in', 'in_progress', 'completed', 'no_show', 'cancelled') NOT NULL DEFAULT 'registered',
    certificate_issued BOOLEAN DEFAULT FALSE,
    certificate_url VARCHAR(500) NULL,
    certificate_id VARCHAR(50) NULL,
    feedback_submitted BOOLEAN DEFAULT FALSE,
    rating DECIMAL(3,1) NULL,
    notes TEXT NULL,
    plus_ones_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_user_event (user_id, event_id),
    INDEX idx_attendance_status (attendance_status),
    INDEX idx_certificate (certificate_issued, certificate_id),
    INDEX idx_registration_type (registration_type)
);
```

### Learning Outcomes Table

```sql
CREATE TABLE learning_outcomes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    description TEXT NULL,
    category VARCHAR(100) NULL, -- technical, soft_skill, theoretical, practical
    difficulty_level INT NULL, -- 1-10 scale
    competency_framework VARCHAR(100) NULL, -- Laravel, PHP, Web Development
    parent_outcome_id BIGINT NULL,
    
    FOREIGN KEY (parent_outcome_id) REFERENCES learning_outcomes(id),
    INDEX idx_category (category),
    INDEX idx_framework (competency_framework),
    INDEX idx_difficulty (difficulty_level)
);
```

### Event Outcomes Mapping Table

```sql
CREATE TABLE event_outcomes (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    event_id BIGINT NOT NULL,
    outcome_id BIGINT NOT NULL,
    is_required BOOLEAN DEFAULT TRUE, -- Core vs optional outcome
    assessment_weight DECIMAL(5,2) DEFAULT 1.00, -- Weight for grading
    assessment_criteria TEXT NULL,
    
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (outcome_id) REFERENCES learning_outcomes(id) ON DELETE RESTRICT,
    
    UNIQUE KEY unique_event_outcome (event_id, outcome_id),
    INDEX idx_required (is_required),
    INDEX idx_weight (assessment_weight)
);
```

## Frontend Integration

### Education Event Display Component

```php
// Themes/Meetup/resources/views/components/blocks/education-event.blade.php
@props([
    'event' => Modules\Meetup\Models\EducationEvent::class
])

<div class="education-event" itemscope itemtype="https://schema.org/EducationEvent">
    <!-- Schema.org metadata -->
    <meta itemprop="educationalLevel" content="{{ $event->getSchemaOrgLevel() }}">
    
    @foreach($event->teaches as $teaches)
    <meta itemprop="teaches" content="{{ $teaches }}">
    @endforeach
    
    <div class="event-header">
        <h1 itemprop="name">{{ $event->name }}</h1>
        <div class="event-meta">
            <span class="level-badge level-{{ $event->educational_level }}">
                {{ __('meetup::levels.' . $event->educational_level) }}
            </span>
            
            @if($event->difficulty_rating)
            <div class="difficulty-rating">
                <span class="stars">{{ str_repeat('⭐', $event->difficulty_rating) }}</span>
                <span class="rating">({{ $event->difficulty_rating }}/10)</span>
            </div>
            @endif
        </div>
    </div>
    
    <div class="event-content">
        <div class="description" itemprop="description">
            {!! $event->description !!}
        </div>
        
        @if($event->learning_objectives)
        <div class="learning-objectives">
            <h3>{{ __('meetup::education.learning_objectives') }}</h3>
            <p>{{ $event->learning_objectives }}</p>
        </div>
        @endif
        
        @if($event->teaches && count($event->teaches) > 0)
        <div class="learning-outcomes">
            <h3>{{ __('meetup::education.what_you_will_learn') }}</h3>
            <ul>
                @foreach($event->teaches as $outcome)
                <li itemprop="teaches">{{ $outcome }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        @if($event->hasPrerequisites())
        <div class="prerequisites">
            <h3>{{ __('meetup::education.prerequisites') }}</h3>
            <ul>
                @foreach($event->prerequisites as $prereq)
                <li>{{ $prereq }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        
        @if($event->certificate_offered)
        <div class="certificate-info">
            <div class="icon">🏆</div>
            <span>{{ __('meetup::education.certificate_offered') }}</span>
        </div>
        @endif
    </div>
</div>
```

## Advanced Features

### Task 6: Competency Assessment System

**Requirements**:
1. Skill assessment tools
2. Progress tracking dashboards
3. Competency gap analysis
4. Personalized learning paths
5. Achievement badges

**Implementation Checklist**:
- [ ] Create assessment question types
- [ ] Implement scoring algorithms
- [ ] Build progress tracking
- [ ] Add competency gap analysis
- [ ] Create badge system
- [ ] Implement recommendation engine

### Task 7: Learning Analytics

**Requirements**:
1. Learning outcome analytics
2. Instructor performance metrics
3. Course effectiveness data
4. Student engagement tracking
5. Predictive insights

**Implementation Checklist**:
- [ ] Track learning outcome achievement
- [ ] Monitor instructor effectiveness
- [ ] Analyze course completion rates
- [ ] Measure engagement metrics
- [ ] Generate insights reports
- [ ] Build predictive models

## Best Practices

### 1. Educational Content Standards
- Use clear, measurable learning objectives
- Align assessments with learning outcomes
- Provide prerequisite information
- Include realistic time commitments
- Offer multiple learning formats

### 2. Accessibility in Education
- Ensure content is screen reader friendly
- Provide captioning for video content
- Include multiple learning formats
- Support keyboard navigation
- Offer content in multiple languages

### 3. Data Privacy
- Protect student learning data
- Comply with educational privacy laws
- Provide data export options
- Implement secure certificate verification
- Allow data deletion on request

### 4. Quality Assurance
- Validate educational content accuracy
- Review learning outcome clarity
- Test assessment effectiveness
- Monitor instructor qualifications
- Update content regularly

## Testing Strategy

### EducationEvent Tests

```php
// tests/Feature/EducationEventTest.php
public function test_education_event_creation_with_learning_outcomes()
{
    $event = EducationEvent::factory()->create([
        'educational_level' => 'advanced',
        'teaches' => ['Eloquent Relationships', 'Query Optimization'],
        'assesses' => ['Database Design', 'Performance']
    ]);
    
    $this->assertEquals('advanced', $event->educational_level);
    $this->assertCount(2, $event->teaches);
    $this->assertContains('Eloquent Relationships', $event->teaches);
}

public function test_attendee_check_in_workflow()
{
    $attendee = Attendee::factory()->create();
    $this->assertFalse($attendee->isCheckedIn());
    
    $attendee->checkIn();
    $this->assertTrue($attendee->isCheckedIn());
}

public function test_certificate_generation()
{
    // Test certificate generation and verification
}
```

## Next Steps

1. Implement EducationEvent model enhancements (Task 1)
2. Build attendee management system (Task 2-3)
3. Create certificate generation (Task 4)
4. Develop Filament resources (Task 5)
5. Add advanced features (Task 6-7)

This implementation will establish LaravelPizza as a premier platform for technical education, with comprehensive learning management, certification, and attendee analytics fully compliant with Schema.org EducationEvent specifications.