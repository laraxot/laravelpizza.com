@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Forum Subscriber Details</h4>
                    <a href="{{ route('forum-subscriber.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> {{ $forumSubscriber->id }}</p>
                            <p><strong>User:</strong> {{ $forumSubscriber->user->name ?? 'N/A' }}</p>
                            <p><strong>Forum:</strong> {{ $forumSubscriber->forum->name ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Subscription Type:</strong> {{ $forumSubscriber->subscription_type }}</p>
                            <p><strong>Created At:</strong> {{ $forumSubscriber->created_at ? $forumSubscriber->created_at->format('M d, Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('forum-subscriber.edit', $forumSubscriber->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('forum-subscriber.destroy', $forumSubscriber->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection