@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Event Organizer Details</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <p>{{ $eventOrganizer->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email:</label>
                        <p>{{ $eventOrganizer->email ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phone:</label>
                        <p>{{ $eventOrganizer->phone ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Organization:</label>
                        <p>{{ $eventOrganizer->organization ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Website:</label>
                        <p>{{ $eventOrganizer->website ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <p>{{ $eventOrganizer->description ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Event:</label>
                        <p>{{ $eventOrganizer->event->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Created At:</label>
                        <p>{{ $eventOrganizer->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Updated At:</label>
                        <p>{{ $eventOrganizer->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <a href="{{ route('event-organizer.edit', $eventOrganizer->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('event-organizer.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection