git submodule foreach $( readlink -f -- "$0"; );
git fsck --full --unreachable
git filter-branch -- --all
git reflog expire --all --expire=now
git pack-refs --all --prune
git repack -A -d
git prune
git gc --auto --aggressive
git gc --aggressive --prune=now --force
git gc --prune=now --aggressive
#read -p "Press [Enter] key to exit..."
echo "-------- END PRUNE[$(pwd)] ----------";

