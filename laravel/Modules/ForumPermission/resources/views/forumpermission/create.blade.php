@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Create Forum Permission</h4>
                    <a href="{{ route('forum-permission.index') }}" class="btn btn-secondary btn-sm float-right">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('forum-permission.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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
                            <label for="role_id">Role:</label>
                            <select name="role_id" id="role_id" class="form-control" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <h5>Post Permissions</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_create_post" id="can_create_post">
                                    <label class="form-check-label" for="can_create_post">Create Post</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_edit_post" id="can_edit_post">
                                    <label class="form-check-label" for="can_edit_post">Edit Post</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_delete_post" id="can_delete_post">
                                    <label class="form-check-label" for="can_delete_post">Delete Post</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Thread Permissions</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_create_thread" id="can_create_thread">
                                    <label class="form-check-label" for="can_create_thread">Create Thread</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_edit_thread" id="can_edit_thread">
                                    <label class="form-check-label" for="can_edit_thread">Edit Thread</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_delete_thread" id="can_delete_thread">
                                    <label class="form-check-label" for="can_delete_thread">Delete Thread</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col-md-6">
                                <h5>Reply Permissions</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_reply" id="can_reply">
                                    <label class="form-check-label" for="can_reply">Reply</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_edit_reply" id="can_edit_reply">
                                    <label class="form-check-label" for="can_edit_reply">Edit Reply</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_delete_reply" id="can_delete_reply">
                                    <label class="form-check-label" for="can_delete_reply">Delete Reply</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Moderation Permissions</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="can_moderate" id="can_moderate">
                                    <label class="form-check-label" for="can_moderate">Moderate</label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection