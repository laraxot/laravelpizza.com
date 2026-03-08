@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Event Feedback Type Details</h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Name:</label>
                        <p>{{ $eventFeedbackType->name }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description:</label>
                        <p>{{ $eventFeedbackType->description ?? 'N/A' }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Created At:</label>
                        <p>{{ $eventFeedbackType->created_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Updated At:</label>
                        <p>{{ $eventFeedbackType->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                    
                    <a href="{{ route('event-feedback-type.edit', $eventFeedbackType->id) }}" class="btn btn-warning">Edit</a>
                    <a href="{{ route('event-feedback-type.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection