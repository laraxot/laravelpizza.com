@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Event Notifications</h4>
                    <a href="{{ route('event-notification.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Event</th>
                                    <th>User</th>
                                    <th>Type</th>
                                    <th>Title</th>
                                    <th>Is Read</th>
                                    <th>Sent At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventNotifications as $eventNotification)
                                <tr>
                                    <td>{{ $eventNotification->id }}</td>
                                    <td>{{ $eventNotification->event->name ?? 'N/A' }}</td>
                                    <td>{{ $eventNotification->user->name ?? 'N/A' }}</td>
                                    <td>{{ $eventNotification->type }}</td>
                                    <td>{{ $eventNotification->title }}</td>
                                    <td>{{ $eventNotification->is_read ? 'Yes' : 'No' }}</td>
                                    <td>{{ $eventNotification->sent_at ? $eventNotification->sent_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('event-notification.show', $eventNotification->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('event-notification.edit', $eventNotification->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('event-notification.destroy', $eventNotification->id) }}" method="POST" style="display: inline;">
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
                    {{ $eventNotifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection