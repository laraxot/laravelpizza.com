@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Event Organizer</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-organizer.update', $eventOrganizer->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $eventOrganizer->name) }}" required>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $eventOrganizer->email) }}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $eventOrganizer->phone) }}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="organization" class="form-label">Organization</label>
                            <input type="text" class="form-control" id="organization" name="organization" value="{{ old('organization', $eventOrganizer->organization) }}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-control" id="website" name="website" value="{{ old('website', $eventOrganizer->website) }}">
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $eventOrganizer->description) }}</textarea>
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="event_id" class="form-label">Event</label>
                            <select class="form-control" id="event_id" name="event_id">
                                <option value="">Select Event</option>
                                @foreach($events ?? [] as $event)
                                <option value="{{ $event->id }}" {{ old('event_id', $eventOrganizer->event_id) == $event->id ? 'selected' : '' }}>{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Event Organizer</button>
                        <a href="{{ route('event-organizer.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection