@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Event Notification</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-notification.update', $eventNotification->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="event_id" class="form-label">Event *</label>
                            <select class="form-control" id="event_id" name="event_id" required>
                                <option value="">Select Event</option>
                                @foreach($events ?? [] as $event)
                                <option value="{{ $event->id }}" {{ $eventNotification->event_id == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="user_id" class="form-label">User *</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}" {{ $eventNotification->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="type" class="form-label">Type *</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="reminder" {{ $eventNotification->type == 'reminder' ? 'selected' : '' }}>Reminder</option>
                                <option value="update" {{ $eventNotification->type == 'update' ? 'selected' : '' }}>Update</option>
                                <option value="cancellation" {{ $eventNotification->type == 'cancellation' ? 'selected' : '' }}>Cancellation</option>
                                <option value="other" {{ $eventNotification->type == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $eventNotification->title) }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required>{{ old('message', $eventNotification->message) }}</textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="is_read" class="form-label">Is Read</label>
                            <input type="checkbox" class="form-check-input" id="is_read" name="is_read" {{ $eventNotification->is_read ? 'checked' : '' }}>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="read_at" class="form-label">Read At</label>
                            <input type="datetime-local" class="form-control" id="read_at" name="read_at" value="{{ $eventNotification->read_at ? $eventNotification->read_at->format('Y-m-d\TH:i') : '' }}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="sent_at" class="form-label">Sent At</label>
                            <input type="datetime-local" class="form-control" id="sent_at" name="sent_at" value="{{ $eventNotification->sent_at ? $eventNotification->sent_at->format('Y-m-d\TH:i') : '' }}">
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Event Notification</button>
                        <a href="{{ route('event-notification.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection