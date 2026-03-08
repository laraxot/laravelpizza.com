@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Create Event Notification</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-notification.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label for="event_id" class="form-label">Event *</label>
                            <select class="form-control" id="event_id" name="event_id" required>
                                <option value="">Select Event</option>
                                @foreach($events ?? [] as $event)
                                <option value="{{ $event->id }}">{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="user_id" class="form-label">User *</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                @foreach($users ?? [] as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="type" class="form-label">Type *</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="">Select Type</option>
                                <option value="reminder">Reminder</option>
                                <option value="update">Update</option>
                                <option value="cancellation">Cancellation</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create Event Notification</button>
                        <a href="{{ route('event-notification.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection