@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Create Forum Subscriber</h4>
                    <a href="{{ route('forum-subscriber.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum-subscriber.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">User:</label>
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="forum_id">Forum:</label>
                            <select name="forum_id" id="forum_id" class="form-control" required>
                                <option value="">Select Forum</option>
                                @foreach($forums as $forum)
                                <option value="{{ $forum->id }}">{{ $forum->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subscription_type">Subscription Type:</label>
                            <select name="subscription_type" id="subscription_type" class="form-control" required>
                                <option value="">Select Type</option>
                                <option value="daily">Daily Digest</option>
                                <option value="weekly">Weekly Digest</option>
                                <option value="instant">Instant Notifications</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Created At:</label>
                            <input type="datetime-local" name="created_at" id="created_at" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection