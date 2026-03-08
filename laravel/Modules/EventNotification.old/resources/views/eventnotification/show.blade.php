@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Event Notification Details</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Event:</label>
                        <p>{{ $eventNotification->event->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">User:</label>
                        <p>{{ $eventNotification->user->name ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Type:</label>
                        <p>{{ $eventNotification->type }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Title:</label>
                        <p>{{ $eventNotification->title }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Message:</label>
                        <p>{{ $eventNotification->message }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Is Read:</label>
                        <p>{{ $eventNotification->is_read ? 'Yes' : 'No' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Read At:</label>
                        <p>{{ $eventNotification->read_at ? $eventNotification->read_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sent At:</label>
                        <p>{{ $eventNotification->sent_at ? $eventNotification->sent_at->format('M d, Y H:i') : 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Created At:</label>
                        <p>{{ $eventNotification->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Updated At:</label>
                        <p>{{ $eventNotification->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <a href="{{ route('event-notification.edit', $eventNotification->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('event-notification.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection