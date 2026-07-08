 git pull --force --rebase && rm composer.lock || echo "composer.lock not exists" && composer update -W && composer analyse
git config core.fileMode false
git pull --force --rebase 
rm composer.lock || echo "composer.lock not exists" 
composer update -W 
composer analyse
