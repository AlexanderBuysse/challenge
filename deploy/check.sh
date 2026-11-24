#!/bin/sh
set -eu
find index.php controller dao view deploy -name '*.php' -exec sh -c 'for file do php -l "$file" || exit 1; done' sh {} +
tmp=$(mktemp -d)
trap 'rm -rf "$tmp"' EXIT
php deploy/init-db.php "$tmp/challenge.sqlite"
test -s "$tmp/challenge.sqlite"
CHALLENGE_DB="$tmp/challenge.sqlite" php -r '
$_SERVER["SCRIPT_NAME"] = "/index.php";
$_SERVER["REQUEST_METHOD"] = "GET";
$_GET = ["page" => "feed", "choice" => "all"];
require "index.php";
' > "$tmp/feed.html"
grep -q 'alle pogingen' "$tmp/feed.html"
test -s css/style.css
test -s assets/img/kokknop.svg
