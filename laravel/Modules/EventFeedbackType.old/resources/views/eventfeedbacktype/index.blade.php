@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Event Feedback Types</h4>
                    <a href="{{ route('event-feedback-type.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($eventFeedbackTypes as $eventFeedbackType)
                                <tr>
                                    <td>{{ $eventFeedbackType->id }}</td>
                                    <td>{{ $eventFeedbackType->name }}</td>
                                    <td>
                                        <a href="{{ route('event-feedback-type.show', $eventFeedbackType->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('event-feedback-type.edit', $eventFeedbackType->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('event-feedback-type.destroy', $eventFeedbackType->id) }}" method="POST" style="display: inline;">
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
                    {{ $eventFeedbackTypes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection