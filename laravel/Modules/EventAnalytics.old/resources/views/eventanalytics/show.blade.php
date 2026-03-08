@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Event Analytics Details</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Event:</label>
                        <p>{{ $eventAnalytics->event->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Metric Name:</label>
                        <p>{{ $eventAnalytics->metric_name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Metric Value:</label>
                        <p>{{ $eventAnalytics->metric_value }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Recorded At:</label>
                        <p>{{ $eventAnalytics->recorded_at ? $eventAnalytics->recorded_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Created At:</label>
                        <p>{{ $eventAnalytics->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Updated At:</label>
                        <p>{{ $eventAnalytics->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <a href="{{ route('event-analytics.edit', $eventAnalytics->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('event-analytics.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection