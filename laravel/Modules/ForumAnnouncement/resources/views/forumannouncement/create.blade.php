@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Create Forum Announcement</h4>
                    <a href="{{ route('forum-announcement.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum-announcement.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="author_id">Author:</label>
                            <select name="author_id" id="author_id" class="form-control" required>
                                <option value="">Select Author</option>
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
                            <label for="is_active">Active:</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="starts_at">Starts At:</label>
                            <input type="datetime-local" name="starts_at" id="starts_at" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="ends_at">Ends At:</label>
                            <input type="datetime-local" name="ends_at" id="ends_at" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection