#!/bin/sh
if [ "$1" ]; then
     echo yes
else
    echo 'aggiungere il branch ./bashscripts/git_init.sh  <branch>'
    exit 1
fi
me=$( readlink -f -- "$0";)
branch=$1
where=$(pwd)
git submodule foreach "$me" "$branch"
find . -type f -name "*:Zone.Identifier" -exec rm -f {} \;
git config pull.rebase true
git config remote.origin.push HEAD
git config core.autocrlf true
git config core.safecrlf false
git config core.ignorecase false
git config submodule.recurse true
git config core.fileMode false
git config advice.skippedCherryPicks false
git remote set-branches --add origin $branch
git push --recurse-submodules=on-demand
git branch --set-upstream-to=origin/$branch $branch
git config advice.setUpstreamFailure false
sed -i -e 's/\r$//' "$me"

