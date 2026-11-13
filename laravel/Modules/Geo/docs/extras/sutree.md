# Sutree

git subtree pull -P bashscripts git@github.com:aurmich/bashscripts_fila5.git dev
git subtree split -P bashscripts -b  bashscripts-temp
git fetch git@github.com:aurmich/bashscripts_fila5.git dev
git subtree merge --prefix=bashscripts bashscripts-temp --squash
- Can't squash-merge: 'bashscripts' was never added.
git subtree merge --prefix=bashscripts bashscripts-temp
- fatal: refusing to merge unrelated histories
git subtree merge --prefix=bashscripts bashscripts-temp --rejoin
- fatal: refusing to merge unrelated histories
git merge -s subtree bashscripts-temp --allow-unrelated-histories
git subtree merge --prefix=bashscripts bashscripts-temp --rejoin
- Already up to date.
