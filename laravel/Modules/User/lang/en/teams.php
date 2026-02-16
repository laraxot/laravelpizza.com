<?php

declare(strict_types=1);

return array (
  'name' => 'Teams',
  'fields' => 
  array (
    'name' => 
    array (
      'label' => 'Name',
      'placeholder' => 'Enter team name',
      'helper_text' => 'Team identifying name',
      'description' => 'The name that identifies this team',
      'tooltip' => '',
    ),
    'personal_team' => 
    array (
      'label' => 'Personal Team',
      'helper_text' => 'Indicates if this is a personal team',
      'description' => 'A personal team is associated with a single user',
      'tooltip' => '',
    ),
    'owner' => 
    array (
      'label' => 'Owner',
      'helper_text' => 'Team owner user',
      'description' => 'The user who created and manages this team',
      'tooltip' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Created At',
      'helper_text' => 'Team creation date',
      'description' => 'Date and time when the team was created',
      'tooltip' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Last Modified',
      'helper_text' => 'Last modification date',
      'description' => 'Date and time of the last team modification',
      'tooltip' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'New Team',
      'tooltip' => 'Create a new team',
    ),
    'edit' => 
    array (
      'label' => 'Edit',
      'tooltip' => 'Edit team data',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'tooltip' => 'Delete team',
    ),
    'view' => 
    array (
      'label' => 'View',
      'tooltip' => 'View team details',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Team created successfully',
      'updated' => 'Team updated successfully',
      'deleted' => 'Team deleted successfully',
    ),
    'error' => 
    array (
      'create' => 'Error while creating team',
      'update' => 'Error while updating team',
      'delete' => 'Error while deleting team',
    ),
    'confirm' => 
    array (
      'delete' => 'Are you sure you want to delete this team?',
    ),
  ),
  'relationships' => 
  array (
    'members' => 
    array (
      'label' => 'Members',
      'description' => 'Users who are part of this team',
    ),
    'owner' => 
    array (
      'label' => 'Owner',
      'description' => 'User who created this team',
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Missing Navigation Label',
    'plural_label' => 'Missing Navigation Plural Label',
    'group' => 'Missing Group',
    'icon' => 'heroicon-o-puzzle-piece',
    'sort' => 100,
  ),
  'label' => 'Missing Label',
  'plural_label' => 'Missing Plural label',
);
