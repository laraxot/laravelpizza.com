#!/bin/sh
if [ "$1" ]; then
     echo yes
else
    echo 'aggiungere il branch ./bashscripts/git_delete_history_recursive.sh  <branch>'
    exit 1
fi
me=$( readlink -f -- "$0";)
branch=$1
where=$(pwd)
git submodule foreach "$me" "$branch"
git checkout --orphan newBranch$branch
git add --renormalize -A
git add -A  # Add all files and commit them
git commit -am "first"
git branch -D $branch  # Deletes the $1 branch
git branch -m $branch  # Rename the current branch to $1
git gc --aggressive --prune=all     # remove the old files
git push -uf origin $branch  # Force push $1 branch to github
git gc --aggressive --prune=all     # remove the old files
git gc --auto
echo "-------- END [$where ($branch)] ----------";
