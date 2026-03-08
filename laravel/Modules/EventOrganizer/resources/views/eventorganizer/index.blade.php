@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Event Organizers</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('event-organizer.create') }}" class="btn btn-primary mb-3">Create New Event Organizer</a>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Organization</th>
                                    <th>Event</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventOrganizers as $eventOrganizer)
                                <tr>
                                    <td>{{ $eventOrganizer->name }}</td>
                                    <td>{{ $eventOrganizer->email }}</td>
                                    <td>{{ $eventOrganizer->phone }}</td>
                                    <td>{{ $eventOrganizer->organization }}</td>
                                    <td>{{ $eventOrganizer->event->name ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('event-organizer.edit', $eventOrganizer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('event-organizer.destroy', $eventOrganizer->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    {{ $eventOrganizers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection