@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Forum Announcement</h4>
                    <a href="{{ route('forum-announcement.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum-announcement.update', $forumAnnouncement->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ $forumAnnouncement->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required>{{ $forumAnnouncement->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="author_id">Author:</label>
                            <select name="author_id" id="author_id" class="form-control" required>
                                <option value="">Select Author</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $forumAnnouncement->author_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="forum_id">Forum:</label>
                            <select name="forum_id" id="forum_id" class="form-control" required>
                                <option value="">Select Forum</option>
                                @foreach($forums as $forum)
                                <option value="{{ $forum->id }}" {{ $forumAnnouncement->forum_id == $forum->id ? 'selected' : '' }}>{{ $forum->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_active">Active:</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ $forumAnnouncement->is_active ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$forumAnnouncement->is_active ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="starts_at">Starts At:</label>
                            <input type="datetime-local" name="starts_at" id="starts_at" class="form-control" value="{{ $forumAnnouncement->starts_at ? $forumAnnouncement->starts_at->format('Y-m-d\TH:i') : '' }}">
                        </div>
                        <div class="form-group">
                            <label for="ends_at">Ends At:</label>
                            <input type="datetime-local" name="ends_at" id="ends_at" class="form-control" value="{{ $forumAnnouncement->ends_at ? $forumAnnouncement->ends_at->format('Y-m-d\TH:i') : '' }}">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection