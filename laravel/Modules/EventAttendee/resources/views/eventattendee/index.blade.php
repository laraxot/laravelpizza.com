@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Event Attendees</h4>
                    <a href="{{ route('event-attendee.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Registration Date</th>
                                    <th>Status</th>
                                    <th>Ticket Type</th>
                                    <th>Payment Status</th>
                                    <th>Attended</th>
                                    <th>Check-in Time</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventAttendees as $eventAttendee)
                                <tr>
                                    <td>{{ $eventAttendee->id }}</td>
                                    <td>{{ $eventAttendee->user->name ?? 'N/A' }}</td>
                                    <td>{{ $eventAttendee->event->name ?? 'N/A' }}</td>
                                    <td>{{ $eventAttendee->registration_date->format('M d, Y') }}</td>
                                    <td>{{ $eventAttendee->status }}</td>
                                    <td>{{ $eventAttendee->ticket_type }}</td>
                                    <td>{{ $eventAttendee->payment_status }}</td>
                                    <td>{{ $eventAttendee->attended ? 'Yes' : 'No' }}</td>
                                    <td>{{ $eventAttendee->check_in_time ? $eventAttendee->check_in_time->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('event-attendee.show', $eventAttendee->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('event-attendee.edit', $eventAttendee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('event-attendee.destroy', $eventAttendee->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $eventAttendees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection