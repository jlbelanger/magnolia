#!/bin/bash
set -e

APP_NAME=$(basename "${PWD}")

source "${HOME}/Websites/infrastructure/deploy/config.sh"
source "${HOME}/Websites/infrastructure/deploy/composer.sh"
source "${HOME}/Websites/infrastructure/deploy/etc.sh"
source "${HOME}/Websites/infrastructure/deploy/git.sh"
source "${HOME}/Websites/infrastructure/deploy/static.sh"
source "${HOME}/Websites/infrastructure/deploy/laravel.sh"

check_git_branch
check_git_changes
build_static
deploy_git
deploy_composer
deploy_laravel
clear_laravel_cache
create_uploads_folder
