@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Forum Template</h4>
                    <a href="{{ route('forum-template.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum-template.update', $forumTemplate->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $forumTemplate->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ $forumTemplate->description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="content">Content:</label>
                            <textarea name="content" id="content" class="form-control" rows="5" required>{{ $forumTemplate->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="author_id">Author:</label>
                            <select name="author_id" id="author_id" class="form-control" required>
                                <option value="">Select Author</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $forumTemplate->author_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="forum_id">Forum:</label>
                            <select name="forum_id" id="forum_id" class="form-control" required>
                                <option value="">Select Forum</option>
                                @foreach($forums as $forum)
                                <option value="{{ $forum->id }}" {{ $forumTemplate->forum_id == $forum->id ? 'selected' : '' }}>{{ $forum->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="is_active">Active:</label>
                            <select name="is_active" id="is_active" class="form-control">
                                <option value="1" {{ $forumTemplate->is_active ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ !$forumTemplate->is_active ? 'selected' : '' }}>No</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection