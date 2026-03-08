@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Event Analytics</h4>
                    <a href="{{ route('event-analytics.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Event</th>
                                    <th>Metric Name</th>
                                    <th>Metric Value</th>
                                    <th>Recorded At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventAnalytics as $analytics)
                                <tr>
                                    <td>{{ $analytics->id }}</td>
                                    <td>{{ $analytics->event->name ?? 'N/A' }}</td>
                                    <td>{{ $analytics->metric_name }}</td>
                                    <td>{{ $analytics->metric_value }}</td>
                                    <td>{{ $analytics->recorded_at ? $analytics->recorded_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('event-analytics.show', $analytics->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('event-analytics.edit', $analytics->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('event-analytics.destroy', $analytics->id) }}" method="POST" style="display: inline;">
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
                    {{ $eventAnalytics->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection