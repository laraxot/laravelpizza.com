@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Event Analytics</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-analytics.update', $eventAnalytics->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="event_id" class="form-label">Event *</label>
                            <select class="form-control" id="event_id" name="event_id" required>
                                <option value="">Select Event</option>
                                @foreach($events ?? [] as $event)
                                <option value="{{ $event->id }}" {{ $eventAnalytics->event_id == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="metric_name" class="form-label">Metric Name *</label>
                            <input type="text" class="form-control" id="metric_name" name="metric_name" value="{{ old('metric_name', $eventAnalytics->metric_name) }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="metric_value" class="form-label">Metric Value *</label>
                            <input type="number" step="0.01" class="form-control" id="metric_value" name="metric_value" value="{{ old('metric_value', $eventAnalytics->metric_value) }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="recorded_at" class="form-label">Recorded At</label>
                            <input type="datetime-local" class="form-control" id="recorded_at" name="recorded_at" value="{{ $eventAnalytics->recorded_at ? $eventAnalytics->recorded_at->format('Y-m-d\TH:i') : '' }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Event Analytics</button>
                        <a href="{{ route('event-analytics.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection