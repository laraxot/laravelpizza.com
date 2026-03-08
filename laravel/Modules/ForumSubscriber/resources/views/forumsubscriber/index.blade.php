@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Subscribers</h4>
                    <a href="{{ route('forum-subscriber.create') }}" class="btn btn-primary btn-sm float-right">Add New</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Forum</th>
                                    <th>Subscription Type</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forumSubscribers as $forumSubscriber)
                                <tr>
                                    <td>{{ $forumSubscriber->id }}</td>
                                    <td>{{ $forumSubscriber->user->name ?? 'N/A' }}</td>
                                    <td>{{ $forumSubscriber->forum->name ?? 'N/A' }}</td>
                                    <td>{{ $forumSubscriber->subscription_type }}</td>
                                    <td>{{ $forumSubscriber->created_at ? $forumSubscriber->created_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('forum-subscriber.show', $forumSubscriber->id) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('forum-subscriber.edit', $forumSubscriber->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('forum-subscriber.destroy', $forumSubscriber->id) }}" method="POST" style="display: inline;">
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
                    {{ $forumSubscribers->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection