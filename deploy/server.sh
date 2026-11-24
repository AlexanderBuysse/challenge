#!/bin/sh
set -eu
umask 022
test -z "${SSH_ORIGINAL_COMMAND:-}"
root="$HOME/domains/alexanderbuysse.be/public_html"
checkout="$HOME/repositories/challenge"
lock="$HOME/.deploy-challenge.lock"
mkdir "$lock"
trap 'rmdir "$lock"' EXIT
trap 'exit 1' HUP INT TERM

mkdir -p "$HOME/repositories"
if [ ! -d "$checkout/.git" ]; then
  git clone -b main github-challenge:AlexanderBuysse/challenge.git "$checkout"
fi
cd "$checkout"
git fetch origin main
git reset --hard FETCH_HEAD
sh deploy/check.sh

site="$root/challenge"
mkdir -p "$site"
rsync -a --delete --include='/.htaccess' --include='/.user.ini' \
  --exclude='/.git/' --exclude='/.github/' --exclude='/deploy/' \
  --exclude='/README.md' --exclude='/assets/uploads/' "$checkout/" "$site/"

rule='RewriteRule ^challenge(?:/|$) - [L]'
if ! grep -Fxq "$rule" "$root/.htaccess"; then
  backup="$HOME/.htaccess.before-challenge-$(date +%s)"
  cp -p "$root/.htaccess" "$backup"
  next=$(mktemp "$root/.htaccess.challenge.XXXXXX")
  { printf 'RewriteEngine On\n%s\n' "$rule"; cat "$backup"; } > "$next"
  chmod --reference="$backup" "$next"
  mv -f "$next" "$root/.htaccess"
fi
printf 'Published challenge at '
git rev-parse HEAD
