# GitHub Action: Sync Subtrees

This GitHub Action automatically synchronizes subtrees in the repository.

## How it works

The action is triggered on a schedule (daily at midnight) or can be run manually. It performs the following steps:

1.  **Parses `gitmodules.ini`**: The action reads the `gitmodules.ini` file to get the list of subtrees.
2.  **Syncs subtrees**: For each subtree, the action runs `git subtree pull` to pull the latest changes from the remote repository. If the subtree directory does not exist, it runs `git subtree add` to add it.
3.  **Pushes changes**: After all subtrees are synced, the action pushes the changes to the repository.

## How to use

The action is already configured and will run automatically. No further action is required.

## How to add a new subtree

To add a new subtree, you need to edit the `gitmodules.ini` file and add a new entry. For example:

```ini
[submodule "laravel/Modules/NewModule"]
    path = laravel/Modules/NewModule
    url = git@github.com:provtv/module_newmodule_fila5.git
```

The action will automatically pick up the new subtree and add it to the repository on the next run.
