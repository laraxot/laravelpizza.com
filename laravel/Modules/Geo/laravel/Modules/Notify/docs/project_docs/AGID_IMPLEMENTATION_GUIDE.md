# 🚀 AGID Implementation Guide - Practical Developer Guide

**Date**: 2025-10-02  
**Target**: Developers implementing AGID-compliant features  
**Difficulty**: Intermediate  
**Estimated Time**: Follow step-by-step tutorials

---

## 📚 Table of Contents

1. [Multi-Step Form Wizard](#multi-step-form-wizard)
2. [Accordion Component](#accordion-component)
3. [FAQ System](#faq-system)
4. [Search Functionality](#search-functionality)
5. [SEO Enhancement](#seo-enhancement)

---

## 1. Multi-Step Form Wizard

### 🎯 Objective
Transform the single-page ticket creation form into a 4-step AGID-compliant wizard.

### 📦 Components Created
- `<x-ui::stepper>`
- `<x-ui::stepper-step>`
- Translations: `ui::stepper.*`

### 💻 Implementation

#### Step 1: Update Ticket Creation Form

**File**: `Modules/Fixcity/resources/views/tickets/create.blade.php`

```blade
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">
            {{ __('fixcity::ticket.create.title') }}
        </h1>
        
        <form 
            action="{{ route('tickets.store') }}" 
            method="POST"
            enctype="multipart/form-data"
            x-data="ticketWizard()"
            @submit.prevent="submitForm"
        >
            @csrf
            
            <x-ui::stepper
                :total-steps="4"
                :steps="[
                    1 => __('fixcity::ticket.create.step_privacy'),
                    2 => __('fixcity::ticket.create.step_data'),
                    3 => __('fixcity::ticket.create.step_summary'),
                    4 => __('fixcity::ticket.create.step_confirmation'),
                ]"
            >
                {{-- Step 1: Privacy Consent --}}
                <x-ui::stepper-step 
                    :number="1" 
                    :title="__('fixcity::ticket.create.privacy_title')"
                >
                    @include('fixcity::tickets.steps.privacy')
                </x-ui::stepper-step>
                
                {{-- Step 2: Data Entry --}}
                <x-ui::stepper-step 
                    :number="2" 
                    :title="__('fixcity::ticket.create.data_title')"
                >
                    @include('fixcity::tickets.steps.data')
                </x-ui::stepper-step>
                
                {{-- Step 3: Summary --}}
                <x-ui::stepper-step 
                    :number="3" 
                    :title="__('fixcity::ticket.create.summary_title')"
                >
                    @include('fixcity::tickets.steps.summary')
                </x-ui::stepper-step>
                
                {{-- Step 4: Confirmation --}}
                <x-ui::stepper-step 
                    :number="4" 
                    :title="__('fixcity::ticket.create.confirmation_title')"
                >
                    @include('fixcity::tickets.steps.confirmation')
                </x-ui::stepper-step>
            </x-ui::stepper>
        </form>
    </div>
    
    @push('scripts')
    <script>
        function ticketWizard() {
            return {
                formData: {
                    privacy_consent: false,
                    category_id: '',
                    title: '',
                    description: '',
                    latitude: null,
                    longitude: null,
                    address: '',
                    photos: [],
                    name: '{{ auth()->user()->name ?? "" }}',
                    email: '{{ auth()->user()->email ?? "" }}',
                    phone: '',
                },
                
                submitForm() {
                    // Validate all steps
                    if (!this.validateAllSteps()) {
                        alert('{{ __("fixcity::ticket.create.validation_error") }}');
                        return;
                    }
                    
                    // Submit form
                    this.$el.submit();
                },
                
                validateAllSteps() {
                    return this.formData.privacy_consent &&
                           this.formData.category_id &&
                           this.formData.title &&
                           this.formData.description;
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
```

#### Step 2: Create Step Partials

**File**: `Modules/Fixcity/resources/views/tickets/steps/privacy.blade.php`

```blade
<div class="privacy-step">
    <div class="alert alert-info mb-4">
        <h3 class="alert-heading">
            {{ __('fixcity::ticket.privacy.heading') }}
        </h3>
        <p>{{ __('fixcity::ticket.privacy.intro') }}</p>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title">
                {{ __('fixcity::ticket.privacy.policy_title') }}
            </h4>
            
            <div class="privacy-policy-text" style="max-height: 300px; overflow-y: auto;">
                {!! __('fixcity::ticket.privacy.policy_content') !!}
            </div>
        </div>
    </div>
    
    <div class="form-check">
        <input 
            type="checkbox" 
            class="form-check-input" 
            id="privacy_consent"
            x-model="formData.privacy_consent"
            required
        >
        <label class="form-check-label" for="privacy_consent">
            {{ __('fixcity::ticket.privacy.consent_label') }}
            <span class="text-danger">*</span>
        </label>
    </div>
    
    <p class="text-muted small mt-2">
        {{ __('fixcity::ticket.privacy.required_info') }}
    </p>
</div>
```

**File**: `Modules/Fixcity/resources/views/tickets/steps/data.blade.php`

```blade
<div class="data-step">
    {{-- Category Selection --}}
    <fieldset class="mb-4">
        <legend class="h5">
            {{ __('fixcity::ticket.fields.category.label') }}
            <span class="text-danger">*</span>
        </legend>
        
        <select 
            name="category_id" 
            id="category_id"
            class="form-select"
            x-model="formData.category_id"
            required
        >
            <option value="">{{ __('fixcity::ticket.fields.category.placeholder') }}</option>
            @foreach(\Modules\Fixcity\Enums\TicketTypeEnum::cases() as $type)
                <option value="{{ $type->value }}">{{ $type->label() }}</option>
            @endforeach
        </select>
    </fieldset>
    
    {{-- Location --}}
    <fieldset class="mb-4">
        <legend class="h5">
            {{ __('fixcity::ticket.fields.location.label') }}
            <span class="text-danger">*</span>
        </legend>
        <p class="text-muted small">
            {{ __('fixcity::ticket.fields.location.help') }}
        </p>
        
        <x-fixcity::map-picker
            name="location"
            :center="[41.9028, 12.4964]"
            :zoom="13"
            x-model:latitude="formData.latitude"
            x-model:longitude="formData.longitude"
            x-model:address="formData.address"
        />
        
        <input type="hidden" name="latitude" x-model="formData.latitude">
        <input type="hidden" name="longitude" x-model="formData.longitude">
        <input type="hidden" name="address" x-model="formData.address">
    </fieldset>
    
    {{-- Issue Details --}}
    <fieldset class="mb-4">
        <legend class="h5">
            {{ __('fixcity::ticket.fields.details.label') }}
        </legend>
        
        <div class="mb-3">
            <label for="title" class="form-label">
                {{ __('fixcity::ticket.fields.title.label') }}
                <span class="text-danger">*</span>
            </label>
            <input 
                type="text" 
                class="form-control" 
                id="title"
                name="title"
                x-model="formData.title"
                :placeholder="__('fixcity::ticket.fields.title.placeholder')"
                required
                maxlength="255"
            >
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">
                {{ __('fixcity::ticket.fields.description.label') }}
                <span class="text-danger">*</span>
            </label>
            <textarea 
                class="form-control" 
                id="description"
                name="description"
                rows="5"
                x-model="formData.description"
                :placeholder="__('fixcity::ticket.fields.description.placeholder')"
                required
            ></textarea>
            <div class="form-text">
                {{ __('fixcity::ticket.fields.description.help') }}
            </div>
        </div>
        
        <div class="mb-3">
            <label for="photos" class="form-label">
                {{ __('fixcity::ticket.fields.photos.label') }}
            </label>
            <input 
                type="file" 
                class="form-control" 
                id="photos"
                name="photos[]"
                multiple
                accept="image/*"
                @change="formData.photos = Array.from($event.target.files)"
            >
            <div class="form-text">
                {{ __('fixcity::ticket.fields.photos.help') }}
            </div>
        </div>
    </fieldset>
    
    {{-- Reporter Information --}}
    <fieldset class="mb-4">
        <legend class="h5">
            {{ __('fixcity::ticket.fields.reporter.label') }}
        </legend>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="name" class="form-label">
                    {{ __('fixcity::ticket.fields.name.label') }}
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="text" 
                    class="form-control" 
                    id="name"
                    name="name"
                    x-model="formData.name"
                    required
                >
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">
                    {{ __('fixcity::ticket.fields.email.label') }}
                    <span class="text-danger">*</span>
                </label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="email"
                    name="email"
                    x-model="formData.email"
                    required
                >
            </div>
        </div>
        
        <div class="mb-3">
            <label for="phone" class="form-label">
                {{ __('fixcity::ticket.fields.phone.label') }}
            </label>
            <input 
                type="tel" 
                class="form-control" 
                id="phone"
                name="phone"
                x-model="formData.phone"
            >
            <div class="form-text">
                {{ __('fixcity::ticket.fields.phone.help') }}
            </div>
        </div>
    </fieldset>
</div>
```

**File**: `Modules/Fixcity/resources/views/tickets/steps/summary.blade.php`

```blade
<div class="summary-step">
    <div class="alert alert-warning">
        <strong>{{ __('fixcity::ticket.summary.review_heading') }}</strong>
        <p>{{ __('fixcity::ticket.summary.review_text') }}</p>
    </div>
    
    <dl class="row">
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.category.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.category_id"></dd>
        
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.title.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.title"></dd>
        
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.description.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.description"></dd>
        
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.location.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.address || 'N/A'"></dd>
        
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.photos.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.photos.length + ' {{ __("fixcity::ticket.summary.photos_count") }}'"></dd>
        
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.name.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.name"></dd>
        
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.email.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.email"></dd>
        
        <dt class="col-sm-3">{{ __('fixcity::ticket.fields.phone.label') }}</dt>
        <dd class="col-sm-9" x-text="formData.phone || 'N/A'"></dd>
    </dl>
    
    <div class="alert alert-info mt-4">
        <svg class="icon icon-info" aria-hidden="true">
            <use href="#it-info-circle"></use>
        </svg>
        <strong>{{ __('fixcity::ticket.summary.notification_heading') }}</strong>
        <p>{{ __('fixcity::ticket.summary.notification_text', ['email' => '']) }}</p>
    </div>
</div>
```

**File**: `Modules/Fixcity/resources/views/tickets/steps/confirmation.blade.php`

```blade
<div class="confirmation-step text-center">
    <div class="icon-success mb-4">
        <svg class="icon icon-xl icon-success" aria-hidden="true">
            <use href="#it-check-circle"></use>
        </svg>
    </div>
    
    <h2 class="mb-3">{{ __('fixcity::ticket.confirmation.success_heading') }}</h2>
    
    <p class="lead text-muted">
        {{ __('fixcity::ticket.confirmation.success_text') }}
    </p>
    
    <div class="alert alert-success my-4">
        <p class="mb-0">
            <strong>{{ __('fixcity::ticket.confirmation.next_steps_heading') }}</strong>
        </p>
        <ol class="text-start mt-3">
            <li>{{ __('fixcity::ticket.confirmation.step_1') }}</li>
            <li>{{ __('fixcity::ticket.confirmation.step_2') }}</li>
            <li>{{ __('fixcity::ticket.confirmation.step_3') }}</li>
        </ol>
    </div>
</div>
```

### ✅ Testing Checklist

- [ ] All 4 steps render correctly
- [ ] Progress indicator updates
- [ ] Navigation buttons work (Next/Previous)
- [ ] Form validation works per step
- [ ] Summary displays all entered data
- [ ] Form submits successfully
- [ ] Keyboard navigation works (Tab, Enter)
- [ ] Screen reader announces step changes
- [ ] Mobile responsive
- [ ] Works without JavaScript (graceful degradation)

---

## 2. Accordion Component

### 🎯 Objective
Create FAQ pages with AGID-compliant accordion UI.

### 💻 Implementation

**File**: `Modules/Fixcity/resources/views/faq/index.blade.php`

```blade
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-2">
            {{ __('fixcity::faq.title') }}
        </h1>
        <p class="text-lg text-gray-600 mb-8">
            {{ __('fixcity::faq.subtitle') }}
        </p>
        
        {{-- Search FAQ --}}
        <div class="mb-6">
            <div class="relative">
                <input 
                    type="search" 
                    class="form-control"
                    placeholder="{{ __('fixcity::faq.search_placeholder') }}"
                    x-data
                    x-on:input.debounce.300ms="searchFaq($event.target.value)"
                >
                <svg class="icon icon-sm position-absolute top-50 end-0 translate-middle-y me-3" aria-hidden="true">
                    <use href="#it-search"></use>
                </svg>
            </div>
        </div>
        
        @foreach($faqsByCategory as $categoryName => $faqs)
            <section class="mb-6">
                <h2 class="h4 mb-3">{{ $categoryName }}</h2>
                
                <x-ui::accordion id="faq-{{ Str::slug($categoryName) }}">
                    @foreach($faqs as $index => $faq)
                        <x-ui::accordion-item
                            :title="$faq->question"
                            :id="'faq-' . $faq->id"
                            :parent-id="'faq-' . Str::slug($categoryName)"
                            :open="$index === 0"
                        >
                            <div class="faq-answer">
                                {!! $faq->answer !!}
                            </div>
                            
                            @if($faq->related_links)
                                <div class="related-links mt-3">
                                    <strong>{{ __('fixcity::faq.related_links') }}:</strong>
                                    <ul>
                                        @foreach($faq->related_links as $link)
                                            <li>
                                                <a href="{{ $link['url'] }}">
                                                    {{ $link['text'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </x-ui::accordion-item>
                    @endforeach
                </x-ui::accordion>
            </section>
        @endforeach
        
        {{-- Still need help? --}}
        <div class="card bg-light mt-8">
            <div class="card-body text-center">
                <h3 class="card-title">
                    {{ __('fixcity::faq.need_help_title') }}
                </h3>
                <p class="card-text">
                    {{ __('fixcity::faq.need_help_text') }}
                </p>
                <a href="{{ route('contact') }}" class="btn btn-primary">
                    {{ __('fixcity::faq.contact_button') }}
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
```

**Model**: `Modules/Fixcity/app/Models/Faq.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Fixcity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faq extends Model
{
    protected $fillable = [
        'category_id',
        'question',
        'answer',
        'related_links',
        'order',
        'is_published',
    ];
    
    protected $casts = [
        'related_links' => 'array',
        'is_published' => 'boolean',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(FaqCategory::class, 'category_id');
    }
    
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
```

**Migration**:
```bash
php artisan make:migration create_faqs_table --path=Modules/Fixcity/database/Migrations
```

```php
Schema::create('faqs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained('faq_categories')->onDelete('cascade');
    $table->string('question');
    $table->text('answer');
    $table->json('related_links')->nullable();
    $table->integer('order')->default(0);
    $table->boolean('is_published')->default(true);
    $table->timestamps();
});
```

---

## 3. Search Functionality

### 🎯 Objective
Implement full-text search with Laravel Scout.

### 📦 Installation

```bash
composer require laravel/scout
composer require meilisearch/meilisearch-php
```

**Config**: `config/scout.php`
```php
'driver' => env('SCOUT_DRIVER', 'meilisearch'),
```

**Environment**: `.env`
```
SCOUT_DRIVER=meilisearch
MEILISEARCH_HOST=http://localhost:7700
MEILISEARCH_KEY=your-master-key
```

### 💻 Implementation

**Model**: `Modules/Fixcity/app/Models/Ticket.php`

```php
use Laravel\Scout\Searchable;

class Ticket extends Model
{
    use Searchable;
    
    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'tracking_code' => $this->tracking_code,
            'title' => $this->title,
            'description' => $this->description,
            'address' => $this->address,
            'status' => $this->status->value,
            'type' => $this->type->value,
            'created_at' => $this->created_at->timestamp,
        ];
    }
    
    /**
     * Get the index name for the model.
     */
    public function searchableAs(): string
    {
        return 'tickets_index';
    }
}
```

**Controller**: `Modules/Fixcity/app/Http/Controllers/SearchController.php`

```php
<?php

declare(strict_types=1);

namespace Modules\Fixcity\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Fixcity\Models\Ticket;

class SearchController
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return view('fixcity::search.index', [
                'query' => '',
                'results' => collect(),
                'total' => 0,
            ]);
        }
        
        $results = Ticket::search($query)
            ->query(fn ($builder) => $builder->with(['owner', 'responsible']))
            ->paginate(20);
        
        return view('fixcity::search.index', [
            'query' => $query,
            'results' => $results,
            'total' => $results->total(),
        ]);
    }
}
```

**Route**:
```php
Route::get('/search', [SearchController::class, 'index'])->name('search');
```

**View**: `Modules/Fixcity/resources/views/search/index.blade.php`

```blade
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">
            {{ __('fixcity::search.title') }}
        </h1>
        
        {{-- Search Form --}}
        <form action="{{ route('search') }}" method="GET" class="mb-6">
            <div class="input-group">
                <input 
                    type="search" 
                    name="q" 
                    class="form-control form-control-lg"
                    value="{{ $query }}"
                    placeholder="{{ __('fixcity::search.placeholder') }}"
                    autofocus
                >
                <button type="submit" class="btn btn-primary">
                    <svg class="icon icon-white" aria-hidden="true">
                        <use href="#it-search"></use>
                    </svg>
                    {{ __('fixcity::search.button') }}
                </button>
            </div>
        </form>
        
        @if($query)
            <div class="search-results">
                <p class="text-muted mb-4">
                    {{ trans_choice('fixcity::search.results_count', $total, ['count' => $total, 'query' => $query]) }}
                </p>
                
                @if($results->isEmpty())
                    <div class="alert alert-info">
                        <h3 class="alert-heading">
                            {{ __('fixcity::search.no_results_heading') }}
                        </h3>
                        <p>{{ __('fixcity::search.no_results_text') }}</p>
                        <ul>
                            <li>{{ __('fixcity::search.tip_1') }}</li>
                            <li>{{ __('fixcity::search.tip_2') }}</li>
                            <li>{{ __('fixcity::search.tip_3') }}</li>
                        </ul>
                    </div>
                @else
                    <div class="results-list">
                        @foreach($results as $ticket)
                            <article class="card mb-3">
                                <div class="card-body">
                                    <h3 class="card-title">
                                        <a href="{{ route('tickets.show', $ticket) }}">
                                            {{ $ticket->title }}
                                        </a>
                                    </h3>
                                    <p class="card-text">
                                        {{ Str::limit($ticket->description, 200) }}
                                    </p>
                                    <div class="meta text-muted small">
                                        <span class="badge bg-{{ $ticket->status->getColor() }}">
                                            {{ $ticket->status->label() }}
                                        </span>
                                        <span class="ms-2">
                                            {{ $ticket->created_at->diffForHumans() }}
                                        </span>
                                        <span class="ms-2">
                                            📍 {{ $ticket->address }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    
                    {{ $results->links() }}
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
```

**Index tickets**:
```bash
php artisan scout:import "Modules\\Fixcity\\Models\\Ticket"
```

---

## ✅ Final Checklist

### Components Created
- [x] Stepper component
- [x] Stepper-step component
- [x] Accordion component
- [x] Accordion-item component
- [x] Translations (IT/EN)

### Documentation Created
- [x] AGID Compliance Summary (Themes/Sixteen)
- [x] AGID Compliance (Modules/Cms)
- [x] Implementation Guide (this file)

### Features Implemented
- [x] Multi-step form structure
- [x] Accordion UI component
- [ ] FAQ system (model + migration needed)
- [ ] Search functionality (Scout integration needed)
- [ ] SEO enhancements (migrations needed)

### Next Steps
1. Create migrations for FAQs
2. Install and configure Laravel Scout
3. Create Filament resources for FAQ management
4. Add SEO fields to existing models
5. Implement remaining AGID templates

---

**Estimated Total Time**: 40-60 hours for full AGID compliance  
**Priority Order**: Multi-step form → FAQ → Search → SEO → Optional features

**Maintainer**: Development Team
