#!/usr/bin/env bash
branch_name=$(git symbolic-ref -q HEAD)
branch_name=${branch_name##refs/heads/}
branch_name=${branch_name:-HEAD}
ARG1=${1:-$branch_name}
echo "git fetching ..."
git fetch
echo 'go to git branch ->' $ARG1
git checkout $ARG1
echo 'git pull' $ARG1
git pull origin $ARG1
echo "update composer"
composer update
echo "yii migration"
php console/yii migrate
